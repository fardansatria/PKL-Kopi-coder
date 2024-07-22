<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'price',
        'stock',
        'image',
        'merek_id',
    ];

    public function merek()
    {
        return $this->belongsTo(Merek::class);
    }
    
    public function ProductImages()
    {
        return $this->hasMany(ProductImage::class);
    }


}
