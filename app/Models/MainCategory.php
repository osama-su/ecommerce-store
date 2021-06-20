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

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
    public function scopeSelection($query)
    {
        return $query->select('id', 'translation_language','translation_of', 'name', 'slug', 'photo', 'active');
    }
    public function getActive()
    {
        return $this->active == 1 ? 'on' : 'off';
    }
    public function getPhotoAttribute($val)
    {
        return $val !== null ? asset('../assets/'.$val) : "";
    }
    public function categories()
    {
        return $this->hasMany(self::class,foreignKey:'translation_of');
    }
    public function vendors()
    {
        return $this-> hasMany('App\Models\Vendor','category_id','id');
    }
}
