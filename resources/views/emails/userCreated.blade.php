Hey {{ $user->username }}!

{{ $blueprint->user->username }} just joined {{ app()->url() }}.

To view the new user, check out the following link:
{{ app()->url() }}/u/{{ $blueprint->user->username }}


