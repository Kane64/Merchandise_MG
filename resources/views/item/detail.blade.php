@extends('adminlte::page')

@section('title', '商品詳細')

@section('content_header')
    <h1>商品詳細</h1>
@stop

@section('content')
                    <div class="card mx-auto"  style="width: 25rem;">
                        @if ($item->img_path == null)
                            <img class="card-img-top" src="{{ asset('img/no_image_yoko.jpg') }}" alt="イメージ画像">
                        @else
                            <img class="card-img-top" src="{{ Storage::url($item->img_path) }}" alt="商品画像">
                        @endif
                            
                        <div class="card-body">
                            <h5 class="card-title">商品名：{{ $item->name }}</h5>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">品番：{{ $item->model_number }}</li>
                            <li class="list-group-item">産地：{{ $item->itemtype->type_name }}</li>
                            <li class="list-group-item">
                                <h6>辛さ（MAX5）: 

                                @if ($item->spicy === null)
                                    登録なし
                                @elseif ($item->spicy === 0)
                                    甘口                                
                                @else
                                    @for ($i = 0; $i < $item->spicy; $i++)
                                    <i class="fas fa-pepper-hot"></i>
                                    @endfor
                                @endif    
                                </h6>
                            </li>
                            <li class="list-group-item">詳細：{{ $item->detail }}</li>
                            <li class="list-group-item">在庫数：{{ $item->stock }}</li>
                        </ul>
                            
                        <div class="card-footer text-right">
                            <div class="footer-button d-grid gap-2 d-md-flex justify-content-md-end">
                                <form action="/items/edit/{{$item->id}}" method="get">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-dell me-md-2 mr-3">編集</button>
                                </form>
                                <button class="btn btn-secondary" onclick="location.href='{{ route('index') }}'">戻る</button>
                            </div>
                        </div>

@stop

@section('css')
<style>
        .fa-pepper-hot{
            color:red;
        }

        .footer-button{
            display:flex;
        }
</style>
@stop

@section('js')
@stop
