<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormService extends Model
{
    use HasFactory;

    protected $table = 'form_service';

    protected $fillable = [
        'name',
    ];
}