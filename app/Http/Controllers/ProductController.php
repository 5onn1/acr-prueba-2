<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $products = Storage::json('products.json');
    return response()->json([
      'status' => true,
      'products' => $products['products']
    ]);
  }
}
