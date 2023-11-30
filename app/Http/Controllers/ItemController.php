<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\ItemType;
use App\Models\Stock;
use App\Models\Nice;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 商品一覧
     */
    public function index()
    {
        // 商品一覧取得
        $items = Item::orderBy('created_at', 'desc')->paginate(16);

        return view('item.index', compact('items'));
    }

    /**
     * 商品登録
     */
    public function add(Request $request)
    {
        // POSTリクエストのとき
        if ($request->isMethod('post')) {
            // バリデーション
            $this->validate($request, [
                'name' => 'required|max:100',
                'type' => 'required',
                'stock' => 'required|numeric',
                'model_number' => 'required',
                'detail' => 'max:500',
                'img_path' => 'nullable|mimes:jpg,jpeg,png,gif',

            ]);
            
            $path = null;
            
            //画像がある時
            if ($request->img_path !== null){
            // 画像フォームでリクエストした画像を取得
            $img = $request->file('img_path');
            // storage > public > img配下に画像が保存される
            $path = $img->store('img','public');
            }
            
            Item::create([
                'user_id' => Auth::user()->id,
                'name' => $request->name,
                'model_number' => $request->model_number,
                'type' => $request->type,
                'stock' => $request->stock,
                'spicy' => $request->spicy,
                'detail' => $request->detail,
                'img_path' => $path,

                ]);
        
            return redirect('/items');
        }

        $itemTypes = ItemType::all();

        return view('item.add',['itemTypes' => $itemTypes]);
    }


    /**
     * 削除
     */

    public function destroy($id)
    {
        $items = Item::findOrFail($id);
            if ($items->img_path !== null){
            Storage::disk('public')->delete($items->img_path);
            }
        $items -> delete();



        return redirect('/items');
    }

    /**
     * 詳細画面
     */

    public function detail($id)
    {
        $item = Item::findOrFail($id);

        return view('item.detail', compact('item'));
    }

    /**
     * 商品編集
     */
    public function edit(Request $request)
    {
        // POSTリクエストのとき
        if ($request->isMethod('post')) {
            // バリデーション
            $this->validate($request, [
                'name' => 'required|max:100',
                'type' => 'required',
                'stock' => 'required|numeric',
                'model_number' => 'required',
                'detail' => 'max:500',
                'img_path' => 'nullable|mimes:jpg,jpeg,png,gif',

            ]);

            $item = Item::findOrFail($request -> id);

            $existing_img_path = null;
            $new_img_path = null;

            //画像がある時の商品登録
            if ($request->img_path !== null){
            // 画像フォームでリクエストした画像を取得
            $img = $request->file('img_path');
            // storage > public > img配下に画像が保存される
            $new_img_path = $img->store('img','public');
            
            }

            if($request->existing_img){
            $existing_img_path = $request->existing_img;
            }

            $item->update([
                'user_id' => Auth::user()->id,
                'name' => $request->name,
                'model_number' => $request->model_number,
                'type' => $request->type,
                'stock' => $request->stock,
                'spicy' => $request->spicy,
                'detail' => $request->detail,
                'img_path' =>$new_img_path?$new_img_path:$existing_img_path

            ]);

            return redirect('/items');
        }

        $item = Item::findOrFail($request -> id);
        $itemTypes = ItemType::all();

        return view('item.edit',[
            'item' => $item,
            'itemTypes' => $itemTypes
        ]);

    }


    /**
     * 検索
     */

    public function search(Request $request)
    {
        // リクエストからキーワードを取得
        $keyword = $request->input('keyword');
        // Itemテーブルと関連するItemTypeテーブルを含めたクエリを作成
        $query = Item::with('itemtype');

        // もし、キーワードが空でない場合、検索処理を実行
        if (!empty($keyword)) {
            $query->where('model_number','like','%'.$keyword.'%')
                ->orWhere('name','like','%'.$keyword.'%')
                ->orWhereHas('itemtype', function ($query) use ($keyword) {
                    $query->where('type_name','like','%'.$keyword.'%')
                ->orWhere('detail','like','%'.$keyword.'%')
                ->orWhere('spicy','like','%'.$keyword.'%');
                });
        }
        // 検索結果を登録日を基準に降順で16件表示
        $items = $query->orderBy('created_at', 'desc')->paginate(16);

        return view('item.index', compact('items','keyword'));
        
    }

    /**
     * セレクトボックスで並び替え
     */
    public function select(Request $request)
    {
        // セレクトボックスで選択した値
        $select = $request->price;

        // セレクトボックスの値に応じてソート
        switch ($select) {
            case '1':
                //「投稿が新しい順」でソート
                $items = Item::orderBy('created_at', 'desc')->paginate(16);
                break;
            case '2':
                // 「投稿が古い順」でソート
                $items = Item::orderBy('created_at', 'asc')->paginate(16);
                break;
            case '3':
                // 「在庫が多い順」でソート
                $items = Item::orderBy('stock', 'desc')->paginate(16);
                break;                
            case '4':
                // 「在庫が少ない順」でソート
                $items = Item::orderBy('stock', 'asc')->paginate(16);
                break;
            case '5':
                // 「辛い順」でソート
                $items = Item::orderBy('spicy', 'desc')->paginate(16);
                break;
            case '6':
                // 「甘い順」でソート
                $items = Item::orderBy('spicy', 'asc')->paginate(16);
                break;

                default :
                // デフォルトは投稿が新しい順
                $items = Item::orderBy('created_at', 'desc')->paginate(16);
                break;
        }
        $items->appends(['price' => $select]);
        return view('item.index', compact('items', 'select'));
    }

    /**
     * ブックマーク機能
     */
    public function show(Item $item)
    {  
        $nice=Nice::where('item_id', $item->id)->where('user_id', auth()->user()->id)->first();
        return view('item.show', compact('item', 'nice'));
    }

    /**
     * ブックマーク一覧
     */
    public function nice_items()
    {
        $items = \Auth::user()->nice_items()->orderBy('created_at', 'desc')->paginate(16);
        $data = [
            'items' => $items,
        ];
        return view('item.nice', $data);
    }

}
