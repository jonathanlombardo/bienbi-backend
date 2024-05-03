<?php

namespace App\Http\Controllers;

use App\Models\Appartment;
use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
  /**
   * Display a listing of the resource.
   *
  //  * @return \Illuminate\Http\Response
   */
  public function index()
  {
    // Recupero appartamenti dell'utente autenticato
    $appartments = Appartment::whereBelongsTo(Auth::user())->paginate(1);

    // Recupero tutti i messaggi che appartengono almeno ad un appartamento
    $messages = Message::select();
    foreach ($appartments as $appartment) {
      $messages->orWhereBelongsTo($appartment);
    }
    $messages = $messages->orderBy('created_at')->get();

    // Passiamo i dati alla vista
    return view('admin.messages.index', compact('messages', 'appartments'));
  }

  /**
   * Show the form for creating a new resource.
   *
  //  * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
  //  * @param  \Illuminate\Http\Request  $request
  //  * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    //
  }

  /**
   * Display the specified resource.
   *
  //  * @param  int  $id
  //  * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $message = Message::find($id);

    if (!$message) {
      return response()->json(['error' => 'Messaggio non trovato'], 404);
    }

    return response()->json($message);
  }

  /**
   * Show the form for editing the specified resource.
   *
  //  * @param  int  $id
  //  * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
  //  * @param  \Illuminate\Http\Request  $request
  //  * @param  int  $id
  //  * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
  //  * @param  int  $id
  //  * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $message = Message::find($id);

    if (!$message) {
      return response()->json(['error' => 'Messaggio non trovato'], 404);
    }

    $message->delete();
    return response()->json(['message' => 'Messaggio eliminato con successo']);
  }
}
