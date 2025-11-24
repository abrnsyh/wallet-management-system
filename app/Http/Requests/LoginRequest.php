<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

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
            "password" => "required",
        ];
    }

    public function ensureIsNotRateLimited()
    {
        $key = 'login:'.strtolower($this->email);

        if (! RateLimiter::tooManyAttempts($key, 5)) {
            return;
        }

        $seconds = RateLimiter::availableIn($key);

        throw ValidationException::withMessages([
            'email' => "Too many login attempts. Try again in {$seconds} seconds.",
        ]);
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
