<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainCategory extends Model
{
    use HasFactory;

    protected $table = 'main_categories';

    protected $fillable = [
        'translation_language',
        'translation_of',
        'name',
        'slug',
        'photo',
        'active',
        'created_at',
        'updated_at',
    ];

    public function scopeActive($query){
        return $query->where('active',1);
    }

}
