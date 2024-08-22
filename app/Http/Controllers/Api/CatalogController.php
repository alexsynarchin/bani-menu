<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index()
    {
        $catalog = Category::where('parent_id',0)->with('children.products')->with('children.children.products')->with('products')->get();
        return $catalog;
    }
    public function nav() {
        $categories = Category::where('parent_id', 0)->get();
        return $categories;
    }

}
