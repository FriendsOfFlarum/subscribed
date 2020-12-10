{!! $translator->trans('fof-subscribed.email.body.postUnapproved', [
    '{recipient_display_name}' => $user->display_name,
    '{actor_display_name}' => $blueprint->post->user->display_name,
    '{discussion_title}' => $blueprint->post->discussion->title,
    '{post_url}' => $url->to('forum')->route('discussion', ['id' => $blueprint->post->discussion_id, 'near' => $blueprint->post->number]),
    '{post_content}' => $blueprint->post->content,
]) !!}
