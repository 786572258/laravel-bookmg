<?php namespace App\Http\Controllers\admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Input, Redirect, Notification;
use App\Model\Tag;
use App\Http\Requests\TagsForm;

class TagsController extends Controller
{

    public function __construct()
    {
        conversionClassPath(__CLASS__);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return adminView('index', ['tags' => Tag::orderBy('id', 'desc')->paginate(10)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
        return adminView('create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(TagsForm $request)
    {
        try {
            $data = [
                'name' => Tag::filterTagName($request->input('name'))
            ];
            if (empty($data['name'])) {
                Notification::error('添加失败');
                 return redirect()->route('admin.tags.index');
            } 

            if (Tag::create($data)) {
                Notification::success('添加成功');
            } else {
               Notification::success('添加失败');
            }
            return redirect()->route('admin.tags.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(array('error' => $e->getMessage()))->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        //
        return adminView('edit', ['tag' => Tag::find($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update(TagsForm $request, $id)
    {
        try {
            if (Tag::where('id', $id)->update(['name'=>Tag::filterTagName($request->input('name'))])) {
                Notification::success('更新成功');
            } else {
                Notification::warning('数据未做更改');
            }
            return redirect()->route('admin.tags.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(array('error' => $e->getMessage()))->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
        if (Tag::destroy($id)) {
            Notification::success('删除成功');
        } else {
            Notification::error('删除失败');
        }
        return redirect()->route('admin.tags.index');
    }

}
