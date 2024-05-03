<?php

namespace App\Http\Controllers;

use App\Models\View;
use Illuminate\Http\Request;

class ViewController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * 
     */
    public function index()
    {
        $services = View::all();
        
        return view('admin.view.index', compact('views'));
    }
}
