<?php

namespace App\Http\Controllers;
use App\Models\Order;
use App\Notifications\OrderStatusUpdated;

class UserController extends Controller
{
    public function showProfile(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        $user = auth()->user();
        return view('user.profile', compact('user'));
    }

    public function showOrders(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        $orders = auth()->user()->orders;
        return view('user.orders.index', compact('orders'));
    }

    public function updateOrderStatus(Order $order): \Illuminate\Http\RedirectResponse
    {
        $order->status = 'completed';
        $order->save();

        $order->user->notify(new OrderStatusUpdated($order));

        return redirect()->route('user.orders.index');
    }


}
