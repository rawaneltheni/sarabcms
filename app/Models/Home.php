<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Home extends Model
{
    protected $table = 'home_sliders';

    protected $fillable = [
        'image',
        'h1',
        'h2',
        'body',
        'btn_text',
        'btn_link',
        'order',
    ];
}
