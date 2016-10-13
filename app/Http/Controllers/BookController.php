<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Components\EndaPage;
use App\Components\StaticPage;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

use App\Model\Book;
use App\Model\Category;
class BookController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        //页面静态化
        return $this->staticPage();
      
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $book = Book::getBookModelByBookId($id);
        //ArticleStatus::updateViewNumber($id);
        $data = array(
            'book' => $book,
        );
        viewInit();
        return homeView('book', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    private function staticPage() {
        $sp = new staticPage();
        $view = 'index';
        if (!Input::get('page') && $sp->usable($view)) {
           return  $sp->getContent($view);
        } else {
            $book = Book::getNewsBook(9);
            viewInit();
            $page = new EndaPage($book['page']);
            $htmlStrings = homeView($view, array(
                'bookList' => $book,
                'page' => $page
            ))->__toString();

            $sp->putContent($view, $htmlStrings);
            return $htmlStrings;
        }

    }
}
