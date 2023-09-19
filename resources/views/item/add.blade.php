@extends('adminlte::page')

@section('title', '商品登録')

@section('content_header')
    <h1>商品登録</h1>
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
                            <input type="text" class="form-control" id="name" name="name" placeholder="名前">
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="detail">産地</label>
                                <select id="type" class="form-control" name="type">
                                    <option selected disabled value="">選択してください</option>
                                    @foreach($itemTypes as $itemType)
                                        <option value="{{ $itemType->id }}">{{ $itemType->type_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="spicy">辛さ</label>
                                <select id="spicy" class="form-control" name="spicy">
                                    <option selected disabled value="">選択してください</option>
                                    <option value="0">甘口</option>
                                    <option value="1">辛さ１</option>
                                    <option value="2">辛さ２</option>
                                    <option value="3">辛さ３</option>
                                    <option value="4">辛さ４</option>
                                    <option value="5">辛さ５（激辛）</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="detail">詳細</label>
                            <textarea class="form-control" id="detai" name="detail" rows="3"></textarea>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-8">
                                <label for="model_number">品番</label>
                                <input type="text" class="form-control" id="model_number" name="model_number" placeholder="品番">
                            </div>
                        

                            <div class="form-group col-md-4">
                                    <label for="stock">在庫数</label>
                                    <input type="number" class="form-control" id="stock" name="stock" min="0" placeholder="個数">
                            </div>
                        </div>

                        <div class="form-group">
                                <label for="img_path">画像</label>
                                <div>
                                <input type="file" class="img_path" id="img_path" name="img_path" placeholder="画像">
                                </div>
                        </div>

                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">登録</button>
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
