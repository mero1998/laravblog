@extends('layouts.app');

@section('content')

<div class='container-fluid'>
    <div class='jumbotron'>
        <h1>Trashed Blogs</h1>
    </div>
</div>
<div class='col-md-12'>
    @foreach($trashedBlogs as $blog)
     <h2>{{$blog->title}}</h2>
     <p>{{$blog->body}}</p>
    <div class='btn-group'>
    {{-- Restore --}}
        <form method = 'get' action="{{route('blogs.restore' , $blog->id)}}">
            <button class='btn btn-success btn-xs pull-left margin-right' type="submit">Restore</button>
        {{csrf_field()}}
    </form>
     {{-- Permanent delete --}}
        <form method = 'post' action="{{route('blogs.permanent-delete' , $blog->id)}}">
            {{method_field('delete')}}
            <button class='btn btn-danger btn-xs pull-left margin-right' type="submit">Delete</button>
        {{csrf_field()}}
    </form>
    </div>
    @endforeach

</div>

@endsection