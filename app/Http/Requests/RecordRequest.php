<?php

namespace App\Http\Requests;

use App\Rules\ElementsInArray;
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
                    'with' => [
                        new ElementsInArray([
                            'user',
                            'type',
                            'tags',
                        ]),
                        'nullable',
                    ],
                    'paginate' => [
                        'integer',
                        'min:1',
                        'nullable',
                    ],
                ];

            case 'POST':
            case 'PUT':
            case 'PATCH':
                return [
                    'date' => [
                        'date',
                    ],
                    'title' => [
                        'required',
                    ],
                    'content' => [
                        'required',
                    ],
                    'private' => [
                        'boolean',
                    ],
                    'type_id' => [
                        'required',
                        'integer',
                    ],
                    'tag_ids' => [
                        'array',
                    ],
                    'tag_ids.*' => [
                        'integer',
                    ],
                    'with' => [
                        new ElementsInArray([
                            'user',
                            'type',
                            'tags',
                        ]),
                        'nullable',
                    ],
                ];

            default:
                return [
                    //
                ];
        }
    }
}
