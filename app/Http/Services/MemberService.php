<?php

namespace App\Http\Services;

use App\Models\Member;

class MemberService
{
    public function getAllMembers(array $filters = [])
    {
        $query = Member::query();

        if (! empty($filters['search'])) {
            $query->where('name', 'like', '%'.$filters['search'].'%')
                ->orWhere('email', 'like', '%'.$filters['search'].'%')
                ->orWhere('phone', 'like', '%'.$filters['search'].'%');
        }

        return $query->paginate(10);
    }
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
