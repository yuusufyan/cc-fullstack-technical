<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    use ApiResponse;
    public function index()
    {
        $posts = Post::with('user:id,name')->latest()->get();

        return $this->success($posts, 'Daftar post berhasil diambil');
    }

    public function show($id)
    {
        $posts = Post::with('user:id,name')->findOrFail($id);

        return $this->success($posts, 'Daftar post berhasil diambil');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $post = Post::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'user_id' => Auth::id(),
        ]);

        return $this->success($post, 'Post berhasil dibuat', 201);
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        if (!$post) {
            return $this->error('Post tidak ditemukan', 404);
        }

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'content' => 'sometimes|required|string',
        ]);

        $post->update($validated);

        return $this->success($post, 'Post berhasil diperbarui');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        if (!$post) {
            return $this->error('Post tidak ditemukan', 404);
        }

        $post->delete();

        return $this->success(null, 'Post berhasil dihapus');
    }
}
