<x-mail::html.notification>
    <x-slot:body>
        {!! $translator->trans('fof-subscribed.email.body.newUser', [
    '{recipient_display_name}' => $user->display_name,
    '{actor_display_name}' => $blueprint->user->display_name,
    '{forum_url}' => $url->to('forum')->base(),
    '{user_url}' => $url->to('forum')->route('user', ['username' => $slugManager->forResource(get_class($blueprint->user))->toSlug($blueprint->user)]),
]) !!}
    </x-slot:body>

    <x-slot:preview>{{ $blueprint->user->display_name }}</x-slot:preview>
</x-mail::html.notification>
