<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
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
        $locale = App::currentLocale();
        $thumbnails = Product::with('thumbnail')->where('is_active',1)->orderBy('id', 'desc')->take(4)->get();

        return Inertia::render('Welcome', [
            'product_images' => $thumbnails,
            'locale' => $locale,
        ]);
    }
}
