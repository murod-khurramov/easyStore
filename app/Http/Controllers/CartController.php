<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart(Request $request, $bookId): \Illuminate\Http\RedirectResponse
    {
        $book = Book::findOrFail($bookId);

        $cartItem = Cart::where('user_id', auth()->id())
            ->where('book_id', $bookId)
            ->first();

        if ($cartItem) {
            $cartItem->quantity += 1;
            $cartItem->save();
        } else {
            Cart::create([
                'user_id' => auth()->id(),
                'book_id' => $bookId,
                'quantity' => 1,
            ]);
        }

        return redirect()->route('cart.index');
    }

    public function index(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        $cartItems = Cart::with('book')->where('user_id', auth()->id())->get();
        return view('cart.index', compact('cartItems'));
    }

    public function removeFromCart($cartId): \Illuminate\Http\RedirectResponse
    {
        $cartItem = Cart::findOrFail($cartId);
        $cartItem->delete();

        return redirect()->route('cart.index');
    }

    public function checkout(): \Illuminate\Http\RedirectResponse
    {
        $cartItems = Cart::where('user_id', auth()->id())->get();

        $order = Order::create([
            'user_id' => auth()->id(),
            'status' => 'pending',
        ]);

        foreach ($cartItems as $item) {
            $order->books()->attach($item->book_id, ['quantity' => $item->quantity]);
            $item->delete();
        }

        return redirect()->route('orders.index');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cart $cart)
    {
        //
    }
}
