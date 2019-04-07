<?php

namespace App\Http\Controllers\Seller;

use App\Seller;
use App\User;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class SellerProductController extends ApiController
{

    public function index(Seller $seller)
    {
        $products = $seller->products;

        return $this->showAll($products);
    }

    public function store(Request $request, User $seller)
    {
        $rules = [
            'name' => 'required',
            'description' => 'required',
            'quantity' => 'required|integer|min:1',
            'image' => 'required|image',
        ];

        $this->validate($request, $rules);
        
        $data = $request->all();
        
        $data['status'] = Product::PRODUCTO_NO_DISPONIBLE;
        $data['image'] = '1.jpg'; 
        $data['seller_id'] = $seller->id;

        $product = Product::create($data); 

        return $this->showOne($product, 201);
    }

    public function update(Request $request, Seller $seller, Product $product)
    {
        $rules = [
            'quantity' => 'integer|min:1',
            'status' => 'in: ' . Product::PRODUCTO_DISPONIBLE . ',' . Product::PRODUCTO_NO_DISPONIBLE,
            'image' => 'image',
        ];
        $this->validate($request, $rules);
        if ($seller->id == $product->seller_id) {
            $product->fill($request->only([
                'name',
                'description',
                'quantity',
            ]));
            if ($request->has('status')) {
                $product->status = $request->status;
                if ($product->estaDisponible() && $product->categories()->count() == 0) {
                    return $this->errorResponse('Un producto activo debe tener al menos una categoría', 409);
                }
            }
            if ($product->isClean()) {
                return $this->errorResponse('Se debe especificar al menos un valor diferente para actualizar', 422);
            }
        }else{
            return $this->errorResponse('El vendedor especificado no es el vendedor real del producto', 422);
        }
        
        $product->save();
        return $this->showOne($product);
    }

    public function destroy(Seller $seller, Product $product)
    {
        if ($seller->id != $product->seller_id) {
            return $this->errorResponse('El vendedor especificado no es el vendedor real del producto', 422);
        }else{
            $product->delete();
            return $this->showOne($product);
        }
    }

    protected function verificarVendedor(Seller $seller, Product $product)
    {
        if ($seller->id != $product->seller_id) {
            return $this->errorResponse(422, 'El vendedor especificado no es el vendedor real del producto');
        }
    }

}
