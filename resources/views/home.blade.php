@extends('layouts.app')

@section('content')

<div class="container">
    <h1>LSi at {{ env('APP_NAME') }}</h1>
    
    <hr>
    
    @if(session('accesscode') !== env('ACCESS_CODE'))
    <div class="row">
        <div class="col-sm-6 col-md-4 col-lg-3">
            {!! Form::open(['action' => 'PageController@postAccessCode']) !!}
                <div class="form-group">
                    {!! Form::label('accesscode', 'Please enter your access code') !!}
                    {!! Form::password('accesscode', ['class' => 'form-control']) !!}
                </div>
                {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
            {!! Form::close() !!}
        </div>
    </div>
    @else
    <h3>You are logged in</h3>
    <p><a href="{{ action('ProductController@index') }}" class="btn btn-md btn-primary">Click to view the product list</a></p>
    @endif
    
    
</div>

@endsection
