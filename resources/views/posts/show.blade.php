@extends('layout')

@section('content')
    <h3>{{$post->title}}</h3>
<p>{{$post->content}}</p>
    <p>Added since: {{$post->created_at->diffForHumans()}}</p>

    @if((new Carbon\Carbon())->diffInMinutes($post->created_at) < 5)
    <strong>New!</strong>
    @endif
    <h4>Comments</h4>
    @forelse($post->comments as $comment)
    <p >{{$comment->content}}</p>
        <p class="text-muted">Added {{$comment->created_at->diffForHumans()}}</p>
    @empty
    <p>No Comments Yet</p>
    @endforelse
@endsection
