<?php

namespace App\Http\Controllers\Api;
use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{


    public function index(){
    $categories = Category::select('id','created_at','name_'.app() -> getLocale() .' as name')->get();
    return response()->json($categories);
}}
