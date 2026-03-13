<x-mail::html.notification>
    <x-slot:body>
        {!! $translator->trans('fof-subscribed.email.body.postFlagged', [
    '{recipient_display_name}' => $user->display_name,
    '{actor_display_name}' => $blueprint->flag->user->display_name,
    '{discussion_title}' => $blueprint->post->discussion->title,
    '{post_url}' => $url->to('forum')->route('discussion', ['id' => $blueprint->post->discussion_id, 'near' => $blueprint->post->number]),
    '{post_content}' => $blueprint->post->content,
]) !!}
    </x-slot:body>

    <x-slot:preview>{{ $blueprint->post->discussion->title }}</x-slot:preview>
</x-mail::html.notification>
