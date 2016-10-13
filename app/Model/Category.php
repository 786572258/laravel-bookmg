<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Input;

class Category extends Model
{
    protected $table = 'category';

    protected $fillable = [
        'cate_name',
        'as_name',
        'parent_id',
        'seo_title',
        'seo_key',
        'seo_desc',
    ];

    static $catData = [
        0 => '顶级分类',
    ];

    static $category = [];

    public $html;

    /**
     * 获取顶级分类
     * @param $num 个数
     * @return mixed
     */
    public static function getTopCategory($num = 10)
    {
        return $topCategory = self::where('parent_id', '=', '0')->get();
    }

    /**
     * 获取分类列表
     * @return mixed
     */
    public static function getCategoryDataModel()
    {
        $category = self::all();
        $data = catetree($category);
        return $data;
    }

    /**
     * 此方法维护静态数组 $category
     */
    private static function getCategoryArr($catId)
    {
        if (!isset(self::$category[$catId])) {
            $cate = self::select('cate_name')->find($catId);
            if (empty($cate)) {
                return false;
            }
            self::$category[$catId] = $cate->cate_name;
        }
        return self::$category[$catId];
    }

    public static function getCategoryNameByCatId($catId)
    {
        $cate = self::getCategoryArr($catId);
        return !empty($cate) ? $cate : '分类不存在';
    }

    /**
     * 取得树结构的分类数组
     * @param catDataFirstName 设置分类树第一个分类的名称
     * @return array
     */
    public static function getCategoryTree($catDataFirstName = '')
    {
        if (!empty($catDataFirstName)) {
            self::$catData[0] = $catDataFirstName;
        }
        $data = self::getCategoryDataModel();
        foreach ($data as $k => $v) {
            self::$catData[$v->id] = $v->html . $v->cate_name;
        }

        return self::$catData;
    }

    /**
     * 根据别名取分类信息
     * @param $asName
     * @return mixed
     */
    public static function getCatInfoModelByAsName($asName)
    {
        return self::where('as_name', '=', $asName)->first();
    }

    /**
     * 获取一个分类下面所有的子类ids列表
     * @param $model 分类列表
     * @param $parentId 父类id
     * @return array
     */
    public static function getChildrensIdsList($model, $parentId = 0)
    {
        static $childrensIdsList = [];
        foreach ($model as $k => $v) {
            if ($v->parent_id == $parentId) {
                $childrensIdsList[] = $v->id;
                self::getChildrensIdsList($model, $v->id);
            }
        }
        return $childrensIdsList;
    }

    /**
     * 获取一个分类下面所有的子类ids串
     * @param $model 分类列表
     * @param $parentId 父类id
     * @return string
     */
    public static function getChildrensIds($model, $parentId = 0)
    {
        return implode(',', self::getChildrensIdsList($model, $parentId));
    }
}
