<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\RateLimiter;

class LoginRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "email" => "required|email",
            "passowrd" => "required",
        ];
    }

    public function hitRateLimit()
    {
        $key = 'login:'.strtolower($this->email);
        RateLimiter::hit($key, 60); // expire 60 detik
    }

    public function clearRateLimit()
    {
        $key = 'login:'.strtolower($this->email);
        RateLimiter::clear($key);
    }
}
