<?php
/**
 * 公共文件上传
 */
namespace App\Http\Controllers\admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use EndaEditor;

class UploadFileController extends Controller
{

    public function postImg()
    {
        $data = EndaEditor::uploadImgFile('uploads');
        return json_encode($data);
    }


}