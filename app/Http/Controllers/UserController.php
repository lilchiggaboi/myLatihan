<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {

        $data['user'] = DB::select("
            SELECT
                u.*,
                mr.ROLE
            FROM
                user u
            LEFT JOIN md_role mr ON
                u.ID_ROLE = mr.ID_ROLE
        ");

        $data['role'] = DB::select("
            SELECT
                mr.*
            FROM
                md_role mr
        ");
        
        return
            view('header', $data) .
            view('admin.sidebar', $data) .
            view('admin.user', $data) .
            view('footer');
    }

    public function save_user(Request $req)
    {
        try {
            $data = [
                'ID_USER' => $this->GenerateUniqID(strip_tags($req->input('nama'))),
                'NAMA_USER' => $req->input('nama_user'),
                'EMAIL' => $req->input('email'),
                'PASSWORD' => $req->input('password'),
                'ID_ROLE' => $req->input('id_role'),
            ];

            DB::table('user')->insert($data);

            return redirect('admin/user')->with('success', 'Berhasil menambah data peminjaman');
        } catch (Exception $err) {
            return redirect('admin/user')->with('error', 'Gagal menambah data peminjaman, error : ' . $err);
        }
    }

    public function edit_user(Request $req)
    {
        try {
            $data = [
                "ID_USER" => $req->input('id_user'),
                "NAMA_USER" => $req->input('nama_user'),
                "EMAIL" => $req->input('email'),
                "PASSWORD" => $req->input('password'),
                "ID_ROLE" => $req->input('id_role'),
            ];

            DB::table('user')->where(['ID_USER' => $req->input('id_user')])->update($data);
            return redirect('admin/user')->with('success', 'Berhasil merubah data peminjaman');
        } catch (Exception $err) {
            return redirect('admin/user')->with('error', 'Gagal merubah data peminjaman, error : ' . $err);
        }
    }

    public function delete_user($idUser)
    {
        try {
            DB::table('user')->where(['ID_USER' => $idUser])->delete();
            return redirect('admin/user')->with('success', 'Berhasil menghapus data peminjaman');
        } catch (Exception $err) {
            return redirect('admin/user')->with('error', 'Gagal menghapus data peminjaman, error : ' . $err);
        }
    }

    public function alert()
    {
        return view('admin/user_alert');
    }

    public function GenerateUniqID($var)
    {
        $string = preg_replace('/[^a-z]/i', '', $var);
        $vocal  = array("a", "e", "i", "o", "u", "A", "E", "I", "O", "U", " ");
        $scrap  = str_replace($vocal, "", $string);
        $begin  = substr($scrap, 0, 4);
        $uniqid = strtoupper($begin);
        return "USR_" . $uniqid . substr(md5(time()), 0, 3);
    }

}
