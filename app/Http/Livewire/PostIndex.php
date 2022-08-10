<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithFileUploads;

class PostIndex extends Component
{
    use WithFileUploads;
    public $showingPostModal = false;
    public $newImage;
    public $body;
    public $title;
    public function showPostModal()
    {
        $this->showingPostModal = true;
    }
    public function storePost()
    {$this->validate([
        'title' => 'required',
        'body' => 'required',
        'newImage' => 'image',

    ]);

        $image = $this->newImage->store('public/posts');
        Post::create([
            'title' => $this->title,
            'image' => $image,
            'body' => $this->body,
        ]);
        $this->reset();

    }
    public function render()
    {
        return view('livewire.post-index', ['posts' => Post::all()]);
    }
}