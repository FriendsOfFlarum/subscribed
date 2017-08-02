Hey {{ $user->username }}!

{{ $blueprint->user->username }} joined {{ app()->url() }}.

To view the new user, check out the following link:
{{ app()->url() }}/u/{{ $blueprint->user->id }}


