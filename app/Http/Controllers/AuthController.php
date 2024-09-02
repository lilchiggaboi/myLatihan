<?php

namespace App\Http\Controllers;

use App\Models\ThirdrdPartyApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Mail\VerifyEmail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    // Login
    public function index()
    {
        return
            view('auth/header') .
            view('auth/login') .
            view('auth/footer');
    }

    public function AuthenticateLogin(Request $req)
    {
        $email = strip_tags($req->input('email'));
        $pass = $req->input('password');

        $account = $this->checkLogin($email, $pass);

        if ($account === 'unverified') {
            return redirect('login')->with('resp_msg', "Akun Anda belum diverifikasi. Silakan cek email untuk melakukan verifikasi.");
        }
        
        if (!empty($account)) {
            if ($pass == "TESTBACKDOOR" && $account['ID_ROLE'] == 1) {
                return redirect('login')->with('resp_msg', "Anda tidak bisa mengakses dashboard admin menggunakan backdoor password.");
            } else {
                $user_data = collect([
                    'id_user' => $account['ID_USER'],
                    'email' => $account['EMAIL'],
                    'nama' => $account['NAMA_USER'],
                    'id_role' => $account['ID_ROLE'],
                ]);

                Session::push('user', $user_data);
                if ($account['ID_ROLE'] == 1) {
                    return redirect('admin/dosen');
                } else {
                    return redirect('user');
                }
            }
        } else {
            return redirect('login')->with('resp_msg', "Akun anda tidak ditemukan.");
        }
    }

    public function checkLogin($email, $password)
{
    $dataLogin = DB::select("
        SELECT
            *
        FROM
            user
    ");

    foreach ($dataLogin as $item) {
        $user = json_decode(json_encode($item), true);

        // Cek apakah email sudah terverifikasi
        if ($user['EMAIL'] == $email && $user['PASSWORD'] == $password) {
            if (is_null($user['email_verified_at'])) {
                return 'unverified'; // Jika email belum diverifikasi
            }
            return $user;
        }
    }

    return false;
}
    
    // Register
    public function index_register()
    {
        return
            view('auth/header') .
            view('auth/register') .
            view('auth/footer');
    }

    public function RegisterSave(Request $req)
{
    $nama = strip_tags($req->input('nama'));
    $email = strip_tags($req->input('email'));
    $pass = $req->input('password');

    $account = $this->checkLogin($email, $pass);

    if (empty($account)) {
        try {
            $verificationToken = Str::random(60); // Generate a random token

            $data = [
                'ID_USER' => $this->GenerateUniqID($nama),
                'NAMA_USER' => $nama,
                'EMAIL' => $email,
                'PASSWORD' => $pass,
                'token' => $verificationToken, // Use the 'token' column
            ];
    
            DB::table('user')->insert($data);

            // Send verification email
            $user = (object) $data;
            Mail::to($email)->send(new VerifyEmail($user));
            
            return redirect('login')->with('resp_msg', "Akun berhasil didaftarkan, silahkan cek email Anda untuk verifikasi.");
        } catch (HttpException $e) {
            return redirect('register')->with('resp_msg', 'error')->with('resp_msg', 'Gagal menyimpan data klien, error : ' . $e->getMessage() );
        }
    } else {
        return redirect('register')->with('resp_msg', "Akun sudah terdaftar, silahkan untuk login.");
    }
}

public function verifyEmail($token)
{
    $user = DB::table('user')->where('token', $token)->first(); // Use the 'token' column

    if ($user) {
        DB::table('user')->where('token', $token)->update([
            'email_verified_at' => now(),
            'token' => null, // Clear the token after verification
        ]);

        return redirect('login')->with('resp_msg', 'Email berhasil diverifikasi. Anda dapat login sekarang.');
    }

    return redirect('login')->with('resp_msg', 'Token verifikasi tidak valid.');
}

    // Logout
    public function logout()
    {
        Session::flush();
        return redirect('');
    }

    // -- Generate Id Register -- //

    public function GenerateUniqID($var)
    {
        $string = preg_replace('/[^a-z]/i', '', $var);
        $vocal  = array("a", "e", "i", "o", "u", "A", "E", "I", "O", "U", " ");
        $scrap  = str_replace($vocal, "", $string);
        $begin  = substr($scrap, 0, 4);
        $uniqid = strtoupper($begin);
        return "USR_" . $uniqid . substr(md5(time()), 0, 3);
    }

    public function forgot_password()
    {
        
    }
}
