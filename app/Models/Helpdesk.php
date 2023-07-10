<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class Helpdesk extends Model
{
    use HasFactory;

    protected $table = 'helpdesk';

    protected $fillable = [
        'form_user_id',
        'form_system_id',
        'form_service_id',
        'form_status_id',
    ];

    public function images()
    {
        return $this->hasMany(Images::class);
    }

    public function form_user()
    {
        return $this->belongsTo(FormUser::class, 'form_user_id');
    }

    public function form_system()
    {
        return $this->belongsTo(FormSystem::class, 'form_system_id');
    }

    public function form_service()
    {
        return $this->belongsTo(FormService::class, 'form_service_id');
    }

    public function form_status()
    {
        return $this->belongsTo(FormStatus::class, 'form_status_id');
    }

    public function helpdesk_form()
    {
        return $this->belongsTo(HelpdeskForm::class, 'helpdesk_form_id');
    }

    public static function table(string|null $search, bool $paginate = true): Collection|LengthAwarePaginator
    {
        $data = self::with(['form_user', 'form_system', 'form_service', 'form_status', 'helpdesk_form'])
            ->join('form_user', 'helpdesk.form_user_id', '=', 'form_user.id')
            ->join('form_system', 'helpdesk.form_system_id', '=', 'form_system.id')
            ->join('form_service', 'helpdesk.form_service_id', '=', 'form_service.id')
            ->join('form_status', 'helpdesk.form_status_id', '=', 'form_status.id')
            ->join('helpdesk_form', 'helpdesk.id', '=', 'helpdesk_form.helpdesk_id')
            ->select('helpdesk.id', 'form_user.email', 'form_system.name as sistema', 'form_service.name as servico', 'form_status.name as status', 'helpdesk_form.titulo', 'helpdesk_form.descricao', 'helpdesk.created_at')
            ->orderBy("helpdesk.id", "asc")
            ->when($search, function ($query) use ($search) {
                return $query->where('titulo', 'like', "%$search%")
                    ->orWhere('form_user.email', 'like', "%$search%")
                    ->orWhere('form_system.name', 'like', "%$search%")
                    ->orWhere('form_service.name', 'like', "%$search%")
                    ->orWhere('form_status.name', 'like', "%$search%");
            })
            ->whereNotNull('helpdesk_form.titulo')
            // ->first()
            ;
    
        if ($paginate) {
            return $data->paginate()->appends('q', $search);
        }
    
        return $data->get();
    }
    
}