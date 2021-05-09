<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePost;
use App\Http\Requests\UpdatePost;
use App\Models\Post;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Throwable;

class PostController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:create-post')->only('create', 'store');
        $this->middleware('permission:read-post')->only('index', 'show');
        $this->middleware('permission:update-post')->only('edit', 'update');
        $this->middleware('permission:delete-post')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $posts = Post::with('user')->filter($request->all())->sortable()->paginate($request->get('limit') ?? config('app.per_page'));
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function store(CreatePost $request)
    {
        // Retrieve the validated input data...
        $validated = $request->validated();

        $post = new Post();
        $post->author_id = auth()->user()->id;
        $post->title = $validated['title'];
        $post->status = $validated['status'];

        if (isset($validated['featured'])) {
            $post->featured = $validated['featured'];
        }

        $post->save();

        $body = $validated['body'];

        if ($body) {
            $dom = new \DomDocument();
            $dom->loadHtml($body, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            $images = $dom->getElementsByTagName('img');

            foreach($images as $img){
                $data = $img->getAttribute('src');
                list($type, $data) = explode(';', $data);
                list($type, $data) = explode(',', $data);
                $data = base64_decode($data);
                $image_name = "/uploads/posts/" . $post->id . "/body/" . uniqid() . '-' . now()->timestamp . '.png';
                Storage::disk('local')->put($image_name, $data);
                $img->removeAttribute('src');
                $img->setAttribute('src', $image_name);
            }

            $body = $dom->saveHTML();
            $post->body = $body;
        }

        $path = $request->hasFile('image') ? $request->file('image')->store('uploads/posts/' . $post->id) : null;

        if ($path) {
            $post->image = $path;
        }

        $post->update();

        alert()->success('Success', 'Post created!');
        return redirect(route('posts.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param Post $post
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show($slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $slug
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();

        if (!Auth::user()->hasRole('admin') && $post->author_id != auth()->user()->id) {
            abort(403);
        }

        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdatePost $request
     * @param $slug
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function update(UpdatePost $request, $slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();

        if (!Auth::user()->hasRole('admin') && $post->author_id != auth()->user()->id) {
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
            $dom = new \DomDocument();
            $dom->loadHtml($body, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            $images = $dom->getElementsByTagName('img');

            foreach($images as $img){
                $data = $img->getAttribute('src');
                list($type, $data) = explode(';', $data);
                list($type, $data) = explode(',', $data);
                $data = base64_decode($data);
                $image_name = "/uploads/posts/" . $post->id . "/body/" . uniqid() . '-' . now()->timestamp . '.png';
                Storage::disk('local')->put($image_name, $data);
                $img->removeAttribute('src');
                $img->setAttribute('src', $image_name);
            }

            $body = $dom->saveHTML();
            $post->body = $body;
        }

        $path = $request->hasFile('image') ? $request->file('image')->store('uploads/posts/' . $post->id) : null;

        if ($path) {
            $post->image = $path;
        }

        $post->update();

        alert()->success('Success', 'Post created!');
        return redirect(route('posts.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Post $post
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $post = Post::findOrFail($id);

            if (!Auth::user()->hasRole('admin') && $post->author_id != auth()->user()->id) {
                abort(403);
            }

            $post->delete();

            $response = [
                'success' => true,
                'error' => false,
                'data' => $post,
                'message' => '',
            ];
        } catch (Exception | Throwable $e) {
            $response = [
                'success' => false,
                'error' => true,
                'data' => null,
                'message' => $e->getMessage(),
            ];
        }

        return response()->json($response);
    }

}
