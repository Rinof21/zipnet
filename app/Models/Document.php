<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'title',
        'category_id',
        'nomor_surat',
        'perihal',
        'tags',
        'file_name',
        'file_path',
        'uploaded_by',
        'tanggal_surat'

    ];
    protected $casts = [
        'tags' => 'array',
        'tanggal_surat' => 'date',

    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
