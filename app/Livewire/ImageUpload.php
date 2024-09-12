<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Rule;
use Livewire\WithFileUploads;
use App\Models\Post;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;

class ImageUpload extends Component
{
    public $postId;
    public $oldImage;
    use WithFileUploads;
    use WithPagination;
   #[Rule('image|max:2048')] // 2MB Max
    public $image;
  
    #[Rule('required|min:3')]
    public $title;

    public $isOpen = 0;
  
    public function create()
    {
        $this->openModal();
    }
    public function openModal()
    {
        $this->isOpen = true;
        $this->resetValidation();
    }
    public function closeModal()
    {
        $this->isOpen = false;
    }

    public function store()
    {
    $this->validate();
    Post::create([
        'title' => $this->title,
        'image' => $this->image->store('public/photos')
    ]);
    session()->flash('success', 'Image uploaded successfully.');
    $this->reset('title','image');
    $this->closeModal();
    }
    public function edit($id)
     {
      $post = Post::findOrFail($id);
      $this->postId = $id;
      $this->title = $post->title;
      $this->oldImage = $post->image;
 
      $this->openModal();
     }
     public function update()
    {  
     $this->validate();
     
     $post = Post::findOrFail($this->postId);
        $photo = $post->image;
            if($this->image)
            {
                Storage::delete($post->image);
                $photo = $this->image->store('public/photos');
            }else{
                $photo = $post->image;
            }
 
            $post->update([
                'title' => $this->title,
                'image' => $photo,
            ]);
            $this->postId='';
 
            session()->flash('success', 'Image updated successfully.');
            $this->closeModal();
            $this->reset('title', 'image', 'postId');
    }
    public function delete($id)
    {
        $singleImage = Post::findOrFail($id);
        Storage::delete($singleImage->image);
        $singleImage->delete();
        session()->flash('success','Image deleted Successfully!!');
        $this->reset('title','image');
    }
    
    public function render()
    {
        return view('livewire.image-upload',[
            'posts' => Post::paginate(5),
        ]);
    }


}
