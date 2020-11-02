<?php

namespace App\Http\Controllers\API;

use Ramsey\Uuid\Uuid;
use App\Models\Driver;
use App\Models\Member;
use App\Models\Wallet;
use App\Models\Customer;
use App\Models\Affiliate;
use App\Models\LevelMember;
use Illuminate\Support\Str;
use App\Helpers\WooWaHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MemberController extends Controller
{
    private $message = " ";

    public function index()
    {
        return response("not found", 404);
    }

    public function store(Request $request)
    {
        $rules = [
            'name'              => 'required',
            'email'             => 'required|email|unique:members,email_member',
            'area_code'         => 'required',
            'whatsapp'          => 'required|numeric|unique:members,whatsapp_member',
            'password'          => 'required',
            'password_confirm'  => 'required',
            'app'               => 'required'
        ];

        $messages = [
            'name.required'                     => 'Nama Tidak Boleh Kosong',
            'email.required'                    => 'Email Tidak Boleh Kosong',
            'email.email'                       => 'Email Tidak Sah',
            'email.unique'                      => 'Email Telah Terdaftar',
            'area_code.required'                => 'Kode Area Tidak Boleh Kosong',
            'whatsapp.required'                 => 'Whatsapp Tidak Boleh Kosong',
            'whatsapp.numeric'                  => 'Nomor Tidak Valid',
            'whatsapp.unique'                   => 'Whatsapp Sudah Pernah Didaftarkan',
            'password.required'                 => 'Password Tidak Boleh Kosong',
            'password_confirm.required'         => 'Password Confirm Tidak Boleh Kosong',
            'app.required'                      => 'Periksa APP Type Anda'
        ];

        $request->validate($rules, $messages);

        if ($request->password == $request->password_confirm)
        {
            $refferal_is_valid = $this->validate_refferal_member($request->refferal_member);

            $member = new Member();
            $member->uuid_member        = Uuid::uuid4()->getHex()->toString();
            $member->name_member        = $request->name;
            $member->area_code_member   = $request->area_code;
            $member->whatsapp_member    = $request->whatsapp;
            $member->email_member       = $request->email;
            $member->password_member    = bcrypt($request->password);
            $member->token_member       = Str::random(6);
            $member->refferal_member    = $refferal_is_valid;
            $member->id_ref_member      = $this->generate_refferal_code($request->whatsapp, $request->app);
            $member->status_member      = 0;
            $member->save();

            $data["member"] = $member;

            $wallet = new Wallet();
            $wallet->uuid_wallet        = Uuid::uuid4()->getHex()->toString();
            $wallet->uuid_member        = $member->uuid_member;
            $wallet->id_level_member  = $this->set_up_level_member($member->id_ref_member)->id;
            $wallet->save();

            $data["wallet"] = Wallet::find($wallet->uuid_wallet);

            if ($request->app == 1)
            {
                $customer = new Customer();
                $customer->uuid_customer        = Uuid::uuid4()->getHex()->toString();
                $customer->email_customer       = $member->email_member;
                $customer->username_customer    = $member->whatsapp_member;
                $customer->password_customer    = $member->password_member;
                $customer->name_customer        = $member->name_member;
                $customer->uuid_member          = $member->uuid_member;
                $customer->save();

                $data["user"] = Customer::find($customer->uuid_customer);

                $message  = "Selamat Anda Telah Tergabung di Hero Indonesia\n";
                $message .= "Username : " . $customer->username_customer . "\n";
                $message .= "Password : " . $request->password . "\n";
                $message .= "\n";
                $message .= "Untuk mengaktifkan Status Member Anda Silakan Masukan Token \n";
                $message .= "Token Member : *" . $member->token_member . "*\n";
                $message .= " \n";
                $message .= "Terimakasih\n";
                $message .= "Admin Hero\n";

                $wahelper       = new WooWaHelper();
                $no_wahtsapp    = $request->area_code ."".$request->whatsapp;

                $member_refferal = Member::where('id_ref_member', $member->refferal_member)->first();

                if ($member_refferal != null)
                {
                    Affiliate::create([
                        "uuid_affiliate" => Uuid::uuid4()->getHex()->toString(),
                        "uuid_member" => $member_refferal->uuid_member,
                        "uuid_member_child" => $member->uuid_member
                    ]);

                    $message_to_refferal  = "Selamat Downline anda bertambah \n";
                    $message_to_refferal .= "Atas Nama " . $customer->name_customer . "\n";
                    $message_to_refferal .= "Kode Refferal Member Anda : " . $member->id_ref_member . "\n";

                    $send_wa_refferal = $wahelper->sendWaMessage($member_refferal->whatsapp_member, $message_to_refferal);
                }


                if ($wahelper->checkWaAvailable($no_wahtsapp) == "exists")
                {
                    $wahelper->sendWaMessage($no_wahtsapp, $message);
                }
                else
                {
                    $this->message .= ", whatssapp tidak valid";
                }

                $data["token"] = $customer->createToken('customer')->accessToken;

                return [
                  "status" => TRUE,
                  "message"=> "success" . $this->message,
                  "data" => $data
                ];
            }
            else if ($request->app == 2)
            {
                $driver = new Driver();
                $driver->uuid_driver        = Uuid::uuid4()->getHex()->toString();
                $driver->email_driver       = $member->email_member;
                $driver->username_driver    = $member->whatsapp_member;
                $driver->password_driver    = $member->password_member;
                $driver->name_driver        = $member->name_member;
                $driver->uuid_member        = $member->uuid_member;
                $driver->save();

                $data["user"] = Driver::find($driver->uuid_driver);


                $message  = "Selamat Anda Telah Tergabung di Hero Indonesia Sebagai Driver \n";
                $message .= "Username : " . $driver->username_driver . "\n";
                $message .= "Password : " . $request->password . "\n";
                $message .= "\n";
                $message .= "Untuk mengaktifkan Status Member Anda Silakan Masukan Token \n";
                $message .= "Token Member : *" . $member->token_member . "*\n";
                $message .= " \n";
                $message .= "Terimakasih\n";
                $message .= "Admin Hero\n";

                $wahelper       = new WooWaHelper();
                $no_wahtsapp    = $request->area_code ."".$request->whatsapp;

                $member_refferal = Member::where('id_ref_member', $member->refferal_member)->first();

                if ($member_refferal != null)
                {
                    Affiliate::create([
                        "uuid_affiliate" => Uuid::uuid4()->getHex()->toString(),
                        "uuid_member" => $member_refferal->uuid_member,
                        "uuid_member_child" => $member->uuid_member
                    ]);

                    $message_to_refferal  = "Selamat Downline anda bertambah \n";
                    $message_to_refferal .= "Atas Nama " . $driver->name_driver . "\n";
                    $message_to_refferal .= "Kode Refferal Member Anda : " . $member->id_ref_member . "\n";

                    $send_wa_refferal = $wahelper->sendWaMessage($member_refferal->whatsapp_member, $message_to_refferal);
                }

                if ($wahelper->checkWaAvailable($no_wahtsapp) == "exists")
                {
                    $wahelper->sendWaMessage($no_wahtsapp, $message);
                }
                else
                {
                    $this->message .= ", whatssapp tidak valid";
                }

                $data["token"] = $driver->createToken('driver')->accessToken;

                return [
                  "status" => TRUE,
                  "message"=> "success" . $this->message,
                  "data" => $data
                ];
            }

        }
        else
        {
            return response([
                "status"    => FALSE,
                "message"   => "password anda tidak sama"
            ], 200);
        }


    }

    public function activated_member_with_token(Request $request)
    {
        $rules = [
            'token' => 'required',
        ];

        $messages = [
            'token.required' => 'Token tidak boleh kosong'
        ];

        $request->validate($rules, $messages);

        $member = Member::find($request->uuid_member);

        if ($request->token == $member->token_member)
        {
            $member->status_member = 1;
            $member->save();

            return response([
                "status" => TRUE,
                "message" => 'aktivasi token berhasil',
                "data" => $member
            ]);
        }
        else
        {
            return response([
                "status" => FALSE,
                "message" => 'token anda tidak cocok'
            ]);
        }
    }

    public function check_member(Request $request)
    {
        $rules = [
            'member_id' => 'required',
        ];

        $messages = [
            'member_id.required' => 'Member Tidak Boleh Kosong',
        ];

        $request->validate($rules, $messages);

        $member = ($request->user_kind_id == '1') ? Member::where('whatsapp_member', $request->member_id)->select("uuid_member", "id_ref_member", "name_member")->first() : Member::where('email_member', $request->member_id)->select("uuid_member", "id_ref_member", "name_member")->first();

        if ($member == null)
        {
            return response([
                "status" => FALSE,
                "message"=> "member id tidak ditemukan",
            ], 200);
        }
        else
        {
            return response([
                "status" => TRUE,
                "message"=> "member ditemukan",
                "data" => $member
            ], 200);
        }

    }

    private function validate_refferal_member($refferal)
    {
        $member_count = Member::where('id_ref_member', $refferal)->count();

        if ($member_count < 1)
        {
            $this->message .= "tapi id refferal tidak valid";
            return null;
        }
        else
        {
            return $refferal;
        }
    }

    private function generate_refferal_code($whatsapp, $app)
    {
        if ($app == 1)
        {
            return "HRC-" . $whatsapp;
        }
        else if ($app == 2)
        {
            return "HRD-" . $whatsapp;
        }
        else if ($app == 3)
        {
            return "HRM-" . $whatsapp;
        }
        else
        {
            return "app illegal";
        }
    }

    private function set_up_level_member($refferal)
    {
        if ($refferal == null)
        {
            return LevelMember::where('name_level_member','Downloader Free')->first();
        }
        else
        {
            $member = Member::where('id_ref_member', $refferal)->count();

            if ($member == 1)
            {
                return LevelMember::where('name_level_member','Reseller Free')->first();
            }
            else
            {
                return LevelMember::where('name_level_member','Downloader Free')->first();
            }
        }
    }
}
