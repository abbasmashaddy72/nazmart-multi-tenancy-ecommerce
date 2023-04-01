<?php

namespace Modules\DigitalProduct\Http\Controllers;

use App\Helpers\FlashMsg;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Modules\DigitalProduct\Entities\DigitalProductCategories;
use Modules\DigitalProduct\Entities\DigitalProductType;

class DigitalProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $all_category = DigitalProductCategories::all();
        $all_product_type = DigitalProductType::all();
        return view('digitalproduct::admin.category.all', compact('all_category', 'all_product_type'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('digitalproduct::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'slug' => 'nullable|max:255|unique:digital_categories,slug',
            'type_id' => 'required|integer',
            'description' => 'required|max:255',
            'status_id' => 'required|boolean',
            'image' => 'nullable'
        ]);

        $digital_product_type = new DigitalProductCategories();
        $digital_product_type->name = $validatedData['name'];
        $digital_product_type->slug = \Str::slug($validatedData['slug']);
        $digital_product_type->description = \Str::slug($validatedData['description']);
        $digital_product_type->digital_product_type = $validatedData['type_id'];
        $digital_product_type->status = $validatedData['status_id'];
        $digital_product_type->image_id = $validatedData['image'] ?? '';
        $digital_product_type->save();

        return back()->with(FlashMsg::create_succeed(__('Product Type')));
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('digitalproduct::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('digitalproduct::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'slug' => 'nullable|max:255|unique:digital_categories,slug,'.$request->id,
            'type_id' => 'required|integer',
            'description' => 'required|max:255',
            'status_id' => 'required|boolean',
            'image' => 'nullable'
        ]);

        $digital_product_type = DigitalProductType::find($request->id);
        $digital_product_type->name = $validatedData['name'];
        $digital_product_type->slug = \Str::slug($validatedData['slug']);
        $digital_product_type->description = \Str::slug($validatedData['description']);
        $digital_product_type->digital_product_type = $validatedData['type_id'];
        $digital_product_type->status = $validatedData['status_id'];
        $digital_product_type->image_id = $validatedData['image'] ?? '';
        $digital_product_type->save();

        return back()->with(FlashMsg::update_succeed(__('product categories')));
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
