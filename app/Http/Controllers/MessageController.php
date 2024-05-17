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
    // Recupera l'utente autenticato
    $user = Auth::user();
    $appartments = Appartment::whereBelongsTo($user)->get();

    // Filtra i messaggi solo per gli appartamenti dell'utente autenticato
    $messages = Message::select();
    foreach ($appartments as $appartment) {
      $messages->orWhereBelongsTo($appartment);
    }
    $messages = $appartments->count() ? $messages->orderBy('created_at', 'desc')->get() : [];


    // Passa i dati alla vista
    return view('admin.messages.index', compact('messages'));
  }

  public function indexMessagePerAppartment($appartment_slug)
  {
    // Recupera l'utente autenticato
    $user = Auth::user();

    // Recupera gli appartamenti dell'utente autenticato utilizzando lo slug
    $appartment = Appartment::where('slug', $appartment_slug)->first();

    if (!$appartment) {
      return abort(404); // gestione del caso in cui lo slug non corrisponda a nessun appartamento
    }
    ;

    // Controllo se l'appartamento appartiene all'utente autenticato
    if (!$user->appartments->contains($appartment)) {
      return abort(403);
    }
    // Filtra i messaggi solo per gli appartamenti dell'utente autenticato
    $messages = Message::where('appartment_id', $appartment->id)->orderBy('created_at', 'desc')->get();

    // Passa i dati alla vista
    return view('admin.messages.index', compact('messages'));
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

    return view('admin.messages.show', compact('message'));
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
    $appartment_slug = $message->appartment->slug;

    // if (!$message) {
    //   return response()->json(['error' => 'Messaggio non trovato'], 404);
    // }

    // $message->delete();
    // return response()->json(['message' => 'Messaggio eliminato con successo']);


    $message->delete();
    return redirect()->route('admin.messages.index', ['appartment_slug' => $appartment_slug])
      ->with('success', 'Messaggio eliminato con successo');
  }
}
