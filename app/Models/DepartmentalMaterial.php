<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartmentalMaterial extends Model
{
    use HasFactory;

    protected $fillable = [
        'department_id',
        'title',
        'course_code',
        'description',
        'file_path',
        'file_type',
        'file_size',
        'allow_download',
        'downloads_count',
    ];

    protected $casts = [
        'allow_download' => 'boolean',
    ];

    /**
     * Get the department that owns this material.
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
