<?php

namespace DataSource\Http\Controllers\Admin\Product;

use Illuminate\Http\Request;
use DataSource\Entities\User\User;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use DataSource\Entities\Exercise\Exercise;
use DataSource\Entities\Product\Product;
use DataSource\Http\Controllers\BaseController;
use DataSource\Http\Requests\Admin\Product\Store;
use DataSource\Http\Requests\Admin\Product\Update;
use DataSource\Traits\Admin\AdminCRUDControllerActions;
use DataSource\Repositories\DB\Product\Admin\AdminProductRepository;
use DataSource\Repositories\DB\Exercise\Admin\AdminExerciseRepository;
use DataSource\Repositories\DB\Practice\Admin\AdminPracticeRepository;
use DataSource\Repositories\DB\Practice\Admin\AdminPracticeLevelRepository;
use DataSource\Repositories\DB\CategoryProduct\Admin\AdminCategoryProductRepository;

class AdminProductController extends BaseController
{
    use AdminCRUDControllerActions;

    protected string $module = 'datasource::management.products';
    protected string $table_name = 'products';
    protected string $route_name = 'products';
    protected string $interface = AdminProductRepository::class;
    protected string $store_request = Store::class;
    protected string $update_request = Update::class;

    public function create()
    {
        $route_name = $this->route_name;
        $table_name = $this->table_name;
        $categoryProducts = AdminCategoryProductRepository::list();
        return view($this->module . '.create', compact('route_name', 'table_name', 'categoryProducts'));
    }

    public function show($id)
    {
        $route_name = $this->route_name;
        $table_name = $this->table_name;
        $categoryProducts = AdminCategoryProductRepository::list();
        $item = $this->getRepository()->find($id);
        return view($this->module . '.show', compact('route_name', 'table_name', 'categoryProducts', 'item'));
    }
    public function store(Request $request)
    {
        $product = new Product;
        foreach (localeSupported() as $locale) {
            $product->translateOrNew($locale)->name = $request['name-' . $locale];
            $product->translateOrNew($locale)->desc = $request['desc-' . $locale];
        }

        $photo = $request->file('photo')->store('public/photos');
        $product->photo = Storage::url($photo);
        $product->category_product_id = $request->category_product_id;
        $product->price = $request->price;
        $product->unit = $request->unit;
        $product->save();
        return redirect()->route('admin.products.index')->withSuccess('product created successfully');
    }
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        foreach (localeSupported() as $locale) {
            $product->translateOrNew($locale)->name = $request['name-' . $locale];
            $product->translateOrNew($locale)->desc = $request['desc-' . $locale];
        }

        if ($request->hasFile('photo')) {
            if ($product->photo) {
                Storage::delete(str_replace('/storage/', 'public/', $product->photo));
            }
            $photo = $request->file('photo')->store('public/photos');
            $product->photo = Storage::url($photo);
        }
        $product->category_product_id = $request->category_product_id;
        $product->price = $request->price;
        $product->unit = $request->unit;
        $product->save();

        return redirect()->route('admin.products.index')->withSuccess('Product updated successfully');
    }
}
