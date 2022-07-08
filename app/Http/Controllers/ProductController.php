<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $rows = $request->rows ?? 10;

        return Inertia::render('Product/Index', [
            'products' => Product::when($request->search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%");
            })
                ->paginate($rows)
                ->withQueryString(),
            'filters' => [
                'search' => $request->search,
                'rows' => $rows
            ],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Product/Create', [
            'product_attributes' => Attribute::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' =>  'required|string|min:3',
            'description' => 'required|string',
            'images.thumbnail' => 'required|image',
            'images.background' => 'required|image',
            'attrs.*.id' => 'required',
            'attrs.*.value' => 'nullable',
        ])->validate();

        $product = Product::create([
            'name' => $validator['name'],
            'description' => $validator['description'],
            'is_active' => true,
        ]);

        foreach ($validator['attrs'] as $attr) {
            $product->productAttributes()->create([
                'attribute_id' => $attr['id'],
                'value' => $attr['value']
            ]);
        }

        foreach (ProductImage::getImageType() as $type) {
            $product->productImages()->create([
                'title' => "{$type}-{$product->id}",
                'url' => $request->file("images.{$type}")->store('images'),
                'type' => $type,
            ]);
        }

        return redirect()
            ->route('products.index')
            ->with('success', 'Product created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return Inertia::render('Product/Edit', [
            'product' => Product::with(['productAttributes', 'productImages'])->find($id),
            'properties' => Attribute::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
