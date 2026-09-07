<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules()
    {
        return [
            'email' => 'required|string',
            'password' => 'required|string',
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     */
    public function authenticate()
    {
        $this->ensureIsNotRateLimited();

        $loginInput = $this->input('email');

        // ኢሜይል ወይም መለያ ቁጥር (ADM-001) መሆኑን መለየት
        $fieldType = filter_var($loginInput, FILTER_VALIDATE_EMAIL) ? 'email' : 'user_id';

        $credentials = [
            $fieldType => $loginInput,
            'password' => $this->input('password'),
        ];

        if (! Auth::attempt($credentials, $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => 'የተሳሳተ ኢሜይል/መለያ ቁጥር ወይም የይለፍ ቃል!',
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     */
    public function ensureIsNotRateLimited()
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => "በርካታ የተሳሳቱ ሙከራዎች ተደርገዋል፤ እባክዎ ከ {$seconds} ሰከንድ በኋላ በድጋሚ ይሞክሩ።",
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey()
    {
        return Str::transliterate(Str::lower($this->input('email')).'|'.$this->ip());
    }
}
