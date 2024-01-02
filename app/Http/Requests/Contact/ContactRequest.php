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
      'title' => 'sometimes|filled',
      'middle_name' => 'sometimes|filled',
      'nickname' => 'sometimes|filled',
      'bio' => 'sometimes|filled',

      'company.id' => 'sometimes|exists:companies,id',
      'company.url' => 'sometimes|filled|url:http,https',
      'company.slogan' => 'sometimes|filled',
      'company.job_title' => 'sometimes|filled',
      'company.address' => 'sometimes|filled',
      'company.department' => 'sometimes|filled',
      'company.address' => 'sometimes|filled',

      'phones' => 'sometimes|array',
      'phones.*.type' => ['required', Rule::in(['home', 'work', 'mobile', 'fax'])],
      'phones.*.number' => 'required|filled|phone:AUTO',
      'phones.*.country_code' => ['sometimes', 'filled', Rule::in(['MW', 'ZA', 'ZM', 'ZW'])],

      'addresses' => 'sometimes|array',
      'addresses.*.type' => ['required', Rule::in(['office', 'home'])],
      'addresses.*.street' => 'nullable|string',
      'addresses.*.city' => 'sometimes|required',
      'addresses.*.state' => 'nullable',
      'addresses.*.country' => 'nullable',

      'emails' => 'sometimes|array',
      'emails.*.email' => ['required', 'email:rfc,dns', Rule::unique('emails', 'email')->ignore($contactId, 'emailable_id')],
    ];
  }

  public function messages()
  {
    return [

      'first_name.required' => 'Enter first name',
      'last_name.required' => 'Enter surname',

      'company.id.exists' => 'Oops! We don\'t have that company yet!',
      'company.url.filled' => 'You should fill out the company website',
      'company.url.url' => 'You entered an invalid web URL.',

      'emails.*.email.required' => 'Provide an email address',
      'emails.*.email.email' => 'You entered an invalid email',
      'emails.*.email.unique' => 'This email is already taken',

      'addresses.*.type.required' => 'Address type is missing',
      'addresses.*.type.in' => 'Address type can only be "office" or "home"',
      'addresses.*.street.string' => 'Street name must have letters',
      'addresses.*.city.required' => 'Provide city name',
      // 'addresses.*.state.required' => 'Provide state/province name',
      // 'addresses.*.country.required' => 'Provide country name',

      'phones.*.type.in' => 'Invalid phone type',
      'phones.*.country_code.filled' => 'The country code is not set',
      'phones.*.country_code.in' => 'Oops! No support for this country yet',
      'phones.*.number.required' => 'Fill out a phone number',
    ];
  }
}
