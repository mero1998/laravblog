@include('layouts.app')

@section('content')
<main>
<div class='container-fulid'>

    <div class='jumbotron'>
        <h1>Contact Page</h1>
    </div>
        <div class='col-sm-8 offset-d-2 container'>
            <form method="post" action="{{route('mail.send')}}">
                @include('partials.error-messages')
                <div class='form-group'>
                    <label for='name'>Title</label>
                    <input type ='text' name="title" class='form-control' value="{{old('name')}}">
                </div>
                
                <div class='form-group'>
                    <label for='name'>Email</label>
                    <input type ='text' name="email" class='form-control' value="{{old('email')}}">
                </div>
                
                <div class='form-group'>
                    <label for='name'>subject</label>
                    <input type ='text' name="subject" class='form-control' value="{{old('subject')}}">
                </div>
                
                <div class='form-group'>
                    <label for='name'>Meassge</label>
                    <textarea name="mail_message" class='form-control my-editor' value="{{old('name')}}">{{old('mail_message')}}</textarea>
                </div>
                
                <div>
                    <button class='btn btn-primary' type="submit">Say Hi</button>
                </div>
                {{csrf_field()}}
            </form>
    
    </div>
</div>
</main>