@extends('adminlte::page')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

@section('title', '商品一覧')

@section('content_header')
    <div class="top_item">
        <h1>商品一覧</h1>
        <div>
            <a href="{{ url('items/add') }}" class=" btn btn-secondary text-nowrap m-2">商品登録</a>
        </div>
    </div>
@stop

@section('content')
    <div class="container">
        <div class="row">
            <!-- 検索 -->
            <div class="col-sm-10">
                <div class="input-group input-group-sm" >
                    <form action="{{ route('search') }}" method="get">
                            @csrf
                        <input type="text" name="keyword" value="{{ request()->keyword }}" >
                        <input type="submit" value="検索">
                    </form>
                </div>
            </div>
            <!-- 並び替え -->
            <div class="col-sm-2">
                <form id="select_form" action="{{ route('select') }}" method="get">
                        @csrf
                    <select id="price" class="form-control" name="price">                                
                        <option value="1" @selected(request()->price == 1) >新しい順</option>
                        <option value="2" @selected(request()->price == 2)>古い順</option>
                        <option value="3" @selected(request()->price == 3)>在庫多い順</option>
                        <option value="4" @selected(request()->price == 4)>在庫少ない順</option>
                        <option value="5" @selected(request()->price == 5)>辛い順</option>
                        <option value="6" @selected(request()->price == 6)>甘い順</option>
                    </select>
                </form>
            </div>
            <!-- 表示件数 -->
                <div>
                    @if (count($items) >0)
                        <p>全{{ $items->total() }}件中&nbsp;&nbsp;
                            {{  ($items->currentPage() -1) * $items->perPage() + 1}} - 
                            {{ (($items->currentPage() -1) * $items->perPage() + 1) + (count($items) -1)  }}件のデータが表示されています。</p>
                    @endif 
                </div>
        </div>

        <!-- 一覧表示部分 -->
        <div class="row">
        
        <!-- 検索結果がない時 -->        
        @if (count($items) == 0)
            <div calss='col-12'>
                <h3>一致する情報は見つかりませんでした。</h3><br>
                <h5>検索のヒント：</h5>
                <h5>辛さは数字で検索します。０（甘口）、１～５</h5>
            </div>
        @else
            @foreach ($items as $item)
                <div class="col-lg-3 col-md-3">
                        <div class="card">
                            <div class="card-header">
                                <P>品番：{{ $item->model_number }}</p>
                            </div>
                            @if ($item->img_path == null)
                                <img class="card-img-top" src="{{ asset('img/no_image_yoko.jpg') }}" alt="イメージ画像">
                            @else
                                <img class="card-img-top" src="{{ Storage::url($item->img_path) }}" alt="商品画像">
                            @endif
                                
                            <div class="card-body">
                                <h5 class="card-title">商品名：{{ $item->name }}</h5>
                            </div>
                            <ul class="list-group list-group-flush">
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
                                <li class="list-group-item @if($item->stock <= 10) bg-danger @endif">在庫数：{{ $item->stock }}</li>
                            </ul>
                                
                            <div class="card-footer text-right">
                                <div class="footer-button d-grid gap-2 d-sm-flex justify-content-sm-end">
                                <div>
                                <a href="/items/detail/{{$item->id}}" class="btn btn-warning me-sm-2 m-1 text-nowrap">詳細</a>
                                </div>
                                <form action="/items/itemDelete/{{$item->id}}" method="post">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger btn-dell m-1 text-nowrap">削除</button>
                                </form>
                                </div>
                            </div>
                        </div>
                </div>
            @endforeach
        @endif
        </div>
    </div>
    <div class="p-3 mx-auto" style="width: 200px;">{{ $items->links('pagination::bootstrap-4') }}</div>
    
@stop

@section('css')
<style>
        .fa-pepper-hot{
            color:red;
        }
        
        .top_item{
            display: flex;
            justify-content: space-between;
        }

        @media screen and (max-width:500px) {
            .top_item {
                display: block;
            }
        }


</style>
@stop

@section('js')
<script>
    // 削除ボタンでダイアログを表示
    $(function (){
        $(".btn-dell").click(function(){
            if(confirm("本当に削除しますか？")){

            }else{
            //キャンセル
                return false;
            }
        });
    });

// セレクトボタンで並び替え変更
    $(function() {
            $('#price').change(function () {
                $('#select_form').submit();
            });
        });
</script>
@stop

