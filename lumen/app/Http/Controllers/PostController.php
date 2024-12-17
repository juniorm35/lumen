<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post; // Asegúrate de crear el modelo Post (lo veremos en el siguiente paso)

class PostController extends Controller
{
    // Obtener todos los posts
    public function index()
    {
        return response()->json(Post::all());
    }

    // Crear un nuevo post
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string',
            'content' => 'required|string',
        ]);

        $post = Post::create([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
        ]);

        return response()->json($post, 201);
    }

    // Obtener un post por ID
    public function show($id)
    {
        $post = Post::find($id);

        if (!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }

        return response()->json($post);
    }

    // Actualizar un post por ID
    public function update(Request $request, $id)
    {
        $post = Post::find($id);

        if (!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }

        $post->update($request->all());

        return response()->json($post);
    }

    // Eliminar un post por ID
    public function destroy($id)
    {
        $post = Post::find($id);

        if (!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }

        $post->delete();

        return response()->json(['message' => 'Post deleted successfully']);
    }
}
