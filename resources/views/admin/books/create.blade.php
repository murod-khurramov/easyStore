<?php
@extends('layouts.admin')

@section('content')
    <h2>Yangi Kitob Qo'shish</h2>
    <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div>
            <label for="title">Kitob nomi:</label>
            <input type="text" name="title" id="title" required>
        </div>
        <div>
            <label for="author">Muallif:</label>
            <input type="text" name="author" id="author" required>
        </div>
        <div>
            <label for="category_id">Kitob turi:</label>
            <select name="category_id" id="category_id" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="stock">Mavjud kitoblar soni:</label>
            <input type="number" name="stock" id="stock" required>
        </div>
        <div>
            <label for="image">Kitob rasmi:</label>
            <input type="file" name="image" id="image" required>
        </div>
        <button type="submit">Qo'shish</button>
    </form>
@endsection

<form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <label for="title">Kitob nomi:</label>
    <input type="text" name="title" id="title" required>

    <label for="author">Muallif:</label>
    <input type="text" name="author" id="author" required>

    <label for="price">Narx:</label>
    <input type="number" name="price" id="price" required>

    <label for="category_id">Kategoriya:</label>
    <select name="category_id" id="category_id" required>
        @foreach ($categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
        @endforeach
    </select>

    <label for="image">Rasm:</label>
    <input type="file" name="image" id="image">

    <button type="submit">Qo'shish</button>
</form>
