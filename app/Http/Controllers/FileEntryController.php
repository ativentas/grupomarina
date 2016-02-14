<?php

namespace Pedidos\Http\Controllers;

use Auth;
use Pedidos\Models\Fileentry;
use Pedidos\Models\User;
use Pedidos\Http\Requests;
use Pedidos\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Response;

// use Symfony\Component\HttpFoundation\File;

class FileEntryController extends Controller
{
    public function index()
	{
		$entries = Fileentry::orderBy('id', 'DESC')->get();
		$empleados = User::where('is_admin', 0)->get();
 
		return view('fileentries.controlnominas', compact('entries','empleados'));
	}

	public function nominas()
	{
		$entries = Fileentry::where('user_id', Auth::user()->id)->get();
		
		return view('fileentries.nominasEmpleado', compact('entries'));
	}

	public function add(Request $request) {

		$this->validate($request, [
        'empleado' => 'required',
        'filefield' => 'required',
    	]);
		
		$file = $request->file('filefield');		
		
		$extension = $file->getClientOriginalExtension();		
		if($extension !=='pdf'){
			return redirect()->back()->with('info', 'El archivo debe ser un pdf válido');
		}
		
		$user_id = $request->empleado;
		$user = User::where('id', $user_id)->first();
		$nombre =$user->username;	
		$mes = $request->month;
		
		// Esto no funciona y no se porque
		// setlocale(LC_TIME,"es_ES.UTF-8");
		// $monthName = strftime('%B', mktime(0, 0, 0, $mes));
 		// $monthName = strftime("m", mktime(0, 0, 0, $mes, 10));

		$year = $request->year;
		$descripcion = $mes.' '.$year.' '.strtoupper($nombre); 

		
		Storage::disk('local')->put($file->getFilename().'.'.$extension,  File::get($file));
		$entry = new Fileentry();
		$entry->mime = $file->getClientMimeType();
		$entry->original_filename = $file->getClientOriginalName();
		$entry->filename = $file->getFilename().'.'.$extension;
		$entry->mes = $mes;
		$entry->year = $year;
		$entry->user_id = $user_id;
		$entry->descripcion = $descripcion;
 
		$entry->save();
 
		return redirect('fileentry')->withInput();
		
	}
 
	public function getFile($filename){
	
		
		$entry = Fileentry::where('filename','=', $filename)->firstOrFail();
	
		$file = Storage::disk('local')->get($entry->filename);
 		
 		if (isset($_GET['detalle'])){
		return (new Response($file, 200))
              ->header('Content-Type', $entry->mime)
              ->header('Content-Disposition', 'attachment; '.$entry->filename);
        }
        return (new Response($file, 200))
              ->header('Content-Type', $entry->mime);

	}

	public function delete($id){
		Fileentry::findOrFail($id)->delete();
		return redirect()->back()->with('info', 'Fichero eliminado!!');
	}


}
