{{--
    Butones na mata para sa show/hide ng password. Isama ito sa loob ng isang
    wrapper na `relative`, at siguraduhing may padding sa kanan ang input
    (hal. pr-10) para hindi matakpan ang teksto.

        <div class="relative">
            <input type="password" id="password" ...>
            @include('partials.password-toggle', ['for' => 'password'])
        </div>

    Nakasama na rito ang script, pero minsan lang ito idineklara kahit ilang
    beses i-include ang partial.
--}}
<button type="button" onclick="togglePasswordField('{{ $for }}', this)"
        class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500 hover:text-gray-700"
        aria-label="Show password" title="Show password">
    @include('partials.eye-icon')
</button>

@once
<script>
function togglePasswordField(inputId, btn) {
    const input = document.getElementById(inputId);
    if (!input) return;
    const isHidden = input.type === 'password';
    input.type = isHidden ? 'text' : 'password';
    btn.querySelector('.eye-open')?.classList.toggle('hidden', isHidden);
    btn.querySelector('.eye-closed')?.classList.toggle('hidden', !isHidden);
    btn.setAttribute('aria-label', isHidden ? 'Hide password' : 'Show password');
    btn.setAttribute('title', isHidden ? 'Hide password' : 'Show password');
}
</script>
<style>
    /* Itinatago ang sariling mata ng Edge/IE — doble kasi ang lalabas. */
    input[type="password"]::-ms-reveal,
    input[type="password"]::-ms-clear { display: none; }
</style>
@endonce
