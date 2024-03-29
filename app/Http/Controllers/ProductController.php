<?php

namespace App\Http\Controllers;

use App\Enums\Category;
use App\Http\Requests\ProductRequest;
use App\Models\Attribute;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Inertia\Response
     */
    public function index(Request $request): \Inertia\Response
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
     * @return \Inertia\Response
     */
    public function create(): \Inertia\Response
    {
        $categories = [];

        foreach (Category::transform() as $key => $value) {
            $categories[] = [
                'name' => $value,
                'value' => $key
            ];
        }

        return Inertia::render('Product/Create', [
            'product_attributes' => Attribute::all(),
            'categories' => $categories,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ProductRequest $request): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validated();

        try {
            DB::beginTransaction();

            $product = Product::create([
                'name' => $validated['name'],
                'category' => $validated['category'],
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

                $path = $file->storeAs('uploads', $fileName);

                $product->productImages()->create([
                    'title' => str_replace(' ', '-', strtolower($validated['name'])) . '-' . $product->id . '-' . $type,
                    'url' => '/storage/public/' . $path,
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
     * @param int $id
     * @return \Inertia\Response
     */
    public function show(int $id): \Inertia\Response
    {
        return Inertia::render('Product/Show', [
            'product' => Product::with(['attributes'])->where('id', $id)->get()->first(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Inertia\Response
     */
    public function edit(int $id): \Inertia\Response
    {
        $categories = [];

        foreach (Category::transform() as $key => $value) {
            $categories[] = [
                'name' => $value,
                'value' => $key
            ];
        }
        return Inertia::render('Product/Edit', [
            'product' => Product::with(['attributes', 'thumbnail', 'cover'])->findOrFail($id),
            'categories' => $categories,

        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProductRequest $request, int $id): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validated();

        try {
            Product::where('id', $id)->update([
                'name' => $validated['name'],
                'category' => $validated['category'],
                'description' => $validated['description'],
                'name_de' => $validated['name_de'],
                'description_de' => $validated['description_de'],
                'is_active' => $validated['is_active'] == 'true',
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

                $path = $file->storeAs('uploads', $fileName);

                ProductImage::where('product_id', $id)->where('type', 'thumbnail')->update([
                    'title' => str_replace(' ', '-', strtolower($validated['name'])) . '-' . $id . '-thumbnail',
                    'url' => '/storage/public/' . $path,
                    'type' => 'thumbnail',
                ]);
            }

            if ($request->file('background')) {
                $file = $request->file('background');
                $ext = $file->getClientOriginalExtension();
                $fileName = "background-{$id}.{$ext}";

                $path = $file->storeAs('uploads', $fileName);

                ProductImage::where('product_id', $id)->where('type', 'background')->update([
                    'title' => str_replace(' ', '-', strtolower($validated['name'])) . '-' . $id . '-background',
                    'url' => '/storage/public/' . $path,
                    'type' => 'background',
                ]);
            }
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('failed', 'Error occured! ' . $e->getMessage());
        }

        return redirect()
            ->route('products.index')
            ->with('success', 'Product updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     */
    public function destroy(int $id)
    {
        //
    }
}
