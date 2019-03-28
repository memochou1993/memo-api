<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RecordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch($this->method()) {
            case 'GET':
                return [
                    //
                ];

            case 'POST':
            case 'PUT':
            case 'PATCH':
                return [
                    'title' => [
                        'required',
                    ],
                    'content' => [
                        'required',
                    ],
                    'private' => [
                        'required',
                        'boolean',
                    ],
                    'type_id' => [
                        'required',
                        'integer',
                    ],
                ];

            default:
                return [
                    //
                ];
        }
    }
}
