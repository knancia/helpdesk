<?php

namespace App\Http\Controllers;

use App\Models\Helpdesk;
use App\Models\HelpdeskForm;
use App\Models\FormService;
use App\Models\FormStatus;
use App\Models\FormSystem;
use App\Models\FormUser;
use App\Models\Images;
use Illuminate\Routing\Controller as Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AbrirChamado extends Controller
{
    public function index(Request $request)
    {
        $services = FormService::select('id', 'name')->get();
        $systems = FormSystem::select('id', 'name')->get();

        return inertia('AbrirChamado/Index', compact('services', 'systems'));
    }

    public function store(Request $request)
    {
        $user = FormUser::firstOrCreate(['email' => $request->email]);
        $status = FormStatus::where('name', 'Aberto')->value('id');
        
        $helpdesk = Helpdesk::Create([
            'form_user_id' => $user->id,
            'form_system_id' => $request->form_system_id,
            'form_service_id' => $request->form_service_id,
            'form_status_id' => $status,
        ]);
        
        $helpdesk_form = HelpdeskForm::Create([
            'helpdesk_id' => $helpdesk->id,
            'titulo' => $request->titulo,
            'descricao' => $request->descricao,
        ]);
        
        if ($request->hasFile('images')) {
            $imagens = $request->file('images');
            foreach ($imagens as $imagem) {
                $path = $imagem->store('uploads', 'public');
        
                $imagemModel = new Images();
                $imagemModel->helpdesk_id = $helpdesk->id;
                $imagemModel->helpdesk_form_id = $helpdesk_form->id;
                $imagemModel->name = $imagem->getClientOriginalName();
                $imagemModel->path = $path;
                $imagemModel->type = $imagem->getClientMimeType();
                $imagemModel->size = $imagem->getSize();
                $imagemModel->save();
            }
        }
    
        // $msgText = "O.S. Nº " . $helpdesk->id . " aberto com sucesso!\nEm breve você também receberá um e-mail com os detalhes do seu chamado.";
        $msgText = "O.S. Nº " . $helpdesk->id . " aberto com sucesso!\n";
        $msgIcon = "check";
    
        return redirect()->route('home')->with('message', [
            'text' => $msgText,
            'icon' => $msgIcon
        ]);
    }
    
}