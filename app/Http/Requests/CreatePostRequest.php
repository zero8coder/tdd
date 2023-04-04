<?php

namespace App\Http\Requests;

use App\Exceptions\ThrottleException;
use App\Models\Reply;
use App\Rules\SpamFree;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class CreatePostRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('create', new Reply);
    }

    protected function failedAuthorization()
    {
        throw new ThrottleException;
    }

    public function rules()
    {
        return [
            'body' => ['required', new SpamFree]
        ];
    }
}
