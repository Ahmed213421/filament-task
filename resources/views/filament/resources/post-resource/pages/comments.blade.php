<x-filament-panels::page>
    {{$post->title}}
    <h1>add comment</h1>
    <form action="{{route('comment.store')}}" method="get">
        @csrf
        @method('get')
        <input type="hidden" name="post_id" value="{{$post->id}}">
        <label for="">add comment</label><br>
        <input type="text" name="comment"><br>
        <input type="submit" value="submit">
    </form>

    <h1>comments</h1>
    @foreach ($post->comments as $comment)
        {{$comment->comment}}<br>
    @endforeach
</x-filament-panels::page>
