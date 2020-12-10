{!! $translator->trans('fof-subscribed.email.body.newUser', [
    '{recipient_display_name}' => $user->display_name,
    '{actor_display_name}' => $blueprint->user->display_name,
    '{forum_url}' => $url->to('forum')->base(),
    '{user_url}' => $url->to('forum')->route('user', ['username' => $blueprint->user->username]),
]) !!}
