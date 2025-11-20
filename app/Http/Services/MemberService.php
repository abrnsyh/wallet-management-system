<?php

namespace App\Http\Services;

use App\Models\Member;

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
        return Member::create(array_merge($data, ['balance' => 0]));
    }
}
