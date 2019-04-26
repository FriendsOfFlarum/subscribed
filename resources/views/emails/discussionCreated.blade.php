Hey {{ $user->username }}!

{{ $blueprint->discussion->user->username }} created a new discussion: {{ $blueprint->discussion->title }}

To view this new activity, please click the following link:
{{ app()->url() }}/d/{{ $blueprint->discussion->id }}

Additionally, you can find the contents of the first post in this new discussion below
---

{{ strip_tags($blueprint->discussion->firstPost->contentHtml) }}
