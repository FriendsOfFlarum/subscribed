Hey {{ $user->username }}!

{{ $blueprint->discussion->startUser->username }} created a discussion: {{ $blueprint->discussion->title }}

To view the new activity, check out the following link:
{{ app()->url() }}/d/{{ $blueprint->discussion->id }}

---

{{ strip_tags($blueprint->discussion->startPost->contentHtml) }}

