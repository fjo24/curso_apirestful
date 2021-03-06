<?php

namespace App\Http\Controllers\Transaction;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Transaction;

class TransactionCategoryController extends ApiController
{
    public function index(Transaction $transaction)
    {
        $categories = $transaction->product->categories;
         return $this->showAll($categories);
    }
}
