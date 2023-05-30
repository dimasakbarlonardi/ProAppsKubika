<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ConnectionDB;
use App\Http\Controllers\Controller;
use App\Models\Agama;
use App\Models\OwnerH;
use Illuminate\Http\Request;
use App\Models\Login;
use App\Models\IdCard;
use App\Models\JenisKelamin;
use App\Models\StatusKawin;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class OwnerHController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $conn = ConnectionDB::setConnection(new OwnerH());

        $data['owners'] = $conn->get();

        return view('AdminSite.Owner.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $user_id = $request->user()->id;
        $login = Login::where('id', $user_id)->with('site')->first();
        $conn = $login->site->db_name;
        $owner = new OwnerH();
        $owner->setConnection($conn);

        $idcard = new IdCard();
        $idcard->setConnection($conn);

        $gender = new JenisKelamin();
        $gender->setConnection($conn);

        $agama = new Agama();
        $agama->setConnection($conn);

        $statuskawin = new StatusKawin();
        $statuskawin->setConnection($conn);

        $data['agamas'] = $agama->get();
        $data['genders'] = $gender->get();
        $data['idcards'] = $idcard->get();
        $data['idusers'] =  Login::where('id', $user_id)->get();
        $data['statuskawins'] = $statuskawin->get();

        return view('AdminSite.Owner.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $conn = ConnectionDB::setConnection(new OwnerH());

        $checkNIK = $conn->where('nik_pemilik', $request->nik_pemilik)->first();
        $checkEmail = $conn->where('email_owner', $request->email_owner)->first();

        if (isset($checkNIK)) {
            Alert::error('Maaf', 'NIK sudah terdaftar');
            return redirect()->back()->withInput();
        }

        if (isset($checkEmail)) {
            Alert::error('Maaf', 'Email sudah terdaftar');
            return redirect()->back()->withInput();
        }

        try {
            DB::beginTransaction();

            $id_user = $request->user()->id;
            $login = Login::where('id', $id_user)->with('site')->first();
            $site = $login->site->id_site;

            $count = $conn->get();
            $count = $count->count() + 1;

            $conn->create([
                'id_pemilik' => sprintf("%09d", $count),
                'id_site' => $site,
                // 'id_user' => $id_user,
                'email_owner' => $request->email_owner,
                'id_card_type' => $request->id_card_type,
                'nik_pemilik' => $request->nik_pemilik,
                'nama_pemilik' => $request->nama_pemilik,
                // 'id_status_aktif_pemilik' => $request->id_status_aktif_pemilik,
                'kewarganegaraan' => $request->kewarganegaraan,
                'masa_berlaku_id' => $request->masa_berlaku_id,
                'alamat_ktp_pemilik' => $request->alamat_ktp_pemilik,
                'alamat_tinggal_pemilik' => $request->alamat_tinggal_pemilik,
                'provinsi' => $request->provinsi,
                'kode_pos' => $request->kode_pos,
                'no_telp_pemilik' => $request->no_telp_pemilik,
                'nik_pasangan_penjamin' => $request->nik_pasangan_penjamin,
                'nama_pasangan_penjamin' => $request->nama_pasangan_penjamin,
                'alamat_ktp_pasangan_penjamin' => $request->alamat_ktp_pasangan_penjamin,
                'alamat_tinggal_pasangan_penjamin' => $request->alamat_tinggal_pasangan_penjamin,
                'hubungan_penjamin' => $request->hubungan_penjamin,
                'no_telp_penjamin'=> $request->no_telp_penjamin,
                'tgl_masuk' => $request->tgl_masuk,
                'tgl_keluar' => $request->tgl_keluar,
                'id_kepemilikan_unit'=> $request->id_kepemilikan_unit,
                'tempat_lahir'=> $request->tempat_lahir,
                'tgl_lahir'=> $request->tgl_lahir,
                'id_jenis_kelamin'=> $request->id_jenis_kelamin,
                'id_agama'=> $request->id_agama,
                'id_status_kawin'=> $request->id_status_kawin,
                'pekerjaan'=> $request->pekerjaan,
                'nik_kontak_pic'=> $request->nik_kontak_pic,
                'nama_kontak_pic'=> $request->nama_kontak_pic,
                'alamat_tinggal_kontak_pic'=> $request->alamat_tinggal_kontak_pic,
                'email_kontak_pic'=> $request->email_kontak_pic,
                'no_telp_kontak_pic'=> $request->no_telp_kontak_pic,
                'hubungan_kontak_pic' => $request->hubungan_kontak_pic
            ]);

            DB::commit();

            Alert::success('Berhasil', 'Berhasil menambahkan pemilik');

            return redirect()->route('owners.index');

        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::error('Gagal', 'Gagal menambahkan pemilik');

            return redirect()->route('owners.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $conn = ConnectionDB::setConnection(new OwnerH());
        $user_id = $request->user()->id;

        $data['owners'] = $conn->where('id_pemilik', $id)->first();
        $data['idusers'] =  Login::where('id', $user_id)->get();

        return view('AdminSite.Owner.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
        $connOwner = ConnectionDB::setConnection(new OwnerH());
        $connIdcard = ConnectionDB::setConnection(new IdCard());
        $connGender = ConnectionDB::setConnection(new JenisKelamin());
        $connAgama = ConnectionDB::setConnection(new Agama());
        $connKawin = ConnectionDB::setConnection(new StatusKawin());
        $user_id = $request->user()->id;

        $data['owner'] = $connOwner->where('id_pemilik', $id)->first();
        $data['idcards'] = $connIdcard->get();
        $data['genders'] = $connGender->get();
        $data['agamas'] = $connAgama->get();
        $data['statuskawins'] = $connKawin->get();
        $data['idusers'] =  Login::where('id', $user_id)->get();

        return view('AdminSite.Owner.edit', $data);
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
        $conn = ConnectionDB::setConnection(new OwnerH());

        $owner = $conn->find($id);

        $owner->update($request->all());

        Alert::success('Berhasil', 'Berhasil mengupdate pemilik');

        return redirect()->route('owners.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request ,$id)
    {
        $conn = ConnectionDB::setConnection(new OwnerH());

        $conn->find($id)->delete();

        Alert::success('Berhasil', 'Berhasil menghapus pemilik');

        return redirect()->route('owners.index');
    }
}
