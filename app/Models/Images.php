<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Images extends Model
{
    use HasFactory;

    protected $table = 'images';

    protected $fillable = [
        'helpdesk_id',
        'helpdesk_form_id',
        'name',
        'path',
        'type',
        'size',
    ];
}