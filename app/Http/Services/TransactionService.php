<?php

namespace App\Http\Services;

use App\Models\Member;
use App\Models\Transaction;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class TransactionService
{
    /**
     * TOPUP saldo.
     */
    public function topup(Member $member, int $amount, ?string $description = null): Transaction
    {
        return DB::transaction(function () use ($member, $amount, $description) {

            $lockedMember = Member::where('id', $member->id)
                ->lockForUpdate()
                ->first();

            $oldBalance = $lockedMember->balance;
            $newBalance = $oldBalance + $amount;

            $lockedMember->increment('balance', $amount);

            $transaction = Transaction::create([
                'member_id' => $member->id,
                'type' => 'topup',
                'amount' => $amount,
                'description' => $description,
            ]);

            Redis::lpush("member:{$member->id}:logs", json_encode([
                'action' => 'topup',
                'amount' => $amount,
                'old_balance' => $oldBalance,
                'new_balance' => $newBalance,
                'description' => $description,
                'transaction_id' => $transaction->id,
                'by' => Auth::user()?->email ?? 'system',
                'time' => now()->toDateTimeString(),
            ]));

            return $transaction;

        });
    }

    /**
     * DEDUCT saldo.
     * Tidak boleh melebihi saldo (tidak boleh negatif).
     */
    public function deduct(Member $member, int $amount, ?string $description = null): Transaction
    {
        return DB::transaction(function () use ($member, $amount, $description) {

            $lockedMember = Member::where('id', $member->id)
                ->lockForUpdate()
                ->first();

            if ($lockedMember->balance < $amount) {
                throw new Exception("Balance is not sufficient.");
            }

            $oldBalance = $lockedMember->balance;
            $newBalance = $oldBalance - $amount;

            $lockedMember->decrement('balance', $amount);

            $transaction = Transaction::create([
                'member_id' => $member->id,
                'type' => 'deduction',
                'amount' => $amount,
                'description' => $description,
            ]);

            Redis::lpush("member:{$member->id}:logs", json_encode([
                'action' => 'deduction',
                'amount' => $amount,
                'old_balance' => $oldBalance,
                'new_balance' => $newBalance,
                'description' => $description,
                'transaction_id' => $transaction->id,
                'by' => Auth::user()?->email ?? 'system',
                'time' => now()->toDateTimeString(),
            ]));

            return $transaction;

        });
    }
}
