<?php

namespace App\Http\Requests\Contact;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ContactRequest extends FormRequest
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
    $contactId = $this->route('contact')->id ?? null;

    return [
      'first_name' => 'required',
      'last_name' => 'required',
      'job_title' => 'sometimes|filled',
      'middle_name' => 'sometimes|filled',
      'bio' => 'sometimes|filled',

      'office.id' => 'sometimes|exists:companies,id',
      'office.url' => 'sometimes|filled|url:http,https',
      'office.slogan' => 'sometimes|filled',
      'office.address' => 'sometimes|array',
      'office.address.*.id' => 'sometimes|exists:addresses,id',
      'office.address.*.type' => ['required', Rule::in(['office', 'home'])],
      'office.address.*.street' => 'nullable',
      'office.address.*.state' => 'nullable',
      'office.address.*.country' => 'sometimes|filled',
      'office.address.*.city' => [
        'sometimes',
        function ($attribute, $value, $fail) {
          $index = explode('.', $attribute)[2]; // Gets the wildcard index position

          if (request("office.address.$index.street") && !$value) {
            $fail('Specify the city for the address');
          }
        },
      ],

      'phones' => 'sometimes|array',
      'phones.*.type' => ['required', Rule::in(['home', 'work', 'mobile', 'fax'])],
      'phones.*.number' => 'required|filled|phone:AUTO',
      'phones.*.country_code' => ['sometimes', 'filled', Rule::in(['MW', 'ZA', 'ZM', 'ZW'])],

      'emails' => 'sometimes|array',
      'emails.*.email' => [
        'required', 'email:rfc,dns',
        Rule::unique('emails', 'email')->ignore($contactId, 'model_id')
      ],
    ];
  }
  public function messages()
  {
    return [

      'first_name.required' => 'Enter first name',
      'last_name.required' => 'Enter surname',

      'office.id.exists' => 'Oops! YOU don\'t have that contact yet!',
      'office.url.filled' => 'Fill out contact\'s website',
      'office.url.url' => 'You entered an invalid web URL.',

      'emails.*.email.required' => 'Provide an email address',
      'emails.*.email.email' => 'You entered an invalid email',
      'emails.*.email.unique' => 'This email is already taken',

      'office.address.*.type.required' => 'Address type is missing',
      'office.address.*.type.in' => 'Address type can only be "office" or "home"',
      'office.address.*.country.filled' => 'Name the country the contact is based',
      'office.address.*.street.filled' => 'Name the street address',

      'bio.filled' => 'Provide content for the note',

      'phones.*.type.in' => 'Invalid phone type',
      'phones.*.country_code.filled' => 'The country code is not set',
      'phones.*.country_code.in' => 'Oops! No support for this country yet',
      'phones.*.number.required' => 'Fill out a phone number',
      'phones.*.number.phone' => 'You entered an invalid phone number',
    ];
  }
}
