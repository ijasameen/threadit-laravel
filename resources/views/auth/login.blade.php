<x-layout.auth>
    <x-shell.auth title="Sign in">
        <div class="space-y-4">
            <form method="POST" action="/login" class="mb-4 space-y-4"">
                @csrf

                <div>
                    <x-form.label for="email">Email</x-form.label>
                    <x-form.text-input type="email" name="email" id="email" autocomplete='email'
                        placeholder="jondoe@example.com" :value="old('email')" />
                    <x-form.error :messages="$errors->get('email')" />
                </div>
                <div>
                    <x-form.label for="password">Password</x-form.label>
                    <x-form.password-input name="password" id="password" placeholder="············" />
                    <x-form.error :messages="$errors->get('password')" />
                </div>
                <x-form.error :messages="$errors->get('invalid_credentials')" />
                <div class="flex items-center justify-between gap-y-2">
                    <div class="flex items-center gap-2">
                        <input type="checkbox" name="remember" id="rememberMe" class="checkbox checkbox-primary" />
                        <label class="label-text text-base-content/80 p-0 text-base" for="rememberMe">Remember
                            Me</label>
                    </div>
                    <a href="#" class="link link-animated link-primary font-normal">Forgot
                        Password?</a>
                </div>
                <button type="submit" class="btn btn-lg btn-primary btn-gradient btn-block">
                    Sign in</button>
            </form>
            <p class="text-base-content/80 mb-4 text-center">
                New on our platform?
                <a href="{{ route('signup') }}" class="link link-animated link-primary font-normal">Create
                    an account</a>
            </p>
        </div>
    </x-shell.auth>
</x-layout.auth>
