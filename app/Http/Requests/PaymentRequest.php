<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, mixed>
   */
  public function rules()
  {
    return [
      'paymentNonce' => 'required|string',
      'deviceDataFromTheClient' => 'required|json',
      'planId' => 'required|exists:plans,id'
    ];
  }

  /**
   * Get the error messages for the defined validation rules.
   *
   * @return array
   */
  public function messages()
  {
    return [
      'paymentNonce.required' => 'Errore nella generazione del pagamento',
      'paymentNonce.string' => 'Errore nella generazione del pagamento',
      'deviceDataFromTheClient.required' => 'Errore nella generazione del pagamento',
      'deviceDataFromTheClient.json' => 'Errore nella generazione del pagamento',
      'planId.required' => 'E\' necessario fornire un Piano valido',
      'planId.exists' => 'E\' necessario fornire un Piano valido',
    ];
  }
}