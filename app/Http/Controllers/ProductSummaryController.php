<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Inertia\Inertia;

class ProductSummaryController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Product $product)
    {
        return Inertia::render('Product/Show', [
            'product' => Product::with(['attributes', 'productImages'])->where('id', $product->id)->get()->first(),
            'locale' => App::getLocale()

        ]);
    }
}
