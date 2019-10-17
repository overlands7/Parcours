<?php

namespace App\Http\Controllers;

use File;
use Input; 
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\View;

class ParcoursController extends Controller
{

public function index() {
	return view('parcours.accueil');
}
public function geturl() {
		$url = URL::to("/");
		return View::make('accueil')->with('url',$url);
}

public function recupererjson(Request $request) {
	$chemin = File::get(storage_path('test1.json'));
	$reponse = str_replace("\r", "\n", $chemin);
	if(!empty($reponse)) {
		return View('accueil')->with('reponse', $reponse);
		}
	}

}