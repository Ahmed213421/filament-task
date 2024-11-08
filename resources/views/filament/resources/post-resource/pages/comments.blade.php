<x-filament-panels::page>


    {{$post->title}}

    <h1>comments</h1>
    @foreach ($post->comments as $comment)
        {{$comment->comment}} --- {{$comment->user->name}} <form action="{{route('comment.delete',$comment->id)}}" method="post">
            @csrf
            @method('DELETE')
            <button type="submit">delete</button>
        </form><br>
    @endforeach



    <form class="max-w-sm mr-auto" action="{{route('comment.store')}}" method="get">
        @csrf
        @method('get')
    <div class="mb-5">
      <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">add comment</label>
      <input type="text" id="email" name="comment" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"  />
    <input type="hidden" name="post_id" value="{{$post->id}}">
    </div>
    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
  </form>

</x-filament-panels::page>
