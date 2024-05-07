<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AppartmentFormRequest extends FormRequest
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
      'address' => 'required|string',
      'lat' => 'required|decimal:0,999',
      'lng' => 'required|decimal:0,999',
      'title' => 'required|min:10',
      'image' => 'nullable|image',
      'rooms' => 'required|integer|min:1',
      'beds' => 'required|integer|min:1',
      'bathrooms' => 'required|integer|min:1',
      'square_meters' => 'required|integer|min:10',
      'services' => 'required|exists:services,id',
      'published' => 'nullable|starts_with:on|ends_with:on'
    ];
  }
}
