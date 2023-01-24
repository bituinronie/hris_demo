<?php

namespace App\Rules;

use App\Traits\ConstantTrait;
use Illuminate\Contracts\Validation\Rule;

class isPasswordAllowed implements Rule
{
    use ConstantTrait;

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
        $returnVal = true;

        if ( strlen($value) < $this->passwordLength )
            $returnVal = false;

        if ( !preg_match("#[0-9]+#", $value) )
            $returnVal = false;

        if ( !preg_match("#[a-z]+#", $value) )
            $returnVal = false;

        if ( !preg_match("#[A-Z]+#", $value) )
            $returnVal = false;

        if ( !preg_match("/[\'^£$%&*()}{@#~?><>,|=_+!-]/", $value) )
            $returnVal = false;

        return $returnVal;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return ' should contains a combination of lowercase and uppercase alphanumeric characters and at least one symbol. (minimum of 8 characters)';
    }
}
