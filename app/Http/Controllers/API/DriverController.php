<?php

namespace App\Http\Controllers\API;

use App\Models\OTP;
use Ramsey\Uuid\Uuid;
use App\Models\Driver;
use App\Models\Member;
use App\Helpers\OTPHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DriverController extends Controller
{

    private $_status_driver   = FALSE;
    private $_message_driver  = "";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            'uuid_member'     => 'required',
            'email_driver'    => 'required',
            'username_driver' => 'required',
            'password_driver' => 'required',
            'name_driver'     => 'required'
        ];

        $messages = [
            'uuid_member.required'        => 'Member Hero Anda Tidak Ditemukan',
            'email_driver.required'       => 'Email Anda Tidak Boleh Kosong',
            'username_driver.required'    => 'Username Anda Tidak Boleh Kosong',
            'password_driver.required'    => 'Password Anda Tidak Boleh Kosong',
            'name_driver.required'        => 'Nama Anda Tidak Boleh Kosong'
        ];

        $request->validate($rules, $messages);

        if (Member::find($request->uuid_member))
        {
            $driver = new Driver();
            $driver->uuid_driver        = Uuid::uuid4()->getHex()->toString();
            $driver->email_driver       = $request->email_driver;
            $driver->username_driver    = $request->username_driver;
            $driver->password_driver    = $request->password_driver;
            $driver->name_driver        = $request->name_driver;
            $driver->uuid_member        = $request->uuid_member;
            $register = $driver->save();

            if ($register)
            {
                $user = Driver::find($driver->uuid_driver);
                return response()->json([
                    "status" => TRUE,
                    "message" => "success",
                    "data" => [
                        "user" => $user,
                        "token" => $user->createToken('driver')->accessToken
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
        $user = Driver::find($id);

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
        $user = Driver::find($id);

        if ($request->hasFile('photo_driver'))
        {
            $request->validate([
                'photo_driver' => 'mimes:png,jpg,jpeg|max:1024'
            ]);

            $filename  = time() . str_replace(" ", "", $request->file('photo_driver')->getClientOriginalName());

            $filepath = $request->file('photo_driver')->storeAs('public/storage/drivers/profile', $filename);

            @unlink($user->photo_driver);

            $user->photo_driver = $filepath;

        }

        $user->name_driver = $request->name_driver;
        $user->birthday_driver = $request->birthday_driver;
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

        $delete = Driver::find($id)->delete();

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

        $user = Driver::where('username_driver', $username)->first();

        if ($user)
        {
            if (Hash::check($password, $user->password_driver))
            {
                $receiver = $code_area . $user->username_driver;

                $otp = new OTPHelper();
                $has_send = $otp->send_otp($receiver, $user->uuid_driver, 1);

                $this->_status_driver = TRUE;
                $this->_message_driver = "success, " . $has_send["message"];

                $token = $user->createToken('secret')->accessToken;

                $data = [
                    "user" => $user,
                    "token" => $token
                ];

                return response()->json([
                    "status" => $this->_status_driver,
                    "message" => $this->_message_driver,
                    "data" => $data
                ], 200);
            }
            else
            {
                $this->_message_driver = "password kamu tidak cocok";

                return response()->json([
                    "status" => $this->_status_driver,
                    "message" => $this->_message_driver
                ], 200);
            }
        }
        else
        {
            $this->_message_driver = "username kamu tidak ditemukan";

            return response()->json([
                "status" => $this->_status_driver,
                "message" => $this->_message_driver
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

        $otp = OTP::where('code', $otp)->where('user_type', 1)->where('uuid_user', $user_id)->first();

        if ($otp)
        {
            $user = Driver::find($otp->uuid_user);
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
        if ($request->hasFile('sim') || $request->hasFile('ktp'))
        {
            $user = Driver::find(Auth::id());
            if ($request->hasFile('ktp'))
            {
                $request->validate([
                    'kt[' => 'mimes:png,jpg,jpeg|max:1024'
                ]);

                $name_ktp   = time() . '_ktp_' . str_replace(" ", "", $request->file('ktp')->getClientOriginalName());
                $path_ktp   = $request->file('ktp')->storeAs('public/storage/drivers', $name_ktp);

                @unlink($user->idcard_driver);

                $user->idcard_driver = $path_ktp;

            }

            if ($request->hasFile('sim'))
            {
                $request->validate([
                    'sim' => 'mimes:png,jpg,jpeg|max:1024'
                ]);

                $name_driver  = time() . '_sim_' . str_replace(" ", "", $request->file('sim')->getClientOriginalName());
                $path_driver = $request->file('sim')->storeAs('public/storage/drivers', $name_driver);

                @unlink($user->license_driver);

                $user->license_driver = $path_driver;

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
