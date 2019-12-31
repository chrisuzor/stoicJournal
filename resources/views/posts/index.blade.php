@extends('layout')
@section('content')
    <a href="{{route('posts.create')}}"><p>Add BlogPost</p></a>
    @forelse($posts as $post)
       <a href="{{route('posts.show',['post' => $post->id])}}"><h5>{{$post->title}}</h5></a>
       <a class="btn btn-info" href="{{route('posts.edit',['post' => $post->id])}}">Edit</a>
       <form method="POST" class="fm-inline" action="{{route('posts.destroy',['post' => $post->id])}}">
           @csrf
           @method('DELETE')

           <button class="btn btn-danger" type="submit"> Delete!</button>
       </form>
        @empty
        <h3>No Blog Posts Yet</h3>
    @endforelse
@endsection
