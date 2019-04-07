<?php

namespace App\Http\Controllers\Seller;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Seller;

class SellerController extends ApiController
{
    public function index()
    {
        $vendedores = Seller::has('products')->get();

        return response()->json(['data' => $vendedores], 200);
    }

    public function show($id)
    {
        $vendedor = Seller::has('products')->findOrFail($id);

        return $this->showOne($vendedor);
    }
}
