<?php

namespace App\Rules;

use App\Inspections\Spam;
use Illuminate\Contracts\Validation\Rule;

class SpamFree implements Rule
{

    public function __construct()
    {
        //
    }

    public function passes($attribute, $value)
    {
        try {
            return ! resolve(Spam::class)->detect($value);
        }catch (\Exception $e){
            return false;
        }
    }

    public function message()
    {
        return '内容有问题';
    }
}
