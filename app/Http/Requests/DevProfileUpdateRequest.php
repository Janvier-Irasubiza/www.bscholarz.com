<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Models\RhymBox;
use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DevProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */

     public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        
        return [
            'names' => ['string', 'max:255'],
            'phone_number' => ['string', 'max:255'],
            'role' => ['string', 'max:255'],
            'email' => ['email', 'max:255', Rule::unique('rhythmbox') -> ignore($this -> id)],
        ];
    }

}
