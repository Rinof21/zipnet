<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentAttachment extends Model
{
    protected $fillable = [
        'document_id',
        'file_name',
        'file_path',
        'file_size',
        'file_type',
        'is_link',
        'link_url',
    ];

    protected $casts = [
        'is_link' => 'boolean',
    ];

    public function isLink()
    {
        return $this->is_link || $this->file_type === 'link';
    }

    public function document()
    {
        return $this->belongsTo(Document::class);
    }
}
