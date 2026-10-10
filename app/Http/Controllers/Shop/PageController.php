<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\View\View;

class PageController extends Controller
{
    public function about(): View
    {
        return view('shop.about');
    }

    public function stores(): View
    {
        return view('shop.stores', [
            'storesByCity' => Store::orderBy('sort_order')->orderBy('city')->get()->groupBy('city'),
        ]);
    }

    public function sizeGuide(): View
    {
        return view('shop.size-guide');
    }
}
