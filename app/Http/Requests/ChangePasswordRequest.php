<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        $this->merge([
            'checked_password' => Hash::check($this->old_password, auth()->user()->password)
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            'checked_password' => "required|accepted",
            'new_password' => 'required|min:8|confirmed'
        ];
    }
}
