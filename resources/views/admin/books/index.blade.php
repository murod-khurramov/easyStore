<?php
@extends('layouts.admin')

@section('content')
    <h2>Kitoblar Ro'yxati</h2>
    <a href="{{ route('admin.books.create') }}">Yangi kitob qo'shish</a>
    <table>
        <thead>
        <tr>
            <th>Nom</th>
            <th>Muallif</th>
            <th>Kategoriya</th>
            <th>Mavjud</th>
            <th>Rasm</th>
            <th>Amallar</th>
        </tr>
        </thead>
        <tbody>
        @foreach($books as $book)
            <tr>
                <td>{{ $book->title }}</td>
                <td>{{ $book->author }}</td>
                <td>{{ $book->category->name }}</td>
                <td>{{ $book->stock }}</td>
                <td>
                    @if($book->image_path)
                        <img src="{{ asset('storage/'.$book->image_path) }}" width="100" alt="Book Image">
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.books.edit', $book->id) }}">Tahrirlash</a>
                    <form action="{{ route('admin.books.destroy', $book->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit">O'chirish</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
@extends('layouts.app')

@section('content')
    <h2>Savat</h2>

    @foreach($cartItems as $item)
        <div>
            <p>{{ $item->book->title }} - {{ $item->quantity }} ta</p>
            <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit">O'chirish</button>
            </form>
        </div>
    @endforeach
@endsection

<form action="{{ route('admin.books.search') }}" method="GET">
    <input type="text" name="query" placeholder="Kitobni qidirish..." required>
    <button type="submit">Qidirish</button>
</form>

@foreach ($books as $book)
    <div>
        <h3>{{ $book->title }}</h3>
        <p>{{ $book->author }}</p>
        <p>{{ $book->price }} so'm</p>
        @if($book->image)
            <img src="{{ asset('storage/' . $book->image) }}" alt="{{ $book->title }}" width="100">
        @endif
    </div>
@endforeach

<form action="{{ route('admin.books.index') }}" method="GET">
    <select name="category">
        <option value="">Barchasini ko'rsatish</option>
        @foreach ($categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
        @endforeach
    </select>
    <button type="submit">Filterlash</button>
</form>

<h2>Buyurtmalarim</h2>
@foreach ($orders as $order)
    <div>
        <h3>Buyurtma #{{ $order->id }}</h3>
        <p>Status: {{ $order->status }}</p>
        <p>Sana: {{ $order->created_at->format('d-m-Y') }}</p>
    </div>
@endforeach

<h2>Foydalanuvchilar</h2>
@foreach ($users as $user)
    <div>
        <p>{{ $user->name }} - {{ $user->email }}</p>
        <a href="{{ route('admin.users.edit', $user->id) }}">Tahrirlash</a>
    </div>
@endforeach
