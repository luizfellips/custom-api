<?php

namespace App\Models;

class User
{
    private static $table = "user";

    public static function select(int $id)
    {
        $connection = new \PDO(DBDRIVE . ': host=' . DBHOST . '; dbname=' . DBNAME, DBUSER, DBPASS);
        $stmt = $connection->prepare("SELECT * FROM " . self::$table . " WHERE id = ?");
        $stmt->bindParam(1, $id,\PDO::PARAM_INT);
        $stmt->execute();


        if ($stmt->rowCount() > 0) {
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } else {
            throw new \Exception("No user found.");
        }
    }

    public static function selectAll()
    {
        $connection = new \PDO(DBDRIVE . ': host=' . DBHOST . '; dbname=' . DBNAME, DBUSER, DBPASS);
        $stmt = $connection->prepare("SELECT * FROM " . self::$table);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } else {
            throw new \Exception("No users found.");
        }
    }

    public static function insert(array $data)
    {
        $column_fields = array_keys($data);
        $bindings = array_pad([],count($column_fields),'?');
        $connection = new \PDO(DBDRIVE . ': host=' . DBHOST . '; dbname=' . DBNAME, DBUSER, DBPASS);
        $query = 'INSERT INTO '.self::$table.' (' . implode(',',$column_fields) . ') VALUES (' . implode(',',$bindings) . ')';
        $stmt = $connection->prepare($query);
        $data['password'] = password_hash($data['password'],PASSWORD_DEFAULT);
        $stmt->execute(array_values($data));

        if ($stmt->rowCount() > 0){
            return 'user successfully registered!';
        }
        else{
            throw new \Exception("Failed to register the user!");
        }
    }

    public static function updateUser(int $id, array $data){
        $fields = array_keys($data);
        $connection = new \PDO(DBDRIVE . ': host=' . DBHOST . '; dbname=' . DBNAME, DBUSER, DBPASS);
        $query = 'UPDATE '.self::$table.' SET '.implode('=?,',$fields).'=? WHERE id = ?';
        $data['password'] = password_hash($data['password'],PASSWORD_DEFAULT);
        $stmt = $connection->prepare($query);
        array_push($data,$id);
        $stmt->execute(array_values($data));

        if($stmt->rowCount() > 0){
            return 'user updated successfully!';

            
        } else{
            throw new \Exception("Failed to update user!");
        }
    }

    public static function delete(int $id){
        $connPdo = new \PDO(DBDRIVE.': host='.DBHOST.'; dbname='.DBNAME,DBUSER,DBPASS);

        $sql = 'Delete from '.self::$table.' WHERE id = ?';
        $stmt = $connPdo->prepare($sql);

        $stmt->bindParam(1, $id,\PDO::PARAM_INT);
        $stmt->execute();

        if($stmt->rowCount() > 0){
            return 'user deleted succesfully!';
            
        } else{
            throw new \Exception("Failed to delete user!");
        }
    }
}
