<?php

namespace App\Jobs;

use App\Models\Floor;
use App\Models\Tower;
use App\Models\Unit;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportUnit implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data, $site;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data, $site)
    {
        $this->data = $data;
        $this->site = $site;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $connUnit = new Unit();
        $connUnit = $connUnit->setConnection($this->site->db_name);

        $count = $connUnit->count();
        $count += 1;
        if ($count < 10) {
            $count = '0' . $count;
        };

        $id_unit = $this->site->id_site . $this->Tower($this->data[0]) . $count;

        $connUnit->id_unit = $id_unit;
        $connUnit->id_site = $this->site->id_site;
        $connUnit->id_tower = $this->Tower($this->data[0]);
        $connUnit->id_lantai = $this->Floor($this->data[1]);
        $connUnit->id_hunian = $this->data[2] == 'Hunian' ? 1 : 2;
        $connUnit->nama_unit = $this->data[3];
        $connUnit->luas_unit = $this->data[4];
        $connUnit->no_meter_air = $this->data[5];
        $connUnit->no_meter_listrik = $this->data[6];
        $connUnit->meter_air_awal = (int) $this->data[7] ? $this->data[7] : 0;
        $connUnit->meter_listrik_awal = (int) $this->data[8] ? $this->data[8] : 0;
        $connUnit->keterangan = $this->data[9];
        $connUnit->GenerateBarcode();
        $connUnit->save();
    }

    function Tower($query)
    {
        $connModel = new Tower();
        $connModel = $connModel->setConnection($this->site->db_name);

        $data = $connModel->where('nama_tower', 'like', '%' . $query . '%')->first();

        return $data ? $data->id_tower : null;
    }

    function Floor($query)
    {
        $connModel = new Floor;
        $connModel = $connModel->setConnection($this->site->db_name);

        $data = $connModel->where('nama_lantai', 'like', '%' . $query . '%')->first();

        return $data ? $data->id_lantai : null;
    }
}
