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
    ];

    public function document()
    {
        return $this->belongsTo(Document::class);
    }
}
