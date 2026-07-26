<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Department extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'code',
        'description',
        'status',
    ];

    /**
     * Get all books belonging to this department.
     */
    public function books()
    {
        return $this->hasMany(Book::class);
    }

    /**
     * Get all e-resource materials belonging to this department.
     */
    public function materials()
    {
        return $this->hasMany(DepartmentalMaterial::class);
    }

    /**
     * Scope: Only active departments.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
