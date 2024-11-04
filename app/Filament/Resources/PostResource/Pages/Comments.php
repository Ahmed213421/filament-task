<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use App\Models\Post;
use Filament\Resources\Pages\Page;

class Comments extends Page
{
    protected static string $resource = PostResource::class;

    protected static string $view = 'filament.resources.post-resource.pages.comments';

    public Post $post;

    public function mount($record): void
    {
        $this->post = Post::findOrFail($record); // Retrieve the post by ID
    }

}
