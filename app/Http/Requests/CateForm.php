<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Response;
class CateForm extends AdminForm
{
    public function rules()
    {

        return [
            'cate_name' => 'required',
            'as_name' => 'required',
            'parent_id' => 'integer',
            'seo_title' => 'required',
            'seo_key' => 'required',
            'seo_desc' => 'required',
        ];

    }
}