@extends('layout.app')

@section('title', 'Dashboard')

@section('content')
    <div class="p-6 space-y-6">

        {{-- STAT CARDS --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">

            {{-- Total Members --}}
            <div class="card">
                <header>
                    <h2>Total Members</h2>
                    <p>Total registered users</p>
                </header>
                <section class="text-3xl font-bold">
                    {{ $memberCount }}
                </section>
            </div>

            {{-- Total Balance --}}
            <div class="card">
                <header>
                    <h2>Total Balance</h2>
                    <p>Total balance in all users (Rp)</p>
                </header>
                <section class="text-3xl font-bold">
                    {{ Number::abbreviate($totalBalance, 1) }}
                </section>
            </div>

            {{-- Topup Today --}}
            <div class="card">
                <header>
                    <h2>Topup Today</h2>
                    <p>Total today topup (Rp)</p>
                </header>
                <section class="text-3xl font-bold text-green-500">
                    {{ Number::abbreviate($todayTopup, 1) }}
                </section>
            </div>

            {{-- Deduct Today --}}
            <div class="card">
                <header>
                    <h2>Deduct Today</h2>
                    <p>Total today deduct (Rp)</p>
                </header>
                <section class="text-3xl font-bold text-red-500">
                    {{ Number::abbreviate($todayDeduct, 1) }}
                </section>
            </div>

        </div>

        {{-- RECENT TRANSACTIONS --}}
        <div class="card w-full">
            <header>
                <h2>Recent Transactions</h2>
                <p>Latest 5 transaction logs</p>
            </header>

            <section class="grid gap-6">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Member</th>
                            <th>Type</th>
                            <th>Amount</th>
                            <th>Date</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($recentTransactions as $tx)
                            <tr>
                                <td class="font-medium">{{ $tx->member->name }}</td>

                                <td class="{{ $tx->type === 'topup' ? 'text-green-500' : 'text-red-500' }}">
                                    {{ ucfirst($tx->type) }}
                                </td>

                                <td class="{{ $tx->type === 'topup' ? 'text-green-500' : 'text-red-500' }}">
                                    {{ Number::currency($tx->amount, 'IDR', 'id') }}
                                </td>

                                <td>{{ $tx->created_at->format('Y-m-d H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-sm text-gray-500">
                                    No transactions found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </section>

            <footer class="flex justify-end">
                <a href="{{ route('members.index') }}" class="btn">View All Members</a>
            </footer>
        </div>
    </div>
@endsection
