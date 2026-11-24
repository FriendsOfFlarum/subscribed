<x-mail::html.notification>
    <x-slot:body>
        {!! $formatter->convert($translator->trans('fof-subscribed.email.html.newUser', [
            '{actor_display_name}' => $blueprint->user->display_name,
            '{forum_url}' => $url->to('forum')->base(),
            '{user_url}' => $url->to('forum')->route('user', ['username' => $slugManager->forResource(get_class($blueprint->user))->toSlug($blueprint->user)]),
        ])) !!}
    </x-slot:body>
</x-mail::html.notification>
