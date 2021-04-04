<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;
    protected $table = 'vendors';

    protected $fillable = [
        'name',
        'mobile',
        'address',
        'email',
        'logo',
        'category_id',
        'active',
        'created_at',
        'updated_at',
    ];
    protected $hidden = [
        'category_id',
    ];
    public function scopeActive($query)
    {
        $query -> where('active',1);
    }
    public function getActive()
    {
        return $this->active == 1 ? 'on' : 'off';
    }
    public function getLogoAttribute($val)
    {
        return $val !== null ? asset('../assets/'.$val) : "";
    }
    public function scopeSelection($query)
    {
       return $query->select('id','category_id','name','logo','mobile');
    }
    public function category()
    {
        return $this-> belongsTo('App/Models/MainCategory','category_id','id');
    }
}
