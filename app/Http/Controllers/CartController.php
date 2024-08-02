<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {
    $cart_exists = $request->session()->exists('cart');
    if ($cart_exists) {
      $cart = session('cart');

      return response()->json([
        'status' => true,
        'data' => $cart
      ]);
    }
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $id = $request->get('id');
    $name = $request->get('name');
    $price = $request->get('price');
    $quantity = $request->get('quantity');
    $image = $request->get('image');
    $cart_exists = $request->session()->exists('cart');

    if (!$cart_exists) {
      $cart = [
        [
          "id" => $id,
          "name" => $name,
          "price" => $price,
          "quantity" => (int)$quantity,
          "image" => $image
        ]
      ];

      $request->session()->put('cart', $cart);

      return response()->json([
        'status' => true,
        'message' => 'Producto agregado exitosamente!'
      ]);
    }

    $cart = session('cart');
    $product_key = false;

    foreach ($cart as $key => $item) {
      if ($item['id'] == $id) {
        $product_key = $key;
      }
    }
    // UPDATE QUANTITY
    if ($product_key !== false) {
      $product_quantity = $cart[$product_key]["quantity"];

      if ($product_quantity <= 9 && ($product_quantity + $quantity <= 10)) {
        $product_quantity += $quantity;
      } else {
        return response()->json([
          'status' => false,
          'message' => 'Has alcanzado el límite de cantidad de este producto'
        ]);
      }

      $cart[$product_key]["quantity"] = (int)$product_quantity;
      $request->session()->put('cart', $cart);

      return response()->json([
        'status' => true,
        'message' => 'Se actualizó la cantidad del producto'
      ]);
    }

    // ADD NEW ITEM TO CART
    $new_item = [
      "id" => $id,
      "name" => $name,
      "price" => $price,
      "quantity" => (int)$quantity,
      "image" => $image
    ];

    $request->session()->push('cart', $new_item);

    return response()->json([
      'status' => true,
      'message' => 'Producto agregado exitosamente!'
    ]);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Request $request, string $id)
  {
    if ($id) {
      $cart = session('cart');
      $product_key = array_search($id, array_column($cart, 'id'));

      if ($product_key !== false) {
        foreach ($cart as $key => $value) {
          if ($value['id'] == $id) {
            unset($cart[$key]);
          }
        }

        $request->session()->put('cart', $cart);

        return response()->json([
          'status' => true,
          'message' => 'Producto eliminado'
        ]);
      } else {
        return response()->json([
          'status' => true,
          'message' => 'El producto no existe en el carrito'
        ]);
      }
    }
  }
}
