<dialog id="topupModal" x-data="{ open: false }" class="dialog w-full sm:max-w-[425px] max-h-[612px]"
    aria-labelledby="topupModal" aria-describedby="topupModal" onclick="if (event.target === this) this.close()">
    <div>
        <header>
            <h2 id="demo-dialog-edit-profile-title">Top Up Balance</h2>
        </header>

        <section>
            <form id="topupForm" class="form grid gap-4" method="POST" action="{{ route('members.topup', $member->id) }}">
                @csrf
                <div class="grid gap-3">
                    <x-currency-input name="amount" label="Amount" />
                </div>
                <div class="grid gap-3">
                    <label for="demo-dialog-edit-profile-email">Desc</label>
                    <input type="text" placeholder="" name="description" value="{{ old('description') }}"
                        id="demo-dialog-edit-profile-email" required />
                </div>
                @if ($errors->any())
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li class="text-red-500">{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
            </form>
        </section>

        <footer>
            <button form="topupForm" type="reset" class="btn-outline"
                onclick="this.closest('dialog').close()">Cancel</button>
            <button form="topupForm" type="submit" class="btn"
                @click="document.querySelector('#topupModal form').submit()">Save
            </button>
        </footer>

        <button type="button" aria-label="Close dialog" onclick="this.closest('dialog').close()">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-x-icon lucide-x">
                <path d="M18 6 6 18" />
                <path d="m6 6 12 12" />
            </svg>
        </button>
    </div>
</dialog>
