<x-mail::html.notification>
    <x-slot:body>
        {!! $formatter->convert($translator->trans('fof-subscribed.email.html.newDiscussion', [
            '{actor_display_name}' => $blueprint->discussion->user->display_name,
            '{discussion_title}' => $blueprint->discussion->title,
            '{discussion_url}' => $url->to('forum')->route('discussion', ['id' => $blueprint->discussion->id]),
        ])) !!}
    </x-slot:body>

    @if ($blueprint->post)
        <x-slot:preview>
            {!! $blueprint->post->formatContent() !!}
        </x-slot:preview>
    @endif
</x-mail::html.notification>
