<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NoRestrictedWords implements ValidationRule
{
    protected array $restrictedWords;

    /**
     * WordValidator constructor.
     *
     * @param array $restrictedWords Restricted words to be checked.
     */
    public function __construct(array $restrictedWords)
    {
        $this->restrictedWords = $restrictedWords;
    }

    /**
     * Validate the given attribute.
     *
     * @param  string  $attribute Name of the attribute .
     * @param  mixed  $value Value of the attribute.
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        foreach ($this->restrictedWords as $word) {
            if (stripos($value, $word) !== false) {
                $fail("Field :attribute contains restricted word: {$word}.");
                return;
            }
        }
    }
}
