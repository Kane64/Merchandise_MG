@extends('adminlte::page')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

@section('title', 'Bookmark 一覧')

@section('content_header')
    <div class="top_item">
        <h1>Bookmark&nbsp;一覧</h1>
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
            </div>
        @else
            @foreach ($items as $item)
                <div class="col-lg-3 col-md-3">
                        <div class="card">
                            <div class="card-header">
                                <div class="btn-groop">
                                    <!--ブックマーク-->
                                    @if (!Auth::user()->is_nice($item->id))
                                    <form action="{{ route('nice.store', $item) }}" method="post">
                                        @csrf
                                        <button type="submit" class="btn-b">
                                            <i class="bi bi-bookmark-check"></i>
                                        </button>
                                    </form>
                                        <!--ブックマーク解除-->
                                    @else
                                    <form action="{{ route('nice.destroy', $item) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button class="btn-b">
                                            <i class="bi bi-bookmark-check-fill"></i>
                                        </button>
                                    </form>
                                    @endif
                                    <div>
                                        品番：{{ $item->model_number }}
                                    </div>
                                </div>
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
        .input-group{
            margin-top: 16px;
            margin-bottom: 10px;
        }

        .fa-pepper-hot{
            color:red;
        }

        .btn-b{
            background-color: transparent;
            border: none;
            cursor: pointer;
            outline: none;
            padding: 0;
            appearance: none;
        }

        .bi-bookmark-check-fill{
            color:rgb(0, 195, 255);
            font-size: 30px;
            margin-right: 10px;
        }

        .bi-bookmark-check{
            color:rgb(0, 195, 255);
            font-size: 30px;
            margin-right: 10px;
        }

        .btn-groop{
            display: flex;
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

