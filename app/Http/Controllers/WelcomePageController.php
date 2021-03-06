<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductThumbnailResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class WelcomePageController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $thumbnails = Product::with('thumbnail')->orderBy('id', 'desc')->take(4)->get();

        return Inertia::render('Welcome', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'product_images' => $thumbnails
        ]);
    }
}
