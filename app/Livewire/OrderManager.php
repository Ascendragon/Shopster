<?php

namespace App\Livewire;

use App\Models\Order;
use App\Models\Product;
use Livewire\Component;
use Carbon\Carbon;

class OrderManager extends Component
{
    public $orders = [];
    public $products = [];
    public $product_id, $quantity = 1, $customer_fullname, $comment, $created_at, $status = 'new';
    public $orderId = null;
    public $isEditMode = false;

    protected $rules = [
        'product_id' => 'required|exists:products,id',
        'quantity' => 'required|integer|min:1',
        'customer_fullname' => 'required|string|max:255',
        'comment' => 'nullable|string|max:1000',
        'created_at' => 'required|date',
    ];

    public function mount()
    {
        $this->products = Product::with('category')->get();
        $this->orders = Order::with('product')->orderByDesc('orders.order_number')->get();
        $this->created_at = now()->format('Y-m-d');
    }

    public function resetForm()
    {
        $this->orderId = null;
        $this->product_id = '';
        $this->quantity = 1;
        $this->customer_fullname = '';
        $this->comment = '';
        $this->created_at = now()->format('Y-m-d');
        $this->status = 'new';
        $this->isEditMode = false;
    }

    public function save()
    {
        $this->validate();

        if ($this->isEditMode && $this->orderId) {
            $order = Order::find($this->orderId);
        } else {
            $order = new Order();
        }

        $order->product_id = $this->product_id;
        $order->quantity = $this->quantity;
        $order->customer_fullname = $this->customer_fullname;
        $order->comment = $this->comment;
        $order->created_at = $this->created_at;
        $order->status = $this->status ?? 'new';
        $product = Product::findOrFail($order->product_id);
        $order->total_price = $order->quantity * $product->price;
        $order->save();

        $this->resetForm();
        $this->orders = Order::with('product')->orderByDesc('orders.order_number')->get();
    }

    public function edit($order_number)
    {
        $order = Order::findOrFail($order_number);

        $this->orderId = $order->order_number;
        $this->product_id = $order->product_id;
        $this->quantity = $order->quantity;
        $this->customer_fullname = $order->customer_fullname;
        $this->comment = $order->comment;
        $this->created_at = Carbon::parse($order->created_at)->format('Y-m-d');
        $this->status = $order->status;
        $this->isEditMode = true;
    }

    public function delete($order_number)
    {
        Order::destroy($order_number);
        $this->orders = Order::with('product')->orderByDesc('orders.order_number')->get();
    }

    public function markDone($order_number)
    {
        $order = Order::findOrFail($order_number);
        $order->status = 'done';
        $order->save();
        $this->orders = Order::with('product')->orderByDesc('orders.order_number')->get();
    }

    public function render()
    {
        return view('livewire.order-manager');
    }
}
