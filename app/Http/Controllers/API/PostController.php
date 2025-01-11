<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreatePost;
use App\Http\Requests\UpdatePost;
use App\Models\Post;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Throwable;

class PostController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $posts = Post::all();

        return $this->success(['posts' => $posts], 'Post Index');
    }

    public function store(CreatePost $request)
    {
        // Retrieve the validated input data...
        $validated = $request->validated();

        $post = new Post;
        $post->author_id = auth()->user()->id;
        $post->title = $validated['title'];
        $post->status = $validated['status'];
        $post->body = $validated['body'];

        if (isset($validated['featured'])) {
            $post->featured = $validated['featured'];
        }

        $post->save();

        $path = $request->hasFile('image') ? $request->file('image')->store('uploads/posts/'.$post->id) : null;

        if ($path) {
            $post->image = $path;
        }

        $post->update();

        return $this->success(['post' => $post], 'Post Created!');
    }

    public function show($slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();

        return $this->success(['post' => $post], 'Post Show!');
    }

    public function update(UpdatePost $request, $slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();

        if (! Auth::user()->hasRole('admin') && $post->author_id != auth()->user()->id) {
            abort(403);
        }

        // Retrieve the validated input data...
        $validated = $request->validated();

        if ($post->title != $validated['title']) {
            $post->slug = null;
        }

        $post->title = $validated['title'];
        $post->status = $validated['status'];

        if (isset($validated['featured'])) {
            $post->featured = $validated['featured'];
        }

        $body = $validated['body'];

        if ($body) {
            $dom = new \DomDocument;
            $dom->loadHtml($body, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            $images = $dom->getElementsByTagName('img');

            foreach ($images as $img) {
                $data = $img->getAttribute('src');
                [$type, $data] = explode(';', $data);
                [$type, $data] = explode(',', $data);
                $data = base64_decode($data);
                $image_name = '/uploads/posts/'.$post->id.'/body/'.uniqid().'-'.now()->timestamp.'.png';
                Storage::disk('local')->put($image_name, $data);
                $img->removeAttribute('src');
                $img->setAttribute('src', $image_name);
            }

            $body = $dom->saveHTML();
            $post->body = $body;
        }

        $path = $request->hasFile('image') ? $request->file('image')->store('uploads/posts/'.$post->id) : null;

        if ($path) {
            $post->image = $path;
        }

        $post->update();

        return $this->success(['post' => $post], 'Post Updated!');
    }

    public function destroy($id)
    {
        try {
            $post = Post::findOrFail($id);

            if (! Auth::user()->hasRole('admin') && $post->author_id != auth()->user()->id) {
                abort(403);
            }

            $post->delete();

            $response = [
                'success' => true,
                'error' => false,
                'data' => $post,
                'message' => '',
            ];
        } catch (Exception|Throwable $e) {
            $response = [
                'success' => false,
                'error' => true,
                'data' => null,
                'message' => $e->getMessage(),
            ];
        }

        return $this->success($response);
    }
}
