<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Product;
use App\Models\Category;

class ProductManager extends Component
{
    public $products;
    public $categories;
    public $name, $category_id, $description, $price;
    public $productId = null;
    public $isEditMode = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'category_id' => 'required|exists:categories,id',
        'description' => 'nullable|string|max:1000',
        'price' => 'required|integer|min:0',

    ];

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        $this->products = Product::with('category')->orderByDesc('id')->get();
        $this->categories = Category::all();
    }

    public function resetForm()
    {
        $this->name = '';
        $this->category_id = '';
        $this->description = '';
        $this->price = '';
        $this->productId = null;
        $this->isEditMode = false;
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $this->productId = $product->id;
        $this->name = $product->name;
        $this->category_id = $product->category_id;
        $this->description = $product->description;
        $this->price = $product->price;
        $this->isEditMode = true;
    }

    public function save()
    {

        $this->validate();

        if ($this->isEditMode && $this->productId) {
            $product = Product::findOrFail($this->productId);
            $product->update([
                'name' => $this->name,
                'category_id' => $this->category_id,
                'description' => $this->description,
                'price' => $this->price,
            ]);
        } else {
            Product::create([
                'name' => $this->name,
                'category_id' => $this->category_id,
                'description' => $this->description,
                'price' => $this->price,
                'user_id' => Auth::user()->id
            ]);
        }

        $this->resetForm();
        $this->loadData();
    }
    public function delete($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        $this->loadData();
    }

    public function render()
    {
        return view('livewire.product-manager');
    }
}

