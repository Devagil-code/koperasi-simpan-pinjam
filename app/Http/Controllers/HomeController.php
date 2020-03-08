<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Anggota;
use App\Divisi;
use Illuminate\Support\Facades\DB;
use Options;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $countAnggota = Anggota::select()->count();
        $countDivisi = Divisi::select()->count();
        return view('home')->with(compact('countAnggota', 'countDivisi'));
    }

    public function authOtp(Request $request)
    {
        $URL = 'https://indocast.asia/gateway/auth';
        $tenantId = "20001";
        $token = "secret_token";
        $userExtId = uniqid();

        $authParams = new \stdClass();
        $authParams->guiText = "Do you okay this transaction";
        $authParams->guiHeader = "Authorization requested";
        $req = new \stdClass();
        $req->tenantId = $tenantId;
        $req->userExternalId = $userExtId;
        $req->type = "101";
        $req->authParams = $authParams;

        $signatureText = $tenantId.$userExtId.$authParams->guiHeader.$authParams->guiText.$req->type.$token;
        $hashed = hash("sha256", $signatureText);
        $signature = base64_encode(hex2bin($hashed));
        $req->signature = $signature;
        $data_string = json_encode($req);
        //dd($data_string);
        $curl = curl_init();
        // Set some options - we are passing in a useragent too here
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $URL,
            CURLOPT_USERAGENT => 'OKay Demo'
        ]);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string))
        );
        // Send the request & save response to $resp
        $resp = curl_exec($curl);
        //var_dump($resp);
        // Close request to clear up some resources
        curl_close($curl);

        return response()->json([
            'resp' => $resp
        ]);
    }
}
