<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{

    public function index()
    {
        $perPage = 20;
        $posts = Post::paginate($perPage);

        return view('admin.posts.index', compact('posts'));
    }


    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();

        return view('admin.posts.create', [
            'categories'    => $categories,
            'tags'          => $tags,
        ]);
    }


    public function store(Request $request)
    {

        $request->validate([
            'title'         => 'required|string|max:100',
            'slug'          => 'required|string|max:100|unique:posts',
            'category_id'   => 'required|integer|exists:categories,id',
            'tags'          => 'nullable|array',
            'tags.*'        => 'integer|exists:tags,id',
            'image'         => 'required_without:content|nullable|url',
            'content'       => 'required_without:image|nullable|string|max:5000',
            'excerpt'       => 'nullable|string|max:200',
        ]);

        $data = $request->all() + [
            'user_id' => Auth::id(),
        ];

        dump($data);

        // salvataggio
        $post = Post::create($data);
        $post->tags()->sync($data['tags']);

        return redirect()->route('admin.posts.show', ['post' => $post->id]);
        // redirect
    }


    public function show(Post $post)
    {
        // $user = $post->users()->first();
        // $category = $post->categories()->first();

        return view('admin.posts.show', compact('post'));
    }


    public function edit(Post $post)
    {
        return view('admin.posts.edit', compact('post'));
    }


    public function update(Request $request, Post $post)
    {
        //
    }


    public function destroy(Post $post)
    {
        //
    }
}
