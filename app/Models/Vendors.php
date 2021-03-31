<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendors extends Model
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
}
