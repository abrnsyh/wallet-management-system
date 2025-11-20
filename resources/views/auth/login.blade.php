<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])


</head>

<body>
    <div class="conatiner w-full flex justify-center items-center h-screen">
        <div class="card w-md">
            <header>
                <h2>Login to your account</h2>
                <p>Enter your details below to login to your account</p>
            </header>
            <section>
                <form id="loginForm" method="POST" action="{{ route('login') }}" class="form grid gap-6">
                    @csrf
                    <div class="grid gap-2">
                        <label for="demo-card-form-email">Email</label>
                        <input type="email" name="email" id="demo-card-form-email"
                            aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}">
                        @error('email')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="grid gap-2">
                        <div class="flex items-center gap-2">
                            <label for="demo-card-form-password">Password</label>
                        </div>
                        <input name="password" type="password" id="demo-card-form-password">
                    </div>
                </form>
            </section>
            <footer x-data="{ isLoading: false }" class="flex flex-col items-center gap-2">
                <button x-on:click="isLoading=true; document.getElementById('loginForm').submit();"
                    x-bind:disabled="isLoading" form="loginForm" type="submit" class="btn w-full">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" role="status" aria-label="Loading" x-show="isLoading"
                        class="size-3 animate-spin">
                        <path d="M21 12a9 9 0 1 1-6.219-8.56" />
                    </svg>
                    Login</button>
            </footer>
        </div>
    </div>
</body>

<script>
    (() => {
        try {
            const stored = localStorage.getItem('themeMode');
            if (stored ? stored === 'dark' :
                matchMedia('(prefers-color-scheme: dark)').matches) {
                document.documentElement.classList.add('dark');
            }
        } catch (_) {}

        const apply = dark => {
            document.documentElement.classList.toggle('dark', dark);
            try {
                localStorage.setItem('themeMode', dark ? 'dark' : 'light');
            } catch (_) {}
        };

        document.addEventListener('basecoat:theme', (event) => {
            const mode = event.detail?.mode;
            apply(mode === 'dark' ? true :
                mode === 'light' ? false :
                !document.documentElement.classList.contains('dark'));
        });
    })();
</script>

</html>
