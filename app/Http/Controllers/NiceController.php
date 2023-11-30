<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use追加
use App\Models\Item;
use App\Models\Nice;
use Illuminate\Support\Facades\Auth;

class NiceController extends Controller
{
    /**
     * ブックマーク
     */

    public function store($itemId) {
        $user = \Auth::user();
        if (!$user->is_nice($itemId)) {
            $user->nice_items()->attach($itemId);
        }
        return back();
    }
    public function destroy($itemId) {
        $user = \Auth::user();
        if ($user->is_nice($itemId)) {
            $user->nice_items()->detach($itemId);
        }
        return back();
    }
}
