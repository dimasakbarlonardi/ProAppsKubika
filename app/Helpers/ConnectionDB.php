<?php

namespace App\Helpers;

use App\Models\Login;

class ConnectionDB {

    public function getDBname()
    {
        $request = Request();
        $user_id = $request->user()->id;
        $login = Login::where('id', $user_id)->with('site')->first();
        $db = $login->site->db_name;

        return $db;
    }

    public function setConnection($model)
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
