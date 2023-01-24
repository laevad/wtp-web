<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class LicenseNumberRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
//        return is_string($value) && preg_match('/^[a-zA-Z0-9]{2}-[a-zA-Z0-9]{2}-[a-zA-Z0-9]{6}$/', $value);
//        return is_string($value) && preg_match('/^(?!(.)\1{3})([a-zA-Z0-9]{2})-(?!(.)\1{3})([a-zA-Z0-9]{2})-(?!(.)\1{3})([a-zA-Z0-9]{6})$/', $value);
//        return is_string($value) &&
//            preg_match('/^(?=.*[a-zA-Z].*[a-zA-Z].*[a-zA-Z])(?=.*[0-9].*[0-9].*[0-9]|[a-zA-Z0-9]{8}-[a-zA-Z0-9]{6})$/', $value);
        return is_string($value) && preg_match('/^[A-Z][0-9]{2}-[0-9]{2}-[0-9]{6}$/', $value);
    }


    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be a valid license number in the format X01-23-123456 where the first letter must be an uppercase letter and the rest of the string should be digits and dashes.';
    }
}
