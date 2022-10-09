<?php

namespace App\Http\Livewire\Categories;

use App\Models\Category;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Create extends Component
{
    use LivewireAlert;
    
    public $listeners = ['createCategory'];
    
    public $createCategory;
    
    public array $rules = [
        'category.code' => '',
        'category.name' => 'required',
    ];

    public function mount(Category $category)
    {
        $this->category = $category;
    }

    public function render()
    {
        abort_if(Gate::denies('access_product_categories'), 403);

        return view('livewire.categories.create');
    }

    public function createCategory()
    {
        $this->resetErrorBag();

        $this->resetValidation();

        $this->createCategory = true;
    }

    public function create()
    {
        $this->validate();

        $this->category->save();

        $this->emit('refreshIndex');
        
        $this->alert('success', 'Category created successfully.');
        
        $this->createCategory = false;
    }
}
