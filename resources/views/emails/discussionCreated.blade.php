Hey {{ $user->username }}!

{{ $blueprint->post->user->username }} created a discussion: {{ $blueprint->post->discussion->title }}

To view the new activity, check out the following link:
{{ app()->url() }}/d/{{ $blueprint->post->discussion_id }}

---

{{ strip_tags($blueprint->post->contentHtml) }}

---

You won't receive any more notifications about this discussion until you're up-to-date.
