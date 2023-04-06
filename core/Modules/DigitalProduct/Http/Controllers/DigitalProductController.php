<?php

namespace Modules\DigitalProduct\Http\Controllers;

use App\Models\Status;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Attributes\Entities\Tag;
use Modules\Badge\Entities\Badge;
use Modules\DigitalProduct\Entities\DigitalAuthor;
use Modules\DigitalProduct\Entities\DigitalCategories;
use Modules\DigitalProduct\Entities\DigitalTax;
use Modules\DigitalProduct\Http\Requests\DigitalProductRequest;
use Modules\DigitalProduct\Http\Services\Admin\AdminDigitalProductServices;

class DigitalProductController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        $products = AdminDigitalProductServices::productSearch($request);
        $statuses = Status::all();

        return view('digitalproduct::admin.product.index',compact("products", "statuses"));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $data = [
            "taxes" => DigitalTax::where('status', 1)->select('id','name')->get(),
            "badges" => Badge::where("status","active")->get(),
            "tags" => Tag::select("id", "tag_text as name")->get(),
            "categories" => DigitalCategories::where('status', 1)->select("id", "name")->get(),
            "authors" => DigitalAuthor::where('status', 1)->select('id', 'name')->get()
        ];

        return view('digitalproduct::admin.product.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(DigitalProductRequest $request)
    {
        $data = $request->validated();

//        \DB::beginTransaction();
//        try {
        $product = (new AdminDigitalProductServices())->store($data);
        dd('controller');
//            \DB::commit();
//        } catch (\Exception $exception)
//        {
//            \DB::rollBack();
//            return response(['success' => false]);
//        }

        return response()->json($product ? ["success" => true] : ["success" => false]);
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
    public function update(Request $request, $id)
    {
        //
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
