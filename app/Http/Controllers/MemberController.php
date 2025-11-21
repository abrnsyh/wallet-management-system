<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Http\Services\MemberService;
use App\Http\Requests\StoreMemberRequest;
use App\Http\Requests\UpdateMemberRequest;
use App\Models\Transaction;
use Illuminate\Support\Facades\Redis;
use Symfony\Component\HttpFoundation\Request;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $members = Member::query();

        if ($request->filled('search')) {
            $search = $request->search;

            $members->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $members = $members
            ->orderBy('updated_at', 'desc')
            ->paginate(10)
            ->withQueryString(); // penting kalau mau pagination tetap bawa search

        return view('member.index', compact('members'));
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
        $transactions = $member->transactions()
            ->when(request('type'), function ($q) {
                $q->where('type', request('type'));
            })
            ->when(request('date'), function ($q) {
                $q->whereDate('created_at', request('date'));
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString(); // penting!

        return view('member.show', compact('member', 'transactions'));
    }

    public function logIndex(Member $member)
    {
        $logs = collect(Redis::lrange("member:{$member->id}:logs", 0, 50))
            ->map(fn ($item) => json_decode($item, true));

        return view('member.logs', compact('member', 'logs'));
    }


}
