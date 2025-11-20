<dialog id="createModal" x-data="{ open: false }" class="dialog w-full sm:max-w-[425px] max-h-[612px]"
    aria-labelledby="createModal" aria-describedby="createModal" onclick="if (event.target === this) this.close()">
    <div>
        <header>
            <h2 id="demo-dialog-edit-profile-title">Add Member</h2>
        </header>

        <section>
            <form class="form grid gap-4" method="POST" action="{{ route('members.store') }}">
                @csrf
                <div class="grid gap-3">
                    <label for="demo-dialog-edit-profile-name">Name</label>
                    <input type="text" placeholder="Jane Doe" value="{{ old('name') }}" name="name"
                        id="demo-dialog-edit-profile-name" autofocus required />
                </div>
                <div class="grid gap-3">
                    <label for="demo-dialog-edit-profile-email">Email</label>
                    <input type="email" placeholder="doe@mail.com" name="email" value="{{ old('email') }}"
                        id="demo-dialog-edit-profile-email" required />
                </div>
                <div class="grid gap-3">
                    <label for="demo-dialog-edit-profile-username">Phone</label>
                    <input type="text" x-mask="(999)999-999-999" placeholder="(081)234-567-890"
                        value="{{ old('phone') }}" name="phone" id="demo-dialog-edit-profile-username" required />
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
            <button class="btn-outline" onclick="this.closest('dialog').close()">Cancel</button>
            <button type="button" class="btn" @click="document.querySelector('#createModal form').submit()">Save
                changes</button>
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
