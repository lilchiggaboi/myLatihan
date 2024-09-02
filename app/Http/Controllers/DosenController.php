<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DosenController extends Controller
{
    public function index()
    {
        $data['dosen'] = DB::select("
            SELECT
                *
            FROM
                dosen
        ");
        
        return
            view('header', $data) .
            view('admin.sidebar', $data) .
            view('admin.dosen', $data) .
            view('footer');
    }

    public function save_dosen(Request $req)
    {
        try {
            $data = [
                'NIP_DOSEN' => $req->input('nip_dosen'),
                'NAMA_DOSEN' => $req->input('nama_dosen'),
                'NOTELP_DOSEN' => $req->input('notelp_dosen'),
                'EMAIL_DOSEN' => $req->input('email_dosen'),
            ];

            DB::table('dosen')->insert($data);

            return redirect('admin/dosen')->with('success', 'Berhasil menambah data peminjaman');
        } catch (Exception $err) {
            return redirect('admin/dosen')->with('error', 'Gagal menambah data peminjaman, error : ' . $err);
        }
    }

    public function edit_dosen(Request $req)
    {
        try {
            $data = [
                "NIP_DOSEN" => $req->input('nip_dosen'),
                "NAMA_DOSEN" => $req->input('nama_dosen'),
                "NOTELP_DOSEN" => $req->input('notelp_dosen'),
                "EMAIL_DOSEN" => $req->input('email_dosen'),
            ];

            DB::table('dosen')->where(['NIP_DOSEN' => $req->input('nip_dosen')])->update($data);
            return redirect('admin/dosen')->with('success', 'Berhasil merubah data peminjaman');
        } catch (Exception $err) {
            return redirect('admin/dosen')->with('error', 'Gagal merubah data peminjaman, error : ' . $err);
        }
    }

    public function delete_dosen($nipDosen)
    {
        try {
            DB::table('dosen')->where(['NIP_DOSEN' => $nipDosen])->delete();
            return redirect('admin/dosen')->with('success', 'Berhasil menghapus data peminjaman');
        } catch (Exception $err) {
            return redirect('admin/dosen')->with('error', 'Gagal menghapus data peminjaman, error : ' . $err);
        }
    }

    public function deleteSelectedDosen(Request $request)
{
    try {
        $ids = $request->input('ids');

        if (!empty($ids)) {
            DB::table('dosen')->whereIn('NIP_DOSEN', $ids)->delete();
            return response()->json(['success' => true, 'message' => 'Berhasil menghapus data dosen yang dipilih']);
        } else {
            return response()->json(['success' => false, 'message' => 'Tidak ada data yang dipilih']);
        }
    } catch (Exception $err) {
        return response()->json(['success' => false, 'message' => 'Gagal menghapus data dosen, error: ' . $err->getMessage()]);
    }
}

    public function alert()
    {
        return view('admin/dosen_alert');
    }

}
