<?php

namespace App\Http\Controllers;

use App\Models\Helpdesk;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class AcompanharChamado extends Controller
{
    public function index(Helpdesk $helpdesk)
    {
        if($helpdesk->id) {
            $helpdesk = $helpdesk->join('form_user', 'helpdesk.form_user_id', '=', 'form_user.id')
                            ->join('form_system', 'helpdesk.form_system_id', '=', 'form_system.id')
                            ->join('form_service', 'helpdesk.form_service_id', '=', 'form_service.id')
                            ->join('form_status', 'helpdesk.form_status_id', '=', 'form_status.id')
                            ->join('helpdesk_form', 'helpdesk.id', '=', 'helpdesk_form.helpdesk_id')
                            ->join('users', 'helpdesk_form.users_id', '=', 'users.id', 'left')
                            ->where('helpdesk.id', $helpdesk->id)
                            ->select(
                                'helpdesk.id', 
                                'helpdesk.form_user_id', 
                                'helpdesk.form_system_id', 
                                'helpdesk.form_service_id', 
                                'helpdesk.form_status_id', 
                                'helpdesk.created_at', 
                                'form_user.email AS user_email', 
                                'form_system.name AS system_name', 
                                'form_service.name AS services_name', 
                                'form_status.name AS status_name',
                                'helpdesk_form.titulo',
                                'helpdesk_form.descricao',
                                'users.name',
                                'users.email',
                                )
                            ->get();

            $helpdesk->each(function ($item) {
                $item->images;
            });
    
            $images = $helpdesk->flatMap->images;

            return Inertia::render('AcompanharChamado/Index', compact('helpdesk', 'images'));
        }
        
        return Inertia::render('AcompanharChamado/Index');
    }
}