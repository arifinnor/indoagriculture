<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
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
            'images.thumbnail' => [
                'required',
                'image',
                Rule::dimensions()->maxHeight(1900)->maxWidth(1900)->ratio(1 / 1)
            ],
            'images.background' =>  [
                'required',
                'image',
                Rule::dimensions()->maxHeight(1900)->maxWidth(1900)->ratio(1 / 1)
            ],
            'attrs.*.id' => 'nullable',
            'attrs.*.value' => 'nullable',
        ])->validate();

        try {
            DB::beginTransaction();

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
                $file = $request->file("images.{$type}");
                $ext = $file->getClientOriginalExtension();
                $fileName = "{$type}-{$product->id}.{$ext}";

                $file->storeAs('public/uploads', $fileName);

                $product->productImages()->create([
                    'title' => $validator['name'],
                    'url' => "uploads/{$fileName}",
                    'type' => $type,
                ]);
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            return redirect()->back()->with('failed', 'Error occured! ' . $th->getMessage());
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
            'product' => Product::with(['attributes'])->where('id', $id)->get()->first(),
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
