<?php

namespace app\Traits;

use App\Models\LevelMember;
use App\Models\Member;
use App\Models\Wallet;

/**
 * Modul Push Up New Member
 */
trait PushUp
{
    public function pushUpSystem ($uuid_member, $uuid_level_member, $is_new = FALSE)
    {
        $member         = Member::find($uuid_member)->first();
        $wallet_member  = Wallet::where('uuid_member', $uuid_member)->first();
        $level_member   = LevelMember::find($uuid_level_member);

        // menambahkan poin sesuai dengan level upgrade member
        $wallet_member->poin    = (int) $wallet_member->poin + (int) $level_member->poin_level_member;
        $upgrade_level_member   = $wallet_member->save();

        // jika member baru berikan bonus
        if ($is_new)
        {

        }
    }
}


