<?php

namespace App\Http\Requests\Email;

use Illuminate\Foundation\Http\FormRequest;

class EmailRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   */
  public function authorize(): bool
  {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
   */
  public function rules(): array
  {
    return [
      'subject' => 'required',
      'body' => 'required',
      'recipients' => 'required|array',
      'recipients.*' => 'required|exists:contacts,cid'
    ];
  }

  public function messages()
  {
    return [
      'subject.required' => 'Fill out a subject for the email',
      'body.required' => 'You can\'t send a blank email',
      'recipients.required' => 'You are missing recipients to the email',
      'recipients.exists' => 'The specified recipients are not in the database',
    ];
  }
}
