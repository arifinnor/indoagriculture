<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Attribute;
use App\Models\Product;
use App\Models\ProductAttribute;
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
                'name_de' => $validated['name_de'],
                'description_de' => $validated['description_de'],
                'is_active' => true,
            ]);

            foreach ($validated['attrs'] as $attr) {
                $product->productAttributes()->create([
                    'attribute_id' => $attr['id'],
                    'value' => $attr['value']
                ]);
            }

            foreach (ProductImage::getImageType() as $type) {
                $file = $request->file($type);
                $ext = $file->getClientOriginalExtension();
                $fileName = "{$type}-{$product->id}.{$ext}";

                $file->storeAs('public/uploads', $fileName);

                $product->productImages()->create([
                    'title' => str_replace(' ', '-', strtolower($validated['name'])) . '-' . $product->id . '-' . $type,
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
        // dd(Product::with(['attributes', 'thumbnail', 'cover'])->findOrFail($id));

        return Inertia::render('Product/Edit', [
            'product' => Product::with(['attributes', 'thumbnail', 'cover'])->findOrFail($id),
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
            Product::where('id', $id)->update([
                'name' => $validated['name'],
                'description' => $validated['description'],
                'name_de' => $validated['name_de'],
                'description_de' => $validated['description_de'],
                'is_active' => (bool) $validated['is_active'],
            ]);

            foreach ($validated['attrs'] as $attr) {
                ProductAttribute::where('product_id', $id)->where('attribute_id', $attr['id'])->update([
                    'value' => $attr['value']
                ]);
            }

            if ($request->file('thumbnail')) {
                $file = $request->file('thumbnail');
                $ext = $file->getClientOriginalExtension();
                $fileName = "thumbnail-{$id}.{$ext}";

                // dd($fileName);

                $file->storeAs('public/uploads', $fileName);

                ProductImage::where('product_id', $id)->where('type', 'thumbnail')->update([
                    'title' => str_replace(' ', '-', strtolower($validated['name'])) . '-' . $id . '-thumbnail',
                    'url' => "uploads/{$fileName}",
                    'type' => 'thumbnail',
                ]);
            }

            if ($request->file('background')) {
                $file = $request->file('background');
                $ext = $file->getClientOriginalExtension();
                $fileName = "background-{$id}.{$ext}";

                $file->storeAs('public/uploads', $fileName);

                ProductImage::where('product_id', $id)->where('type', 'background')->update([
                    'title' => str_replace(' ', '-', strtolower($validated['name'])) . '-' . $id . '-background',
                    'url' => "uploads/{$fileName}",
                    'type' => 'background',
                ]);
            }
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
