<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class BookForm extends AdminForm
{
    

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'bookname' => 'required',
            'publisher' => 'required',
            'author' => 'required',
            'price' => 'numeric',
            'content' => 'required',
        ];
    }
}
