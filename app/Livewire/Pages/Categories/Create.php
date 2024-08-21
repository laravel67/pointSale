<?php

namespace App\Livewire\Pages\Categories;

use Livewire\Component;
use App\Models\Category;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

class Create extends Component
{
    use WithFileUploads;

    // define layout
    #[Layout('layouts.app')]
    // define title
    #[Title('Create Category')]

    // define property
    public $path = 'public/categories/';
    public $name;
    public $image;

    // define validation
    public function rules()
    {
        return [
            'name' => 'required|string|min:3|max:255|unique:categories',
            'image' => 'required|image|max:2048',
        ];
    }

    // define function save
    public function save()
    {
        // call validation
        $this->validate();

        // store image category
        $this->image->storeAs(path: $this->path, name: $this->image->hashName());

        // create new category data
        Category::create([
            'name' => $this->name,
            'slug' => str()->slug($this->name),
            'image' => $this->image->hashName(),
        ]);

        // render view
        return $this->redirect('/categories', navigate:true);
    }


    public function render()
    {
        return view('livewire.pages.categories.create');
    }
}