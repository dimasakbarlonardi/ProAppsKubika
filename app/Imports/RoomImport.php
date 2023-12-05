<?php

namespace App\Imports;

use App\Helpers\ConnectionDB;
use App\Models\Floor;
use App\Models\Room;
use App\Models\Tower;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Auth;

class RoomImport implements ToModel, WithStartRow
{
    public function startRow(): int
    {
        return 2;
    }

    public function model(array $row)
    {
        $connRoom = ConnectionDB::setConnection(new Room());

        $connRoom->id_site = Auth::user()->id_site;
        $connRoom->id_tower = $this->Tower($row[1]);
        $connRoom->id_lantai = $this->Floor($row[2]);
        $connRoom->nama_room = $row[3];

        $connRoom->GenerateBarcode();

        return $connRoom;
    }

    function Tower($query)
    {
        $connModel = ConnectionDB::setConnection(new Tower());

        $data = $connModel->where('nama_tower', 'like', '%' . $query . '%')->first();

        return $data ? $data->id_tower : null;
    }

    function Floor($query)
    {
        $connModel = ConnectionDB::setConnection(new Floor());

        $data = $connModel->where('nama_lantai', 'like', '%' . $query . '%')->first();

        return $data ? $data->id_lantai : null;
    }
}
