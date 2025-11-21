<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDeductRequest;
use App\Http\Requests\StoreTopupRequest;
use App\Http\Services\TransactionService;
use App\Models\Transaction;
use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;
use App\Models\Member;

class TransactionController extends Controller
{


    public function topup(Member $member, StoreTopupRequest $request, TransactionService $service)
    {
        try {
            $service->topup($member, $request->validated()['amount'], $request->description);
        } catch (\Exception $e) {
            dd(''.$e->getMessage());
            return back()->withErrors($e->getMessage());
        }

        return back()->with('success', 'Top Up Success.');
    }

    public function deduct(Member $member, StoreDeductRequest $request, TransactionService $service)
    {
        try {
            $service->deduct($member, $request->validated()['amount'], $request->description);
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }

        return back()->with('success', 'Deduction Success.');
    }

}
