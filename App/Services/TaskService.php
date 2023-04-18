<?php

namespace App\Services;

use App\Models\Task;

class TaskService
{
    public function get($id = null)
    {
        if ($id) {
            return Task::select($id);
        } else {
            return Task::selectAll();
        }
    }

    public function post()
    {
        return Task::insert($_POST);
    }

    public function put($id){
        parse_str(file_get_contents("php://input"), $_PUT);
        return Task::update($id,$_PUT);
    }

    public function delete($id){
        return Task::delete($id);
    }
}
