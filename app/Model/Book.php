<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Auth, Input, Request, Cache;
class Book extends Model
{
    const REDIS_NEW_BOOK_CACHE = 'redis_new_book_cache_';

    const REDIS_BOOK_CACHE = 'redis_book_cache_';

    const REDIS_CATE_BOOK_CACHE = 'redis_cate_book_cache_';

    const REDIS_USER_BOOK_CACHE = 'redis_user_book_cache_';

    const REDIS_HOT_BOOK_CACHE = 'redis_hot_book_cache_';

    const REDIS_SEARCH_BOOK_CACHE = 'redis_search_book_cache_';

    const REDIS_TAG_BOOK_CACHE = 'redis_tag_book_cache_';

    const REDIS_BOOK_PAGE_TAG = 'redis_book_page_tag';

    protected $table = 'books';

    static $cacheMinutes = 1440;

    protected $fillable = [
        'cid',
        'bookname',
        'user_id',
        'content',
        'tags',
        'price',
        'pic',
        'publisher',
        'author',
        'recom'
    ];

    /**
     * 文件上传
     * @param $field
     * @return string
     */
    public static function uploadImg($field)
    {
        if (Request::hasFile($field)) {
            $pic = Request::file($field);
            if ($pic->isValid()) {
                $newName = md5(rand(1, 1000) . $pic->getClientOriginalName()) . "." . $pic->getClientOriginalExtension();
                $pic->move('uploads', $newName);
                return $newName;
            }
        }
        return '';
    }

    /**
     * 获取最新的图书
     * @param int $limit 条数
     * @return mixed
     */
    public static function getNewsBook($limit = 4)
    {
        $page = Input::get('page', 1);
        $cacheName = $page.'_'.$limit;
    
        $model = self::select('id')->orderBy('id', 'DESC')->simplePaginate($limit);
        if (empty($model = Cache::tags(self::REDIS_BOOK_PAGE_TAG)->get(self::REDIS_NEW_BOOK_CACHE . $cacheName))) {
            $model = self::select('id')->orderBy('id', 'DESC')->simplePaginate($limit);
            Cache::tags(self::REDIS_BOOK_PAGE_TAG)->put(self::REDIS_NEW_BOOK_CACHE . $cacheName, $model, self::$cacheMinutes);
        }

        $bookList = array(
            'data' => [],
        );

        foreach ($model as $key => $book) {
            $bookList['data'][$key] = self::getBookModelByBookId($book->id);
        }
        $bookList['page'] = $model;
        return $bookList;
    }

    /**
     * 根据图书id获取图书Collection对象
     * @param $bookId
     * @return \Illuminate\Support\Collection|null|static
     */
    public static function getBookModelByBookId($bookId)
    {
        if (empty($book = Cache::get(self::REDIS_BOOK_CACHE . $bookId))) {
            $book = self::find($bookId);
            Cache::add(self::REDIS_BOOK_CACHE . $bookId, $book, self::$cacheMinutes);
        }
        return $book;
    }

    public static function getBookListByTagId($tagId)
    {
        if (empty($model = Cache::tags(self::REDIS_BOOK_PAGE_TAG)->get(self::REDIS_TAG_BOOK_CACHE . $tagId))) {
            $model = self::select('id')->whereRaw(
                'find_in_set(?, tags)',
                [$tagId]
            )->orderBy('id', 'desc')->simplePaginate(9);

            Cache::tags(self::REDIS_BOOK_PAGE_TAG)->put(self::REDIS_TAG_BOOK_CACHE . $tagId, $model, self::$cacheMinutes);
        }

        $bookList = array(
            'data' => [],
        );

        if(!empty($model)){
            foreach ($model as $key => $book) {
                $bookList['data'][$key] = self::getBookModelByBookId($book->id);
            }
        }

        $bookList['page'] = $model;
        return $bookList;
    }

    /**
     * 关键字搜索
     * @param $keyword
     * @return mixed
     */
    public static function getBookListByKeyword($keyword)
    {
        $page = Input::get('page', 1);
        $cacheName = $page . '_' . md5($keyword);

        if (empty($model = Cache::tags(self::REDIS_BOOK_PAGE_TAG)->get(self::REDIS_SEARCH_BOOK_CACHE . $cacheName))) {
            $model = self::select('id')->where('bookname', 'like', "%$keyword%")->orderBy('id', 'desc')->simplePaginate(10);
            Cache::tags(self::REDIS_BOOK_PAGE_TAG)->put(self::REDIS_SEARCH_BOOK_CACHE . $cacheName, $model, self::$cacheMinutes);
        }

        $bookList = array(
            'data' => [],
        );
        if(!empty($model)){
            foreach ($model as $key => $book) {
                $bookList['data'][$key] = self::getBookModelByBookId($book->id);
            }
        }
        $bookList['page'] = $model;
        return $bookList;
    }

    /**
     * 通过父类分类id获取包含子类分类下所有图书
     * @param $parentCategoryId 分类父级/顶级Id
     * @return mixed
     */
    public static function getBookListByParentCategoryId($parentCategoryId)
    {
        $category = Category::all();
        $childrensIdsList = Category::getChildrensIdsList($category, $parentCategoryId);
        array_unshift($childrensIdsList, $parentCategoryId);
        $cateIdsList = $childrensIdsList;
        $model = self::wherein('cid', $cateIdsList)->simplePaginate(9);

        $bookList = array(
            'data' => $model
        );
        $bookList['page'] = $model;
        return $bookList;
    }

}
