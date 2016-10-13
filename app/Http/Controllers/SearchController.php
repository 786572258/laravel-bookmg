<?php namespace App\Http\Controllers;

use App\Components\EndaPage;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Model\Book;
use App\Model\Tag;
use App\Model\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class SearchController extends Controller
{

    public function getCate($id)
    {
        $book = Book::getBookListByParentCategoryId($id);

        $page = new EndaPage($book['page']);
        viewInit();
        return homeView('searchCategory', [
            'bookList' => $book,
            'cateName' => Category::getCategoryNameByCatId($id),
            'page' => $page,
            'cateId' => $id,
        ]);

    }

    public function getKeyword(Request $request)
    {
        $keyword = $request->input('keyword');
        if (empty($keyword)) {
            return redirect()->route('book.index');
        }
        $book = Book::getBookListByKeyword($keyword);

        $page = new EndaPage($book['page']);
        viewInit();
        return homeView('search', [
            'bookList' => $book,
            'keyword' => $keyword,
            'page' => $page
        ]);

    }

    public function getTag($id)
    {
        $book = Book::getBookListByTagId($id);
        $page = new EndaPage($book['page']);
        viewInit();
        return homeView('searchTag', [
            'bookList' => $book,
            'tagName' => Tag::getTagNameByTagId($id),
            'page' => $page,
            'tagId' => $id,
        ]);
    }



}
