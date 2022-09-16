<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class AttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): \Inertia\Response
    {
        $rows = $request->rows ?? 10;

        return Inertia::render('Attribute/Index', [
            'attributes' => Attribute::when($request->search, function ($query, $search) {
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
        return Inertia::render('Attribute/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws ValidationException
     */
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                'string',
                'min:3'
            ],
            'language' => [
                'required',
                Rule::in(['en', 'de'])
            ]
        ])->validate();

        Attribute::create($validator);

        return redirect()
            ->route('attributes.index')
            ->with('success', 'Property created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id): \Illuminate\Http\Response
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Inertia\Response
     */
    public function edit(int $id): \Inertia\Response
    {
        return Inertia::render('Attribute/Edit', [
            'attribute' => Attribute::find($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws ValidationException
     */
    public function update(Request $request, int $id): \Illuminate\Http\RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => [
                'required', 'string', 'min:3'
            ],
            'language' => [
                'required',
                Rule::in(['en', 'de'])
            ]
        ])->validate();

        Attribute::where('id', $id)->update($validator);

        return redirect()
            ->route('attributes.index')
            ->with('success', 'Property updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(int $id): \Illuminate\Http\RedirectResponse
    {
        Attribute::destroy($id);

        return redirect()
            ->route('attributes.index')
            ->with('success', 'Property deleted!');
    }
}
