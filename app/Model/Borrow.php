<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Borrow extends Model
{
     protected $fillable = [
        'name',
        'number',
        'book_id',
    ];

    public function hasOneBook()
    {
        return $this->hasOne('App\Model\Book', 'id', 'book_id');
    }

    /**
    * 还书
    * 
    */
    public static function returnBook($borrowId)
    {
        return self::where('id', '=', $borrowId)->update(['status' => '1']);
    }

}
