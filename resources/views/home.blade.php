@extends('adminlte::page')

@section('title', '商品管理')

@section('content_header')
<div></div>
@stop

@section('content')
<div class="items">
    <img src="{{ asset('img/curry_shop_building.png') }}" class="t-img rounded mx-auto d-block img-fluid mt-2 item" alt="カレー店イメージ">
    <h2 class="title text-center mt-2 item">
        <span class="text">ようこそ！&nbsp;</span>
        <span class="text">レトルトカレー専門店へ</span>
    </h2>
    <img src="{{ asset('img/curry_tenin_woman.png') }}" class="t-img2 rounded mx-auto d-block img-fluid mt-3 item" alt="店員イメージ">
</div>
    @stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
    <style>
        .t-img {
            width: 220px;
            height: auto;
            }

        .t-img2 {
            width: 150px;
            height: auto;
            }
        
        .text { 
            display: inline-block; 
            }

        .item {
            opacity: 0;
        }

    </style>
@stop

@section('js')
    <script>
        console.log('Hi!');
        
        const items = document.querySelectorAll('.item');

        for (let i = 0; i < items.length; i++){

            const keyframes = {
                opacity: [0, 1],
                translate: ['0 50px', 0],
            };

            const options = {
                duration: 800,
                delay: i * 400,
                fill: 'forwards',
            };

            items[i].animate(keyframes,options);
        }
    </script>
@stop
