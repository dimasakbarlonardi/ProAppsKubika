<?php

namespace App\Helpers;

use App\Models\Login;

class ConnectionDB {

    public static function getDBname()
    {
        $request = Request();

        $login = $request->user();

        $db = $login->site->db_name;

        return $db;
    }

    public static function setConnection($model)
    {
        $db = ConnectionDB::getDBname();
        $model = $model->setConnection($db);

        return $model;
    }

    public function setConnectionAPI($id_site)
    {
        dd($id_site);
    }
}
