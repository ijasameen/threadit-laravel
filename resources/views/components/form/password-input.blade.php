<div class="input">
    <input {{ $attributes->merge(['type' => 'password']) }}) />
    <button type="button" data-toggle-password='{ "target": "#{{ $attributes['id'] }}" }' class="block cursor-pointer"
        aria-label="{{ $attributes['id'] }}">
        <span class="icon-[tabler--eye] password-active:block hidden size-5 shrink-0"></span>
        <span class="icon-[tabler--eye-off] password-active:hidden block size-5 shrink-0"></span>
    </button>
</div>
