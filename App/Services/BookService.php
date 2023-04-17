<?php

namespace App\Services;

use App\Models\Book;

class BookService
{
    public function get($id = null)
    {
        if ($id) {
            return Book::select($id);
        } else {
            return Book::selectAll();
        }
    }

    public function post()
    {
        return Book::insert($_POST);
    }

    public function put($id){
        parse_str(file_get_contents("php://input"), $_PUT);
        return Book::updateUser($id,$_PUT);
    }

    public function delete($id){
        return Book::delete($id);
    }
}
