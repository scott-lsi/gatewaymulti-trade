@extends('layouts.app')

@section('content')

<div class="container">
    <h1>LSi at {{ env('APP_NAME') }}</h1>
    
    <hr>
    
    <h2>Other Products</h2>
    
    <div class="row">
        @foreach($otherProducts as $product)
        <div class="col-sm-3 text-center">
            {{--<a href="{{ action('ProductController@show', $product->id)}}">--}}
            @if($product->gatewaymulti)
            <a href="{{ action('ProductController@personaliser', [json_decode($product->gatewaymulti, true)[1], $product->id]) }}">
            @else($product->gateway)
            <a href="{{ action('ProductController@personaliser', $product->id) }}">
            @endif
                <?php
                    if(strncmp($product->image, 'http', 4) === 0){
                        $imageurl = $product->image;
                    } else {
                        $imageurl = asset('products/' . $product->image);
                    }
                ?>
                <img src="{{ $imageurl }}" alt="{{ $product->name }}" class="img-responsive thumbnail">
                <div class="h3" style="margin-bottom: 20px;">{{ $product->name }}</div>
            </a>
        </div>
        @endforeach
    </div>
</div>

@endsection
