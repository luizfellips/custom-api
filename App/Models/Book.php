<?php

namespace App\Models;

class Book extends Resource
{
    protected static string $table = 'book';

    /**
     * this function will return a single book from the database based on id, if it exists.
     * if it does not exist, throw exception
     */
    public static function select(int $id)
    {
        return parent::select($id);
    }
    /**
     * this function will return all books from the database.
     * if there are no records, throw exception
     */
    public static function selectAll()
    {
        return parent::selectAll();
    }
    /**
     * this function will insert a new book into the database, receives an array as parameter
     * returns successfull string statement
     * throws exception if an error occurs.
     */
    public static function insert(array $data)
    {
        return parent::insert($data);
    }
    /**
     * this function will update an book in the database, receives an int and an array as parameters.
     * returns successfull string statement
     * throws exception if an error occurs.
     */
    public static function update(int $id, array $data)
    {
        return parent::update($id, $data);
    }
    /**
     * this function will delete an book from the database, receives an int as parameter.
     * returns successfull string statement
     * throws exception if an error occurs.
     */
    public static function delete(int $id)
    {
        return parent::delete($id);
    }
}
