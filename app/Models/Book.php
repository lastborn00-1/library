<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'book_type',
        'title',
        'author',
        'isbn',
        'category',
        'department_id',
        'quantity',
        'available_quantity',
        'shelf_location',
        'cover_image',
        'pdf_file',
        'abstract',
    ];

    /**
     * Get the department this book belongs to.
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
