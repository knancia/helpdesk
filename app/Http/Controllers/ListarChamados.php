<?php

namespace App\Http\Controllers;

use App\Models\Helpdesk;
use App\Models\HelpdeskForm;
use App\Models\Images;
use Illuminate\Routing\Controller as Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class ListarChamados extends Controller
{
    public function index(Request $request)
    {
        $helpdesk = Helpdesk::table($request->q);
        
        return Inertia::render('ListarChamados/Index', [
            'helpdesk' => $helpdesk,
        ]);
    }

    public function getPhotos($id)
    {
        $helpdesk = Helpdesk::findOrFail($id);
        $photos = $helpdesk->images;

        return response()->json($photos);      
    }

    public function store(Request $request) {
        $id_user = Auth::user()->id;

        Helpdesk::where('id', $request->id)->update(['form_status_id' => $request->status]);

        $helpdesk_form = HelpdeskForm::Create([
            'helpdesk_id' => $request->helpdesk_id,
            'users_id' => $id_user,
            'descricao' => $request->descricao,
        ]);
        
        if ($request->hasFile('images')) {
            $imagens = $request->file('images');
            foreach ($imagens as $imagem) {
                $path = $imagem->store('uploads', 'public');
        
                $imagemModel = new Images();
                $imagemModel->helpdesk_id = $request->helpdesk_id;
                $imagemModel->helpdesk_form_id = $helpdesk_form->id;
                $imagemModel->name = $imagem->getClientOriginalName();
                $imagemModel->path = $path;
                $imagemModel->type = $imagem->getClientMimeType();
                $imagemModel->size = $imagem->getSize();
                $imagemModel->save();
            }
        }
    
        // $msgText = "O.S. Nº " . $helpdesk->id . " aberto com sucesso!\nEm breve você também receberá um e-mail com os detalhes do seu chamado.";
    }
}