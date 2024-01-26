<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainCategory extends Model
{
    use HasFactory;

    // protected $fillable = [
    //     'name',
    //     'translation_lang',
    //     'translation_of',
    //     'slug',
    //     'photo',
    //     'active',
    // ];

public function scopeSelection($query){
    return $query ->select([
        'name_' . App()->getLocale() . ' as name',
        'translation_lang',
        'slug_' . app()->getlocale() . ' as slug',
        'active',
        'created_at',
    ]);
}
}
