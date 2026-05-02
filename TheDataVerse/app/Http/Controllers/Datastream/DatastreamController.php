<?php

namespace App\Http\Controllers\Datastream;

use App\Http\Controllers\Controller;
use App\Models\DatastreamPost;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class DatastreamController extends Controller
{
    public function index(): InertiaResponse
    {
        $posts = DatastreamPost::query()
            ->published()
            ->latest('published_at')
            ->paginate(9)
            ->through(fn (DatastreamPost $post) => [
                'id' => $post->id,
                'title' => $post->title,
                'slug' => $post->slug,
                'excerpt' => $post->excerpt,
                'published_at' => $post->published_at?->toISOString(),
            ]);

        return Inertia::render('Datastream/Index', [
            'posts' => $posts,
        ]);
    }

    public function show(DatastreamPost $datastreamPost): InertiaResponse
    {
        if (! $datastreamPost->isPublished() && ! auth()->check()) {
            abort(404);
        }

        return Inertia::render('Datastream/Show', [
            'post' => [
                'id' => $datastreamPost->id,
                'title' => $datastreamPost->title,
                'slug' => $datastreamPost->slug,
                'excerpt' => $datastreamPost->excerpt,
                'body_html' => $datastreamPost->body_html ?: nl2br(e($datastreamPost->body)),
                'status' => $datastreamPost->status,
                'published_at' => $datastreamPost->published_at?->toISOString(),
                'author' => [
                    'name' => $datastreamPost->author?->name,
                ],
            ],
        ]);
    }
}