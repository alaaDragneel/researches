@component('mail::message')
# New Post Was Created

New Post Was Created Come And See It Fucker.

@component('mail::button', ['url' => route('posts.show', $post), 'color' => 'green'])
Visit Our New Post
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
