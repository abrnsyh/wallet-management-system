@extends('layout.app')

@section('title', $member->name . ' Logs')

@section('content')
    <div class="p-4 space-y-4">

        <div class="card w-full">
            <header>
                <h2>Activity Logs for {{ $member->name }}</h2>
                <p>All actions related to this member stored in Redis.</p>
            </header>

            <section class="grid gap-6">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Action</th>
                            <th>Amount</th>
                            <th>Old → New</th>
                            <th>Description</th>
                            <th>By</th>
                            <th>Time</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($logs as $log)
                            <tr>
                                <td class="font-medium">
                                    {{ ucfirst($log['action']) }}
                                </td>

                                <td>
                                    {{ isset($log['amount']) ? Number::currency($log['amount'], 'IDR', 'id') : '-' }}
                                </td>

                                <td>
                                    @if (isset($log['old_balance']))
                                        {{ Number::currency($log['old_balance'], 'IDR', 'id') }}
                                        →
                                        {{ Number::currency($log['new_balance'], 'IDR', 'id') }}
                                    @else
                                        -
                                    @endif
                                </td>

                                <td>{{ $log['description'] ?? '-' }}</td>

                                <td>{{ $log['by'] ?? 'system' }}</td>

                                <td>{{ $log['time'] }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No logs available for this member.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </section>
        </div>
    </div>
@endsection
