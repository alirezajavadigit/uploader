<?php

namespace App\Http\Requests\V1;

use App\Rules\FileMimeRule; // Import custom FileMimeRule class if defined
use Illuminate\Foundation\Http\FormRequest; // Import Laravel's FormRequest class

class StoreFileRequest extends FormRequest // Define the StoreFileRequest class extending FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true; // Authorization logic (always return true for simplicity; adjust as needed)
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * These rules define how the 'file' parameter should be validated.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'file' => ["required", "max:10000", "mimes:pdf,jpeg,jpg,mp3,mp4,doc,png,gif"] // Validation rules for 'file'
        ];
    }
}
