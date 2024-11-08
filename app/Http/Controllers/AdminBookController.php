<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class AdminBookController extends Controller
{
    public function index(Request $request): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        $category = $request->input('category');
        $books = Book::when($category, function($query) use ($category) {
            return $query->where('category_id', $category);
        })->get();

        return view('admin.books.index', compact('books'));
    }
    public function rate(Request $request, $id): \Illuminate\Http\RedirectResponse
    {
        $rating = new Rating();
        $rating->book_id = $id;
        $rating->user_id = auth()->id();
        $rating->rating = $request->input('rating');
        $rating->save();

        return back()->with('success', 'Baholash muvaffaqiyatli saqlandi');
    }



    public function create(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        $categories = Category::all();
        return view('admin.books.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $book = Book::create($request->all());

        if ($request->hasFile('image')) {
            $book->image = $request->file('image')->store('images', 'public');
            $book->save();
        }

        return redirect()->route('admin.books.index')->with('success', 'Kitob muvaffaqiyatli qo\'shildi');
    }


    public function destroy($id): \Illuminate\Http\RedirectResponse
    {
        $book = Book::findOrFail($id);
        $book->delete();

        return redirect()->route('admin.books.index')->with('success', 'Kitob muvaffaqiyatli o\'chirildi!');
    }

    public function show($id): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        $book = Book::findOrFail($id);
        return view('admin.books.show', compact('book'));
    }

    public function edit($id): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        $book = Book::findOrFail($id);
        return view('admin.books.edit', compact('book'));
    }

    public function update(Request $request, $id): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'price' => 'required|numeric',
        ]);

        $book = Book::findOrFail($id);
        $book->update($request->all());

        return redirect()->route('admin.books.index')->with('success', 'Kitob muvaffaqiyatli yangilandi');
    }

    public function search(Request $request): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        $query = $request->input('query');
        $books = Book::where('title', 'like', "%$query%")
            ->orWhere('author', 'like', "%$query%")
            ->get();

        return view('admin.books.index', compact('books'));
    }

    public function statistics(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        $totalBooks = Book::count();
        $highestPriceBook = Book::orderBy('price', 'desc')->first();
        $lowestPriceBook = Book::orderBy('price', 'asc')->first();

        return view('admin.books.statistics', compact('totalBooks', 'highestPriceBook', 'lowestPriceBook'));
    }


}
