<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Response;
class SystemForm extends AdminForm
{
    public function rules()
    {

        return [
            'cate' => 'integer',
            'system_name' => 'required',
            'system_value' => 'required',
        ];

    }
}