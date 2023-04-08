<?php

namespace App\Rules;

use Closure;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Validation\ValidationRule;

class MaxThreePosts implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $posts_count = Post::where('user_id', Auth::user()->id)->get()->count();
        if ($posts_count >= 3) {
            $fail("You can't create more than three posts.");
        }
    }
}
