<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form action="{{route('posts.store')}}" method="post">
        @csrf
        @method('post')
        <label for="name">name</label>
        <input type="text" id="name" name="name">
        <label for="description">description</label>
        <input type="text" id="description" name="description">
        <label for="tag"> select tags</label>
        <select name="tags[]" id="" multiple>
            @foreach ($tags as $tag)
                <option value="{{$tag->id}}">{{$tag->tag}}</option>
            @endforeach
        </select>
        <button type="submit">add post</button>
    </form>
</body>
</html>
