<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use App\Models\Login;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\IdCard;
use App\Models\JenisKelamin;
use App\Models\Agama;
use App\Models\StatusKawin;
use App\Models\Jabatan;
use App\Models\Divisi;
use App\Models\Departemen;
use App\Models\KepemilikanUnit;
use App\Models\Penempatan;
use App\Models\User;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    public function setConnection(Request $request)
    {
        $user_id = $request->user()->id;
        $login = Login::where('id', $user_id)->with('site')->first();
        $conn = $login->site->db_name;
        $user = new Karyawan();
        $user->setConnection($conn);

        return $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $conn = $this->setConnection($request);

        $data['karyawans'] = $conn->get();
   
        return view('AdminSite.Karyawan.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $user_id = $request->user()->id;
        $login = Login::where('id', $user_id)->first();
        $conn = $login->site->db_name;

        $user = $request->session()->get('user');

        $idcard = new IdCard();
        $idcard->setConnection($conn);

        $gender = new JenisKelamin();
        $gender->setConnection($conn);

        $agama = new Agama();
        $agama->setConnection($conn);

        $statuskawin = new StatusKawin();
        $statuskawin->setConnection($conn);

        $jabatan = new Jabatan();
        $jabatan->setConnection($conn);

        $divisi = new Divisi();
        $divisi->setConnection($conn);

        $departemen = new Departemen();
        $departemen->setConnection($conn);

        $kepemilikan = new KepemilikanUnit();
        $kepemilikan->setConnection($conn);

        $penempatan = new Penempatan();
        $penempatan->setConnection($conn);

        $data['agamas'] = $agama->get();
        $data['jabatans'] = $jabatan->get();
        $data['jeniskelamins'] = $gender->get();
        $data['divisis'] = $divisi->get();
        $data['departemens'] = $departemen->get();
        $data['kepemilikans'] = $kepemilikan->get();
        $data['genders'] = $gender->get();
        $data['idcards'] = $idcard->get();
        $data['idusers'] = $user->get();
        $data['statuskawins'] = $statuskawin->get();
        $data['penempatans'] = $penempatan->get();

        return view('AdminSite.Karyawan.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $conn = $this->setConnection($request);
        
        try {
            DB::beginTransaction();

            $id_user = $request->user()->id;
            $login = Login::where('id', $id_user)->with('site')->first();
            $site = $login->site->id_site;

            $count = $conn->count(); 
            $count += 1;
            if ($count < 10) {
                $count = '0' . $count;
            }

            $conn->create([
                'id_karyawan' => $count,
                'id_site' => $site,
                'id_card_type' => $request->id_card_type,
                'nik_karyawan' => $request->nik_karyawan,
                'nama_karyawan' => $request->nama_karyawan,
                    // 'id_status_karyawan' => $request->id_status_karyawan,
                    // 'id_status_kawin_karyawan' => $request->id_status_kawin_karyawan,
                    // 'id_status_aktif_karyawan' => $request->id_status_aktif_karyawan,
                'kewarganegaraan' => $request->kewarganegaraan,
                'masa_berlaku_id' => $request->masa_berlaku_id,
                'alamat_ktp_karyawan' => $request->alamat_ktp_karyawan,
                'alamat_tinggal_karyawan' => $request->alamat_tinggal_karyawan,
                'provinsi' => $request->provinsi,
                'kode_pos' => $request->kode_pos,
                'no_telp_karyawan' => $request->no_telp_karyawan,
                'nik_pasangan_penjamin' => $request->nik_pasangan_penjamin,
                'nama_pasangan_penjamin' => $request->nama_pasangan_penjamin,
                'alamat_ktp_pasangan_penjamin' => $request->alamat_ktp_pasangan_penjamin,
                'alamat_tinggal_pasangan_penjamin' => $request->alamat_tinggal_pasangan_penjamin,
                'hubungan_penjamin' => $request->hubungan_penjamin,
                'no_telp_penjamin' => $request->no_telp_penjamin,
                'tgl_masuk' => $request->tgl_masuk,
                'tgl_keluar'=> $request->tgl_keluar,
                'id_jabatan' => $request->id_jabatan,
                'id_divisi'=> $request->id_divisi,
                'id_departemen'=> $request->id_departemen,
                'id_penempatan'=> $request->id_penempatan,
                'tempat_lahir'=> $request->tempat_lahir,
                'tgl_lahir'=> $request->tgl_lahir,
                'id_jenis_kelamin'=> $request->id_jenis_kelamin,
                'id_agama'=> $request->id_agama,
                'id_status_kawin'=> $request->id_status_kawin,
            ]);

            DB::commit();
            
            Alert::success('Berhasil', 'Berhasil menambahkan karyawan');

            return redirect()->route('karyawans.index');

        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::error('Gagal', 'Gagal menambahkan karyawan');

            return redirect()->route('karyawans.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
        $conn = $this->setConnection($request);

        $data['karyawan'] = $conn->where('id_karyawan', $id)->first();

        return view('AdminSite.Karyawan.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $conn = $this->setConnection($request);
        $karyawan = $conn->find($id);
        $karyawan->update($request->all());

        Alert::success('Berhasil', 'Berhasil mengupdate karyawan');

        return redirect()->route('karyawans.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $conn = $this->setConnection($request);
        $conn->find($id)->delete();

        Alert::success('Berhasil', 'Berhasil menghapus karyawan');

        return redirect()->route('karyawans.index');
    }
}
