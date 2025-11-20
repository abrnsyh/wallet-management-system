<?php

namespace App\Http\Services;

use App\Models\Member;
use App\Models\Transaction;
use Exception;
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

            $member->increment('balance', $amount);

            $transaction = Transaction::create([
                'member_id' => $member->id,
                'type' => 'topup',
                'amount' => $amount,
                'description' => $description,
            ]);

            Redis::lpush("member:{$member->id}:logs", json_encode([
                'action' => 'topup',
                'amount' => $amount,
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

            if ($member->balance < $amount) {
                throw new Exception("Balance is not sufficient.");
            }

            $member->decrement('balance', $amount);

            $transaction = Transaction::create([
                'member_id' => $member->id,
                'type' => 'deduction',
                'amount' => $amount,
                'description' => $description,
            ]);

            Redis::lpush("member:{$member->id}:logs", json_encode([
                'action' => 'deduct',
                'amount' => $amount,
                'time' => now()->toDateTimeString(),
            ]));

            return $transaction;
        });
    }
}
