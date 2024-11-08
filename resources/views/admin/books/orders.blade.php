<?php
@foreach ($orders as $order)
    <tr>
        <td>{{ $order->id }}</td>
        <td>{{ $order->status }}</td>
        <td>
            @if ($order->status != 'completed')
                <form action="{{ route('user.orders.update-status', $order->id) }}" method="POST">
                    @csrf
                    <button type="submit">Holatni yangilash</button>
                </form>
            @endif
        </td>
    </tr>
@endforeach
