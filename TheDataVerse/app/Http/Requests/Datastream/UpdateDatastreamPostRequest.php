<?php

namespace App\Http\Requests\Datastream;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDatastreamPostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'alpha_dash:ascii'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'body_html' => ['required', 'string'],
            'body_json' => ['nullable', 'array'],
            'status' => ['required', 'string', Rule::in(['draft', 'published'])],
        ];
    }
}