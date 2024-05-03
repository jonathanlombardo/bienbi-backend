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
        
        $services = View::paginate(10);
        
        return view('admin.view.index', compact('views'));
    }
}
