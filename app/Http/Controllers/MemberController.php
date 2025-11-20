<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Http\Services\MemberService;
use App\Http\Requests\StoreMemberRequest;
use App\Http\Requests\UpdateMemberRequest;
use Symfony\Component\HttpFoundation\Request;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, MemberService $memberService)
    {
        $members = $memberService->getAllMembers($request->only('search'));
        return view("member.index", compact("members"));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMemberRequest $request, MemberService $memberService)
    {
        $memberService->createMember($request->validated());

        return redirect()->route('members.index')->with('success', 'Member created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Member $member)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMemberRequest $request, Member $member)
    {
        //
    }

}
