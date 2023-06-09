<?php

namespace App\Models;

abstract class Resource
{

    protected static string $table = '';
    /**
     * this function will return a single entity from the database based on id, if it exists.
     * if it does not exist, throw exception
     */
    public static function select(int $id)
    {
        $connection = new \PDO(DBDRIVE . ': host=' . DBHOST . '; dbname=' . DBNAME, DBUSER, DBPASS);
        $stmt = $connection->prepare("SELECT * FROM " . static::$table . " WHERE id = ?");
        $stmt->bindParam(1, $id, \PDO::PARAM_INT);
        $stmt->execute();


        if ($stmt->rowCount() > 0) {
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } else {
            throw new \Exception("No " . static::$table . " found.");
        }
    }
    /**
     * this function will return all entities from the database.
     * if there are no records, throw exception
     */
    public static function selectAll()
    {
        $connection = new \PDO(DBDRIVE . ': host=' . DBHOST . '; dbname=' . DBNAME, DBUSER, DBPASS);
        $stmt = $connection->prepare("SELECT * FROM " . static::$table);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } else {
            throw new \Exception("No " . static::$table . " found.");
        }
    }
    /**
     * this function will insert a new entity into the database, receives an array as parameter
     * returns successfull string statement
     * throws exception if an error occurs.
     */
    public static function insert(array $data)
    {
        $column_fields = array_keys($data);
        $bindings = array_pad([], count($column_fields), '?');
        $connection = new \PDO(DBDRIVE . ': host=' . DBHOST . '; dbname=' . DBNAME, DBUSER, DBPASS);
        $query = 'INSERT INTO ' . static::$table . ' (' . implode(',', $column_fields) . ') VALUES (' . implode(',', $bindings) . ')';
        $stmt = $connection->prepare($query);
        $stmt->execute(array_values($data));

        if ($stmt->rowCount() > 0) {
            return static::$table . ' successfully registered!';
        } else {
            throw new \Exception("Failed to register the " . static::$table . "!");
        }
    }
    /**
     * this function will update an entity in the database, receives an int and an array as parameters.
     * returns successfull string statement
     * throws exception if an error occurs.
     */
    public static function update(int $id, array $data)
    {
        $fields = array_keys($data);
        $connection = new \PDO(DBDRIVE . ': host=' . DBHOST . '; dbname=' . DBNAME, DBUSER, DBPASS);
        $query = 'UPDATE ' . static::$table . ' SET ' . implode('=?,', $fields) . '=? WHERE id = ?';
        $stmt = $connection->prepare($query);
        array_push($data, $id);
        $stmt->execute(array_values($data));

        if ($stmt->rowCount() > 0) {
            return static::$table . ' updated successfully!';
        } else {
            throw new \Exception("Failed to update " . static::$table . "!");
        }
    }
    /**
     * this function will delete an entity from the database, receives an int as parameter.
     * returns successfull string statement
     * throws exception if an error occurs.
     */
    public static function delete(int $id)
    {
        $connPdo = new \PDO(DBDRIVE . ': host=' . DBHOST . '; dbname=' . DBNAME, DBUSER, DBPASS);

        $sql = 'Delete from ' . static::$table . ' WHERE id = ?';
        $stmt = $connPdo->prepare($sql);

        $stmt->bindParam(1, $id, \PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return static::$table . ' deleted succesfully!';
        } else {
            throw new \Exception("Failed to delete " . static::$table . "!");
        }
    }
}
