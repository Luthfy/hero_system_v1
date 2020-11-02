<?php

namespace App\Http\Controllers\API;

use App\Models\OTP;
use Ramsey\Uuid\Uuid;
use App\Models\Member;
use App\Models\Customer;
use App\Helpers\OTPHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{

    private $_status_customer   = FALSE;
    private $_message_customer  = "";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response("not found", 404);
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
            'email_customer'    => 'required',
            'whatsapp_customer' => 'required',
            'password_customer' => 'required',
            'name_customer'     => 'required'
        ];

        $messages = [
            'uuid_member.required'          => 'Member Hero Anda Tidak Ditemukan',
            'email_customer.required'       => 'Email Anda Tidak Boleh Kosong',
            'whatsapp_customer.required'    => 'Username Anda Tidak Boleh Kosong',
            'password_customer.required'    => 'Password Anda Tidak Boleh Kosong',
            'name_customer.required'        => 'Nama Anda Tidak Boleh Kosong'
        ];

        $request->validate($rules, $messages);

        if (Member::find($request->uuid_member))
        {
            $customer = new Customer();
            $customer->uuid_customer        = Uuid::uuid4()->getHex()->toString();
            $customer->email_customer       = $request->email_customer;
            $customer->username_customer    = $request->whatsapp_customer;
            $customer->password_customer    = bcrypt($request->password_customer);
            $customer->name_customer        = $request->name_customer;
            $customer->uuid_member          = $request->uuid_member;
            $register = $customer->save();

            if ($register)
            {
                $user = Customer::find($customer->uuid_customer);
                return response()->json([
                    "status" => TRUE,
                    "message" => "success",
                    "data" => [
                        "user" => $user,
                        "token" => $user->createToken('customer')->accessToken
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
        $user = Customer::find($id);

        if ($user)
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
                "message" => "user not found",
            ], 200);
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

        $user = Customer::find($id);

        if ($request->hasFile('photo_customer'))
        {
            $request->validate([
                'photo_customer' => 'mimes:png,jpg,jpeg|max:1024'
            ]);

            $filename  = time() . str_replace(" ", "", $request->file('photo_customer')->getClientOriginalName());

            $filepath = $request->file('photo_customer')->storeAs('public/storage/customers/profile', $filename);

            @unlink($user->photo_customer);

            $user->photo_customer = $filepath;

        }

        $user->name_customer = $request->name_customer;
        $user->birthday_customer = $request->birthday_customer;
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

        $delete = Customer::find($id)->delete();

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
            'username' => 'required',
            'password' => 'required',
            'code_area' => 'required'
        ];

        $message = [
            'username.required' => 'Username anda tidak boleh kosong',
            'password.required' => 'Password anda tidak boleh kosong',
            'code_area.required' => 'Kode Area anda tidak ditemukan'
        ];

        $request->validate($rules, $message);

        $username   = $request->username;
        $password   = $request->password;
        $code_area  = $request->code_area;

        $user = Customer::where('username_customer', $username)->first();

        if ($user)
        {
            if (Hash::check($password, $user->password_customer))
            {
                $receiver = $code_area . $user->username_customer;

                $otp = new OTPHelper();
                $has_send = $otp->send_otp($receiver, $user->uuid_customer, 1);

                $this->_status_customer = TRUE;
                $this->_message_customer = "success, " . $has_send["message"];

                $token = $user->createToken('secret')->accessToken;
                $data = [
                    "user" => $user,
                    "token" => $token
                ];

                return response()->json([
                    "status" => $this->_status_customer,
                    "message" => $this->_message_customer,
                    "data" => $data
                ], 200);
            }
            else
            {
                $this->_message_customer = "password kamu tidak cocok";

                return response()->json([
                    "status" => $this->_status_customer,
                    "message" => $this->_message_customer
                ], 200);
            }
        }
        else
        {
            $this->_message_customer = "username kamu tidak ditemukan";

            return response()->json([
                "status" => $this->_status_customer,
                "message" => $this->_message_customer
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
            $user = Customer::find($otp->uuid_user);
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
        if ($request->hasFile('foto_ktp'))
        {
            $request->validate([
                'foto_ktp' => 'mimes:png,jpg,jpeg|max:1024'
            ]);

            $filename  = time() . '_ktp_' . str_replace(" ", "", $request->file('foto_ktp')->getClientOriginalName());

            $filepath = $request->file('foto_ktp')->storeAs('public/storage/customers', $filename);

            $user = Customer::find(Auth::id());

            @unlink($user->idcard_customer);

            $user->idcard_customer = $filepath;
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
