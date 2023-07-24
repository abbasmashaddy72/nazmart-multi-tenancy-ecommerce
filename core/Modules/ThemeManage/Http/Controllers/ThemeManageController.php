<?php

namespace Modules\ThemeManage\Http\Controllers;

use App\Facades\ThemeDataFacade;
use App\Models\Tenant;
use App\Models\Themes;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ThemeManageController extends Controller
{
    const BASE_PATH = 'thememanage::tenant.backend.';

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        ;
        return view(self::BASE_PATH . 'index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('thememanage::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('thememanage::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('thememanage::edit');
    }

    public function update(Request $request, $slug)
    {
        $request->validate([
            'theme_setting_type' => ['required', Rule::in(['set_theme', 'set_theme_with_demo_data'])],
            'tenant_default_theme' => 'nullable',
        ], [
            'theme_setting_type.required' => __('Please select theme setting type by clicking on the theme image..!')
        ]);

        $all_theme_slugs = getAllThemeSlug();
        if (!in_array($slug, $all_theme_slugs)) {
            return response()->json([
                'status' => false
            ]);
        }

        $theme_setting_type = $request->theme_setting_type;
        $requested_theme = $request->tenant_default_theme;

        if($theme_setting_type == 'set_theme'){
            update_static_option('tenant_default_theme', $requested_theme);
        }
        else
        {
            $this->set_new_home($requested_theme);
            update_static_option('tenant_default_theme', $requested_theme);

            $tenant_id = \tenant()->id;
            Tenant::where('id', $tenant_id)->update([
                'theme_slug' => $requested_theme
            ]);
        }

        return response()->json([
            'status' => true
        ]);
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
