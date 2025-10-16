<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules()
    {
        return [
            'cep' => 'nullable|string|max:20',
            'state' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:150',
            'neighborhood' => 'nullable|string|max:150',
            'address' => 'nullable|string|max:255',
            'number' => 'nullable|string|max:50',
            'contact_name' => 'required|string|max:150',
            'contact_email' => 'nullable|email|max:255',
            'contact_phone' => 'nullable|string|max:50',
        ];
    }
}
