Hey {{ $user->display_name }}!

{{ $blueprint->post->user->display_name }} made a post that wasn't automatically approved: {{ $blueprint->post->discussion->title }}

To view this new activity, please click the following link:
{{ app()->url() }}/d/{{ $blueprint->post->discussion->id }}/{{ $blueprint->post->id }}

Additionally, you can find the contents of the post in this new discussion below

---

{{ $blueprint->post->content }}
