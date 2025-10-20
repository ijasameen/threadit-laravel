<x-layout.auth>
    <x-shell.auth title="Sign up">
        <div class="space-y-4">
            <form method="POST" action="/signup" class="mb-4 space-y-4"">
                @csrf

                <div>
                    <x-form.label for="name">Full Name</x-form.label>
                    <x-form.text-input name="name" id="name" autocomplete='name' placeholder="Jon Doe"
                        :value="old('name')" />
                    <x-form.error :messages="$errors->get('name')" />
                </div>
                <div>
                    <x-form.label for="username">User Name</x-form.label>
                    <x-form.text-input name="username" id="username" autocomplete='username' placeholder="jondoe"
                        :value="old('username')" />
                    <x-form.error :messages="$errors->get('username')" />
                </div>
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
                <div>
                    <x-form.label for="password_confirmation">Confirm Password</x-form.label>
                    <x-form.password-input name="password_confirmation" id="password_confirmation"
                        placeholder="············" />
                    <x-form.error :messages="$errors->get('password_confirmation')" />
                </div>
                <button class="btn btn-lg btn-primary btn-gradient btn-block">Sign Up</button>
            </form>
            <p class="text-base-content/80 mb-4 text-center">
                Already have an account?
                <a href="{{ route('login') }}" class="link link-animated link-primary font-normal">Sign in
                    instead</a>
            </p>
        </div>
    </x-shell.auth>
</x-layout.auth>
