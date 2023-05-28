<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ConnectionDB;
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
use App\Models\StatusAktifKaryawan;
use App\Models\StatusKaryawan;
use App\Models\User;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $connKaryawan = ConnectionDB::setConnection(new Karyawan());

        $data['karyawans'] = $connKaryawan->get();

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

        $users = ConnectionDB::setConnection(new User());

        $idcard = ConnectionDB::setConnection(new IdCard());

        $gender = ConnectionDB::setConnection(new JenisKelamin());

        $agama = ConnectionDB::setConnection(new Agama());

        $statuskawin = ConnectionDB::setConnection(new StatusKawin());

        $jabatan = ConnectionDB::setConnection(new Jabatan());

        $divisi = ConnectionDB::setConnection(new Divisi());

        $departemen = ConnectionDB::setConnection(new Departemen());

        $kepemilikan = ConnectionDB::setConnection(new KepemilikanUnit());

        $penempatan = ConnectionDB::setConnection(new Penempatan());
        
        $statuskaryawan = ConnectionDB::setConnection(new StatusKaryawan());

        $connStatusaktifkaryawan = ConnectionDB::setConnection(new StatusAktifKaryawan());

        $data['agamas'] = $agama->get();
        $data['jabatans'] = $jabatan->get();
        $data['jeniskelamins'] = $gender->get();
        $data['divisis'] = $divisi->get();
        $data['departemens'] = $departemen->get();
        $data['idcards'] = $idcard->get();
        $data['idusers'] = $users->get();
        $data['statuskawins'] = $statuskawin->get();
        $data['penempatans'] = $penempatan->get();
        $data['statuskaryawans'] = $statuskaryawan->get();
        $data['statusaktifkaryawans'] = $connStatusaktifkaryawan->get();

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
        $connKaryawan = ConnectionDB::setConnection(new Karyawan());

        try {
            DB::beginTransaction();

            $id_user = $request->user()->id;
            $login = Login::where('id', $id_user)->with('site')->first();
            $site = $login->site->id_site;

            // $count = $connKaryawan->count();
            // $count += 1;
            // if ($count < 10) {
            //     $count = '0' . $count;
            // }

            $karyawan = $connKaryawan->create([
                'id_site' => $site,
                'id_card_type' => $request->id_card_type,
                'nik_karyawan' => $request->nik_karyawan,
                'nama_karyawan' => $request->nama_karyawan,
                'email_karyawan' => $request->email_karyawan,
                'id_status_karyawan' => $request->id_status_karyawan,
                'id_status_kawin_karyawan' => $request->id_status_kawin_karyawan,
                'id_status_aktif_karyawan' => $request->id_status_aktif_karyawan,
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

            $karyawan->id_karyawan = sprintf("%04d", $karyawan->id);
            $karyawan->save();

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
        $agama = ConnectionDB::setConnection(new Agama());
        $users = ConnectionDB::setConnection(new User());
        $idcard = ConnectionDB::setConnection(new IdCard());
        $jabatans = ConnectionDB::setConnection(new Jabatan());
        $divisi = ConnectionDB::setConnection(new Divisi());
        $departemen = ConnectionDB::setConnection(new Departemen());
        $penempatan = ConnectionDB::setConnection(new Penempatan());
        $gender = ConnectionDB::setConnection(new JenisKelamin());
        $statuskawin = ConnectionDB::setConnection(new StatusKawin());
        $karyawan = ConnectionDB::setConnection(new Karyawan());

        $data['agamas'] = $agama->get();
        $data['jabatans'] = $jabatans->get();
        $data['jeniskelamins'] = $gender->get();
        $data['divisis'] = $divisi->get();
        $data['departemens'] = $departemen->get();
        $data['idcards'] = $idcard->get();
        $data['idusers'] = $users->get();
        $data['statuskawins'] = $statuskawin->get();
        $data['penempatans'] = $penempatan->get();
        $data['karyawan'] = $karyawan->find($id);

        return view('AdminSite.Karyawan.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
        $connKaryawan = ConnectionDB::setConnection(new Karyawan());
        $user = $request->session()->get('user');
        $connIdCard = ConnectionDB::setConnection(new IdCard());
        $connGender = ConnectionDB::setConnection(new JenisKelamin());
        $connAgama = ConnectionDB::setConnection(new Agama());
        $connStatusKawin = ConnectionDB::setConnection(new StatusKawin());
        $connJabatan = ConnectionDB::setConnection(new Jabatan());
        $connDivisi = ConnectionDB::setConnection(new Divisi());
        $connDepartemen = ConnectionDB::setConnection(new Departemen());
        $connKepemilikan = ConnectionDB::setConnection(new KepemilikanUnit());
        $connPenempatan = ConnectionDB::setConnection(new Penempatan());
        $connStatuskaryawan = ConnectionDB::setConnection(new StatusKaryawan());
        $connStatusaktifkaryawan = ConnectionDB::setConnection(new StatusAktifKaryawan());

        $data['karyawan'] = $connKaryawan->where('id_karyawan', $id)->first();
        $data['idusers'] = $user->get();
        $data['agamas'] = $connAgama->get();
        $data['jabatans'] = $connJabatan->get();
        $data['jeniskelamins'] = $connGender->get();
        $data['divisis'] = $connDivisi->get();
        $data['departemens'] = $connDepartemen->get();
        $data['kepemilikans'] = $connKepemilikan->get();
        $data['idcards'] = $connIdCard->get();
        $data['statuskawins'] = $connStatusKawin->get();
        $data['penempatans'] = $connPenempatan->get();
        $data['statuskaryawans'] = $connStatuskaryawan->get();
        $data['statusaktifkaryawans'] = $connStatusaktifkaryawan->get();
        

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
        $conn = ConnectionDB::setConnection(new Karyawan());
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
    public function destroy($id)
    {
        $conn = ConnectionDB::setConnection(new Karyawan());
        $conn->find($id)->delete();

        Alert::success('Berhasil', 'Berhasil menghapus karyawan');

        return redirect()->route('karyawans.index');
    }
}
