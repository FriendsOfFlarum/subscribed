Hey {{ $user->display_name }}!

{{ $blueprint->user->display_name }} just joined {{ $url->to('forum') }}.

To view this new user's profile, please click on following link:
{{ $this->url->to('forum')->route('user', ['username' => $user->username]) }}
