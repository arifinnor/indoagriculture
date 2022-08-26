<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Attribute;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
    public function store(ProductRequest $request)
    {
        $validated = $request->validated();

        try {
            DB::beginTransaction();

            $product = Product::create([
                'name' => $validated['name'],
                'description' => $validated['description'],
                'is_active' => true,
            ]);

            foreach ($validated['attrs'] as $attr) {
                $product->productAttributes()->create([
                    'attribute_id' => $attr['id'],
                    'value' => $attr['value']
                ]);
            }

            foreach (ProductImage::getImageType() as $type) {
                $file = $validated->file($type);
                $ext = $file->getClientOriginalExtension();
                $fileName = "{$type}-{$product->id}.{$ext}";

                $file->storeAs('public/uploads', $fileName);

                $product->productImages()->create([
                    'title' => $validated['name'],
                    'url' => "uploads/{$fileName}",
                    'type' => $type,
                ]);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->with('failed', 'Error occured! ' . $e->getMessage());
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
        return Inertia::render('Product/Show', [
            'product' => Product::with(['attributes'])->where('id', $id)->get()->first(),

        ]);
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
            'product' => Product::with(['attributes', 'thumbnail', 'cover'])->where('id', $id)->first(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, $id)
    {
        $validated = $request->validated();

        try {
            $product = Product::where('id', $id)->update([
                'name' => $validated['name'],
                'description' => $validated['description'],
                'is_active' => $validated['is_active'] == 'true' ? true : false,
            ]);
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('failed', 'Error occured! ' . $e->getMessage());;
        }


        return redirect()
            ->route('products.index')
            ->with('success', 'Product updated!');
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
