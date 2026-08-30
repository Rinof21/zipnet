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
        'tanggal_surat',
        'is_public',
        'is_private_to_uploader'
    ];
    protected $casts = [
        'tags' => 'array',
        'tanggal_surat' => 'date',
        'is_public' => 'boolean',
        'is_private_to_uploader' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function attachments()
    {
        return $this->hasMany(DocumentAttachment::class);
    }
}
