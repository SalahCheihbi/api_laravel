<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    use GeneralTrait;

    public function index()
    {
        $categories = Category::select('id', 'created_at', 'name_' . app()->getLocale() . ' as name')->get();
        return response()->json($categories);
    }

    public function getCategoryById(Request $request)
    {
        $category = Category::select()->find($request-> id);
        if(!$category){
            return $this->returnError('category not found', 'E001');
        }
        return response()->json($category);
    }
}
