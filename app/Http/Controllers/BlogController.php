<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;

class BlogController extends Controller
{
    public function index()
    {
        $posts = BlogPost::query()
            ->published()
            ->with('category')
            ->latest('published_at')
            ->paginate(12);

        return view('pages.blog.index', [
            'posts' => $posts,
            'seoTitle' => __('Blog'),
            'seoDescription' => __('News and insights from Egyptra.'),
        ]);
    }

    public function show(string $locale, BlogPost $post)
    {
        $post->load('category');

        return view('pages.blog.show', [
            'post' => $post,
            'seoTitle' => $post->seoTitle(),
            'seoDescription' => $post->seoDescription(),
            'seoImage' => $post->ogImageUrl(),
        ]);
    }
}
