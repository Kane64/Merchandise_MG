@extends('adminlte::page')

@section('title', '商品編集')

@section('content_header')
    <h1>商品編集</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-10">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                       @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                       @endforeach
                    </ul>
                </div>
            @endif

            <div class="card card-primary">
                <form method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">名前</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="名前" value="{{$item->name}}">
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="detail">産地</label>
                                <select id="type" class="form-control" name="type">
                                    <option value="disabled selected">選択してください</option>
                                    @foreach($itemTypes as $itemType)
                                    <option value="{{ $itemType->id }}"
                                    {{-- itemテーブルのtypeカラムとitemTypeテーブルのidカラムが一致した場合、初期値として選択していたitemTypeテーブルのtype_nameカラムの値が入る --}}
                                    @if ($item->type == $itemType->id) selected @endif>{{ $itemType->type_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="spicy">辛さ</label>
                                <select id="spicy" class="form-control" name="spicy">
                                    <option value="disabled selected">選択してください</option>                                    
                                    <option value="0" @if ( $item->spicy == 0) selected="selected" @endif>甘口</option>
                                    <option value="1" @if ( $item->spicy == 1) selected="selected" @endif>辛さ１</option>
                                    <option value="2" @if ( $item->spicy == 2) selected="selected" @endif>辛さ２</option>
                                    <option value="3" @if ( $item->spicy == 3) selected="selected" @endif>辛さ３</option>
                                    <option value="4" @if ( $item->spicy == 4) selected="selected" @endif>辛さ４</option>
                                    <option value="5" @if ( $item->spicy == 5) selected="selected" @endif>辛さ５（激辛）</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="detail">詳細</label>
                            <textarea class="form-control" id="detai" name="detail" rows="3">{{$item->detail}}</textarea>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-8">
                                <label for="model_number">品番</label>
                                <input type="text" class="form-control" id="model_number" name="model_number" placeholder="品番" value="{{$item->model_number}}">
                            </div>
                        

                            <div class="form-group col-md-4">
                                    <label for="stock">在庫数</label>
                                    <input type="number" class="form-control" id="stock" name="stock" min="0" placeholder="個数" value="{{$item->stock}}">
                            </div>
                        </div>

                        <div class="form-group">
                                <label for="img_path">画像</label>
                                @if ($item->img_path == null)
                                    <img class="img-responsive w-25" src="{{ asset('img/no_image_yoko.jpg') }}" alt="イメージ画像">
                                @else
                                    <img class="img-responsive w-25" src="{{ Storage::url($item->img_path) }}" alt="商品画像">
                                @endif
                                <div>
                                    <input type="file" class="img_path" id="img_path" name="img_path" placeholder="画像">
                                    <input type="hidden" name="existing_img" value="{{$item->img_path}}">
                                </div>
                        </div>

                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">登録</button>
                        <a href="{{ route('index') }}" class="btn btn-secondary">キャンセル</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('css')
@stop

@section('js')

@stop
