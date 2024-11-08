<?php

namespace App\Models;

use App\Http\Controllers\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'category_id',
        'quantity',
        'image',
    ];

    private static function find($id)
    {

    }

    public static function create(array $all)
    {

    }

    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    public function orders(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Order::class)->withPivot('quantity');
    }

    public static function findOrFail($id)
    {
        $book = Book::find($id); // find() orqali faqat null qaytadi, xatolik bo'lmaydi
        if (!$book) {
            return redirect()->route('admin.books.index')->with('error', 'Kitob topilmadi.');
        }
    }

    public function setImageAttribute($value): void
    {
        if ($value) {
            $this->attributes['image'] = $value->store('images', 'public');
        }
    }

}
