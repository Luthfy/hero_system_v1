<?php

namespace App\Http\Controllers\API;

use App\Models\OTP;
use Ramsey\Uuid\Uuid;
use App\Models\Member;
use App\Models\Merchant;
use App\Helpers\OTPHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MerchantController extends Controller
{
    private $_status_merchant   = FALSE;
    private $_message_merchant  = "";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(['not found', 404]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'uuid_member'       => 'required',
            'email_merchant'    => 'required',
            'username_merchant' => 'required',
            'password_merchant' => 'required',
            'name_merchant'     => 'required'
        ];

        $messages = [
            'uuid_member.required'          => 'Member Hero Anda Tidak Ditemukan',
            'email_merchant.required'       => 'Email Anda Tidak Boleh Kosong',
            'username_merchant.required'    => 'Username Anda Tidak Boleh Kosong',
            'password_merchant.required'    => 'Password Anda Tidak Boleh Kosong',
            'name_merchant.required'        => 'Nama Anda Tidak Boleh Kosong'
        ];

        $request->validate($rules, $messages);

        if (Member::find($request->uuid_member))
        {
            $merchant = new Merchant();
            $merchant->uuid_merchant        = Uuid::uuid4()->getHex()->toString();
            $merchant->email_merchant       = $request->email_merchant;
            $merchant->username_merchant    = $request->username_merchant;
            $merchant->password_merchant    = bcrypt($request->password_merchant);
            $merchant->name_merchant        = $request->name_merchant;
            $merchant->uuid_member        = $request->uuid_member;
            $register = $merchant->save();

            if ($register)
            {
                $user = Merchant::find($merchant->uuid_merchant);
                return response()->json([
                    "status" => TRUE,
                    "message" => "success",
                    "data" => [
                        "user" => $user,
                        "token" => $user->createToken('merchant')->accessToken
                    ]
                ], 200);
            }
        }
        else
        {
            return response()->json([
                "status" => FALSE,
                "message" => "member not found"
            ], 200);
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
        $user = Merchant::find($id);

        if ($user)
        {
            return response()->json([
                'status' => TRUE,
                'message' => 'success',
                'data' => $user
            ]);
        }
        else
        {
            return response()->json([
                'status' => FALSE,
                'message' => 'user not found'
            ]);
        }
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
        $user = Merchant::find($id);

        if ($request->hasFile('photo_merchant'))
        {
            $request->validate([
                'photo_merchant' => 'mimes:png,jpg,jpeg|max:1024'
            ]);

            $filename  = time() . str_replace(" ", "", $request->file('photo_merchant')->getClientOriginalName());

            $filepath = $request->file('photo_merchant')->storeAs('public/storage/merchants/profile', $filename);

            @unlink($user->photo_merchant);

            $user->photo_merchant = $filepath;

        }

        $user->name_merchant        = $request->name_merchant;
        $user->birthday_merchant    = $request->birthday_merchant;
        $update = $user->save();

        if ($update)
        {
            return response()->json([
                "status" => TRUE,
                "message" => "success",
                "data" => $user
            ], 200);
        }
        else
        {
            return response()->json([
                "status" => FALSE,
                "message" => "something is wrong"
            ], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $revoke = $request->user()->token()->revoke();

        $delete = Merchant::find($id)->delete();

        if ($delete)
        {
            return response()->json([
                "status" => TRUE,
                "message" => "delete successfully",
            ], 200);
        }
    }


    public function login(Request $request)
    {
        $rules = [
            'username'  => 'required',
            'password'  => 'required',
            'code_area' => 'required'
        ];

        $message = [
            'username.required'     => 'Username anda tidak boleh kosong',
            'password.required'     => 'Password anda tidak boleh kosong',
            'code_area.required'    => 'Kode Area anda tidak ditemukan'
        ];

        $request->validate($rules, $message);

        $username   = $request->username;
        $password   = $request->password;
        $code_area  = $request->code_area;

        $user = Merchant::where('username_merchant', $username)->first();

        if ($user)
        {
            if (Hash::check($password, $user->password_merchant))
            {
                $receiver = $code_area . $user->username_merchant;

                $otp = new OTPHelper();
                $has_send = $otp->send_otp($receiver, $user->uuid_merchant, 3);

                $this->_status_merchant = TRUE;
                $this->_message_merchant = "success, " . $has_send["message"];

                $token = $user->createToken('secret')->accessToken;

                $data = [
                    "user" => $user,
                    "token" => $token
                ];

                return response()->json([
                    "status" => $this->_status_merchant,
                    "message" => $this->_message_merchant,
                    "data" => $data
                ], 200);
            }
            else
            {
                $this->_message_merchant = "password kamu tidak cocok";

                return response()->json([
                    "status" => $this->_status_merchant,
                    "message" => $this->_message_merchant
                ], 200);
            }
        }
        else
        {
            $this->_message_merchant = "username kamu tidak ditemukan";

            return response()->json([
                "status" => $this->_status_merchant,
                "message" => $this->_message_merchant
            ], 200);
        }

    }

    public function activated_by_otp(Request $request)
    {
        $rules = [
            'otp' => 'required'
        ];

        $message = [
            'otp.required' => 'Kode Otp tidak boleh kosong'
        ];

        $request->validate($rules, $message);

        $otp = $request->otp;
        $fcm = $request->fcm;

        $user_id = Auth::id();

        $otp = OTP::where('code', $otp)->where('user_type', 3)->where('uuid_user', $user_id)->first();

        if ($otp)
        {
            $user = Merchant::find($otp->uuid_user);
            $user->status = 1;
            $user->fcm = $fcm;
            $update = $user->save();

            if ($update)
            {
                return response()->json([
                    "status" => TRUE,
                    "message" => "success",
                    "data" => $user
                ], 200);
            }
            else
            {
                return response()->json([
                    "status" => FALSE,
                    "message" => "something is wrong",
                    "data" => $user
                ], 200);
            }

        }
        else
        {
            return response()->json([
                "status" => FALSE,
                "message" => "otp is wrong"
            ], 404);
        }

    }

    public function verified_auth()
    {
        $user = Auth::user();

        if ($user)
        {
            return response([
                "status" => TRUE,
                "message" => "success",
                "data" => $user
            ], 200);
        }
        else
        {
            return response([
                "status" => FALSE,
                "message" => "user not found",
                "error" => "your token not valid"
            ], 200);
        }
    }

    public function logout(Request $request)
    {
        $revoke = $request->user()->token()->revoke();

        if ($revoke)
        {
            return response()->json([
                'status' => TRUE,
                'message' => 'your has been logout'
            ],200);
        }
        else
        {
            return response()->json([
                'status' => FALSE,
                'message' => 'something is wrong'
            ], 422);
        }
    }

    public function upload_document(Request $request)
    {
        if ($request->hasFile('store') || $request->hasFile('ktp'))
        {
            $user = Merchant::find(Auth::id());

            if ($request->hasFile('ktp'))
            {
                $request->validate([
                    'ktp' => 'mimes:png,jpg,jpeg|max:1024'
                ]);

                $name_ktp   = time() . '_ktp_' . str_replace(" ", "", $request->file('ktp')->getClientOriginalName());
                $path_ktp   = $request->file('ktp')->storeAs('public/storage/merchants', $name_ktp);

                @unlink($user->idcard_merchant);

                $user->idcard_merchant = $path_ktp;

            }

            if ($request->hasFile('store'))
            {
                $request->validate([
                    'store' => 'mimes:png,jpg,jpeg|max:1024'
                ]);

                $name_merchant  = time() . '_store_' . str_replace(" ", "", $request->file('store')->getClientOriginalName());

                $path_merchant = $request->file('store')->storeAs('public/storage/merchants', $name_merchant);

                @unlink($user->store_merchant);

                $user->store_merchant = $path_merchant;

            }

            $user->save();

            return response()->json([
                "status" => TRUE,
                "message" => "success",
                "data" => $user
            ], 200);
        }
        else
        {
            return response()->json([
                "status" => FALSE,
                "message" => "document is not found"
            ], 200);
        }
    }
}
