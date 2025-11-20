@extends('layout.app')

@section('title', 'Member')

@section('content')
    <div class="p-4">

        <div class="card w-full">
            <header>
                <h2>Members</h2>
                <p>List of Members</p>
            </header>
            <section>
                <div class="flex flex-col gap-2 sm:flex-row sm:justify-between sm:items-center">
                    <form method="GET" action="{{ route('members.index') }}">
                        <div class="flex items-center space-x-2">
                            <input class="input" name="search" value="{{ old('search') }}" type="text"
                                placeholder="search...">
                            <button type="submit" class="btn-icon-outline">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-search-icon lucide-search">
                                    <path d="m21 21-4.34-4.34" />
                                    <circle cx="11" cy="11" r="8" />
                                </svg>
                            </button>
                        </div>
                    </form>
                    <button class="btn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-plus-icon lucide-plus">
                            <path d="M5 12h14" />
                            <path d="M12 5v14" />
                        </svg>
                        Add Member
                    </button>
                </div>
                <div class="overflow-x-auto mt-4">
                    <table class="table">
                        <caption>A list of our members.</caption>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Balance</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($members as $member)
                                <tr>
                                    <td class="font-medium">{{ $member->name }}</td>
                                    <td>{{ $member->email }}</td>
                                    <td>{{ Number::currency($member->balance, 'IDR', 'id') }}</td>
                                    <td class="text-right"></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">No data available to display.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </section>
        </div>
    </div>

@endsection
