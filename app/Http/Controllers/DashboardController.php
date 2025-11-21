<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Transaction;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $memberCount = Member::count();

        $totalBalance = Member::sum('balance');

        $todayTopup = Transaction::where('type', 'topup')
            ->whereDate('created_at', today())
            ->sum('amount');

        $todayDeduct = Transaction::where('type', 'deduction')
            ->whereDate('created_at', today())
            ->sum('amount');

        $recentTransactions = Transaction::with('member')
            ->orderBy('id', 'desc')
            ->take(5)
            ->get();

        return view('dashboard.index', compact(
            'memberCount',
            'totalBalance',
            'todayTopup',
            'todayDeduct',
            'recentTransactions'
        ));
    }
}
