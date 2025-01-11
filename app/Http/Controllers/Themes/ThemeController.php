<?php

namespace App\Http\Controllers\Themes;

use App\Http\Controllers\Controller;
use App\Models\Users\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ThemeController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $user = User::query()->find(auth()->user()->id);

        if (! $user) {
            response()->json(['status' => false, 'message' => __('messages.user_not_found')], 404);
        }

        $user->theme = $request->theme;
        $user->save();

        return response()->json(['status' => true, 'message' => __('messages.successfully_update_theme')]);
    }
}
