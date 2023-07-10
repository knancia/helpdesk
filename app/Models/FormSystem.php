<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormSystem extends Model
{
    use HasFactory;

    protected $table = 'form_system';

    protected $fillable = [
        'name',
    ];
}