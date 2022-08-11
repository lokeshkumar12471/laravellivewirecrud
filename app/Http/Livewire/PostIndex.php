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
    public $oldImage;
    public $isEditMode;
    public $post;
    public function showPostModal()
    {
        $this->reset();
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
    public function showEditPostModal($id)
    {
        $this->post = Post::FindOrFail($id);
        $this->title = $this->post->title;
        $this->body = $this->post->body;
        $this->oldImage = $this->post->image;
        $this->isEditMode = true;
        $this->showingPostModal = true;
    }
    public function updatePost()
    {
        $this->validate([
            'title' => 'required',
            'body' => 'required',
        ]);
        $image = $this->post->image;
        if ($this->newImage) {
            $image = $this->newImage->store('public/posts');
        }
        $this->post->update([
            'title' => $this->title,
            'image' => $image,
            'body' => $this->body,

        ]);
        $this->reset();
    }
    public function deletePost($id)
    {
        $post = Post::findOrFail($id)->delete();
        $post->delete();
        $this->reset();
    }
    public function render()
    {
        return view('livewire.post-index', ['posts' => Post::all()]);
    }
}