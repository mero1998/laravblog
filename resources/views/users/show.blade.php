@extends('layouts.app')

@section('content')
    <div class='container'>

        <h3>{{$user->name}}'s recent blogs</h3>
        <p>Role: {{$user->role->name}}</p>
        
        @foreach($user->blogs as $blog)
        <hr>
        <h4><a href="route{{'blogs.show' , $blog->id}}">{{$blog->title}}</a></h4>
        @endforeach
</div>
@endsection