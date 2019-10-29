Hey {{ $user->display_name }}!

{{ $blueprint->user->display_name }} just joined {{ app()->url() }}.

To view this new user's profile, please click on following link:
{{ app()->url() }}/u/{{ $blueprint->user->id }}
