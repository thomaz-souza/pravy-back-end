@isset($user->two_factor_secret)
    <p>Two-factor authentication is enabled.</p>
    <form method="POST" action="{{ url('user/two-factor-authentication') }}">
        @csrf
        @method('DELETE')
        <button type="submit">Disable</button>
    </form>
@else
    <p>Two-factor authentication is not enabled.</p>
    <form method="POST" action="{{ url('user/two-factor-authentication') }}">
        @csrf
        <button type="submit">Enable</button>
    </form>
@endisset
