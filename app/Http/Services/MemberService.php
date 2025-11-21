<?php

namespace App\Http\Services;

use App\Models\Member;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class MemberService
{
    /**
     * Create a new member with initial balance 0.
     *
     * @param array $data
     * @return Member
     */
    public function createMember(array $data): Member
    {
        $member = Member::create(array_merge($data, [
            'balance' => 0,
        ]));

        Redis::lpush("member:{$member->id}:logs", json_encode([
            'action' => 'create_member',
            'name' => $member->name,
            'email' => $member->email,
            'phone' => $member->phone,
            'initial_balance' => 0,
            'by' => Auth::user()?->email ?? 'system',
            'time' => now()->toDateTimeString(),
        ]));


        return $member;
    }
}
