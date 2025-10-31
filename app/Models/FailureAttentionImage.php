<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FailureAttentionImage extends Model
{
    use HasFactory;

    protected $fillable = ['failure_attention_id', 'image_url'];

    /**
     * La atención de falla a la que pertenece esta imagen.
     */
    public function failureAttention()
    {
        return $this->belongsTo(FailureAttention::class);
    }
}