<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DefibrillatorTestImage extends Model
{
    use HasFactory;
    protected $fillable = ['defibrillator_test_id', 'image_url'];

    public function defibrillatorTest()
    {
        return $this->belongsTo(DefibrillatorTest::class);
    }
}