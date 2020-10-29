<?php

namespace App\Helpers;


use App\Models\OTP;
use Ramsey\Uuid\Uuid;
use App\Helpers\WooWaHelper;

/**
 * Modul OTP
 * send otp response is boolean,
 * otp is uniq code for verified the number and account
 * you must valid the phone number
 */
class OTPHelper
{

    public function send_otp($receiver_number, $uuid_user, $user_type)
    {
        $otp = new OTP();
        $otp->uuid      = Uuid::uuid4()->getHex()->toString();
        $otp->code      = rand(1000, 9999);
        $otp->user_type = $user_type;
        $otp->uuid_user = $uuid_user;
        $otp->save();

        $woowa = new WooWaHelper();

        if ($woowa->checkWaAvailable($receiver_number))
        {
            $has_been_send = $woowa->sendWaMessage($receiver_number, $otp->code);
            return [
                "status" => TRUE,
                "message" => "OTP Berhasil dikirimkan",
                "data" => $has_been_send
            ];
        }
        else
        {
            return [
                "status" => FALSE,
                "message" => "Nomor Whatsapp tidak valid"
            ];
        }
    }
}


