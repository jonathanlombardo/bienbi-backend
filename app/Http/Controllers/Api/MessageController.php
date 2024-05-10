<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Appartment;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{

  public function store(Request $request)
  {
    // test
    // $id = '1';
    // $mail = 'test@test.com';
    // $name = 'test name';
    // $lastName = 'test last name';
    // $body = 'messaggio di testo piu lungo';

    // valido i dati della richiesta
    $data = $request->all();
    $id = $data['id'] ?? null;
    $mail = isset($data['mail']) ? filter_var($data['mail'], FILTER_VALIDATE_EMAIL) : null;
    $name = $data['first_name'] ?? null;
    $lastName = $data['last_name'] ?? null;
    $body = $data['body'] ?? null;

    if ($id != (int) $id) {
      return response()->json(['response' => false, 'message' => 'invalid id']);
    }
    if (!$mail) {
      return response()->json(['response' => false, 'message' => 'invalid mail']);
    }
    if (!$name || strlen($name) <= 0 || strlen($name) > 40) {
      return response()->json(['response' => false, 'message' => 'invalid name']);
    }
    if (!$lastName || strlen($lastName) <= 0 || strlen($name) > 40) {
      return response()->json(['response' => false, 'message' => 'invalid lastname']);
    }
    if (!$body || strlen($body) <= 0) {
      return response()->json(['response' => false, 'message' => 'invalid body']);
    }
    $appartment = Appartment::find($id);
    if (!$appartment) {
      return response()->json(['response' => false, 'message' => 'invalid id']);
    }

    // creo e allego il messaggio
    $message = new Message;
    $message->first_name = $name;
    $message->last_name = $lastName;
    $message->body = $body;
    $message->mail = $mail;
    $message->appartment_id = $appartment->id;
    $message->save();

    // risposta
    return response()->json(['response' => true, 'message' => 'message correctly attached']);

  }

}
