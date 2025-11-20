@extends('layout.app')

@section('title', $member->name)

@section('content')
    <div class="p-4 space-y-4">
        <div class="card w-full">
            <header>
                <h2>Member Detail</h2>
                <p>Member details and more</p>
            </header>
            <section class="grid gap-6">
                <div class="grid gap-3">
                    <label for="input-with-label" class="label">Name</label>
                    <input class="input" value="{{ $member->name }}" readonly id="input-with-label" type="email"
                        placeholder="Email">
                </div>
                <div class="grid gap-3">
                    <label for="input-with-label" class="label">Email</label>
                    <input class="input" value="{{ $member->email }}" readonly id="input-with-label" type="email"
                        placeholder="Email">
                </div>
                <div class="grid gap-3">
                    <label for="input-with-label" class="label">Phone</label>
                    <input class="input" value="{{ $member->phone }}" readonly id="input-with-label" type="text"
                        placeholder="Email">
                </div>

                <div class="grid gap-3">
                    <label for="input-with-label" class="label">Balance</label>
                    <input class="input" value="{{ Number::currency($member->balance, 'IDR', 'id') }}" readonly
                        id="input-with-label" type="text" placeholder="Email">
                </div>
            </section>
            <footer class="gap-4">
                <button class="btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-banknote-arrow-up-icon lucide-banknote-arrow-up">
                        <path d="M12 18H4a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5" />
                        <path d="M18 12h.01" />
                        <path d="M19 22v-6" />
                        <path d="m22 19-3-3-3 3" />
                        <path d="M6 12h.01" />
                        <circle cx="12" cy="12" r="2" />
                    </svg>
                    Top Up</button>
                <button class="btn-destructive">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-banknote-arrow-down-icon lucide-banknote-arrow-down">
                        <path d="M12 18H4a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5" />
                        <path d="m16 19 3 3 3-3" />
                        <path d="M18 12h.01" />
                        <path d="M19 16v6" />
                        <path d="M6 12h.01" />
                        <circle cx="12" cy="12" r="2" />
                    </svg>
                    Deduction</button>
            </footer>
        </div>

        <div class="card w-full">
            <header>
                <h2>Transactions</h2>
                <p>Transaction list of this member</p>
            </header>
            <section class="grid gap-6">
                <table class="table">
                    <caption>A list of transactions.</caption>
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Amount</th>
                            <th>Desc</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transactions as $transaction)
                            <tr>
                                <td
                                    class="font-medium {{ $transaction->type === 'topup' ? 'text-green-500' : 'text-red-500' }}">
                                    {{ ucfirst($transaction->type) }}</td>
                                <td
                                    class="font-medium {{ $transaction->type === 'topup' ? 'text-green-500' : 'text-red-500' }}">
                                    {{ Number::currency($transaction->amount, 'IDR', 'id') }}</td>
                                <td class="max-w-sm">
                                    <p class="overflow-hidden text-ellipsis">
                                        {{ $transaction->description }}

                                    </p>
                                </td>
                                <td>{{ $transaction->created_at }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No data available to display.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $transactions->links('components.pagination') }}
            </section>
        </div>
    </div>
@endsection
