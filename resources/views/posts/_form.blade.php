<p><label><input type="text" name="title" value="{{old('title',$post->title ?? null)}}" /></label></p>
<p><label><input type="text" name="content" value="{{old('content', $post->content ?? null)}}" /></label></p>
@if($errors->any())
    <div>
        <ul>
            @foreach($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    </div>
@endif
