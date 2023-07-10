<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HelpdeskForm extends Model
{
    use HasFactory;

    protected $table = 'helpdesk_form';

    protected $fillable = [
        'helpdesk_id',
        'users_id',
        'titulo',
        'descricao',
    ];
}