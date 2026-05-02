<?php

namespace App\Http\Controllers\Datastream;

use App\Http\Controllers\Controller;
use App\Http\Requests\Datastream\StoreDatastreamPostRequest;
use App\Http\Requests\Datastream\UpdateDatastreamPostRequest;
use App\Models\DatastreamPost;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class ManageDatastreamController extends Controller
{
    public function index(): InertiaResponse
    {
        $posts = DatastreamPost::query()
            ->with('author')
            ->latest()
            ->paginate(12)
            ->through(fn (DatastreamPost $post) => [
                'id' => $post->id,
                'title' => $post->title,
                'slug' => $post->slug,
                'status' => $post->status,
                'published_at' => $post->published_at?->toISOString(),
                'created_at' => $post->created_at?->toISOString(),
                'author' => [
                    'name' => $post->author?->name,
                ],
            ]);

        return Inertia::render('Datastream/Manage/Index', [
            'posts' => $posts,
        ]);
    }

    public function create(): InertiaResponse
    {
        return Inertia::render('Datastream/Manage/Create');
    }

    public function store(StoreDatastreamPostRequest $request): RedirectResponse
    {
        $input = $request->validated();

        $status = $input['status'];
        $slugSource = $input['slug'] ?: $input['title'];

        DatastreamPost::create([
            'user_id' => auth()->id(),
            'title' => $input['title'],
            'slug' => $this->uniqueSlug($slugSource),
            'excerpt' => $input['excerpt'] ?? null,
            'body' => $input['body'],
            'status' => $status,
            'published_at' => $status === 'published' ? now() : null,
        ]);

        return redirect()
            ->route('dashboard.datastream.index')
            ->with('success', 'Datastream signal created.');
    }

    public function edit(DatastreamPost $datastreamPost): InertiaResponse
    {
        return Inertia::render('Datastream/Manage/Edit', [
            'post' => [
                'id' => $datastreamPost->id,
                'title' => $datastreamPost->title,
                'slug' => $datastreamPost->slug,
                'excerpt' => $datastreamPost->excerpt,
                'body' => $datastreamPost->body,
                'status' => $datastreamPost->status,
            ],
        ]);
    }

    public function update(
        UpdateDatastreamPostRequest $request,
        DatastreamPost $datastreamPost
    ): RedirectResponse {
        $input = $request->validated();

        $status = $input['status'];
        $slugSource = $input['slug'] ?: $input['title'];

        $datastreamPost->update([
            'title' => $input['title'],
            'slug' => $this->uniqueSlug($slugSource, $datastreamPost->id),
            'excerpt' => $input['excerpt'] ?? null,
            'body' => $input['body'],
            'status' => $status,
            'published_at' => $status === 'published'
                ? ($datastreamPost->published_at ?? now())
                : null,
        ]);

        return redirect()
            ->route('dashboard.datastream.index')
            ->with('success', 'Datastream signal updated.');
    }

    public function destroy(DatastreamPost $datastreamPost): RedirectResponse
    {
        $datastreamPost->delete();

        return redirect()
            ->route('dashboard.datastream.index')
            ->with('success', 'Datastream signal archived.');
    }

    private function uniqueSlug(string $source, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($source);

        if ($baseSlug === '') {
            $baseSlug = 'datastream-post';
        }

        $slug = $baseSlug;
        $suffix = 2;

        while (
            DatastreamPost::withTrashed()
                ->where('slug', $slug)
                ->when(
                    $ignoreId !== null,
                    fn ($query) => $query->whereKeyNot($ignoreId)
                )
                ->exists()
        ) {
            $slug = "{$baseSlug}-{$suffix}";
            $suffix++;
        }

        return $slug;
    }
}