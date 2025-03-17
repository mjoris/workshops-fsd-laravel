<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    // Controller methods for concluding demo 'webshop' of 03.lets.mvc
    public function demo1(): void
    {
        // retrieve product (data record) with ID 1
        $product = Product::find(1);
        dump($product->name);
        dump($product->price);

        // retrieve the product's brand (data record) through many-to-one
        $brand = $product->brand;
        dump('brand: '.$brand->name);

        // retrieve the product's categories (collection of data records) through many-to-many
        $categories = $product->categories;
        foreach ($categories as $category) {
            dump('category: '.$category->name);
        }

        // retrieve all products (collection of data records)
        $products = Product::all();
        dump('# products: '.$products->count()); // count of collection
        dump('# products: '.Product::count());   // count in DB query (faster!)
    }

    public function demo2(): void
    {
        // retrieve all products of brand 1
        $productsOfBrandOne = Product::where('brand_id', 1)->orderBy('price', 'desc')->get();
        dump('all products of brand 1 ---');
        dump($productsOfBrandOne->pluck('name', 'id')); // pluck of collection
        dump($productsOfBrandOne->pluck('name', 'id')->all()); // ... as a plain array
        dump(Product::where('brand_id', 1)->orderBy('price', 'desc')->pluck('name', 'id')); // pluck integrated in DB query

        // retrieve all products of category 2
        dump('all products of category 2 ---');
        $id = 2;
        dump(Category::find($id)->products->pluck('name')); // v1: involves 2 DB queries (key in collection is 0 !)
        dump(Category::find($id)->products()->pluck('name')); // v2: still 2 DB queries ...

        // v3: involves only 1 DB query
        $productsOfCategoryTwo = Product::whereHas('categories', function (Builder $query) use ($id) {
            $query->where('id', $id);
        })->get();
        dump($productsOfCategoryTwo);

        // v4: shorter, with whereRelation
        dump(Product::whereRelation('categories', 'id', $id)->get());
    }

    public function demo3(): void
    {
        // add a new product of brand 1
        $brand1 = Brand::find(1);
        $apple = new Product;
        $apple->name = 'Jonagold';
        $apple->description = 'Just a piece of fruit';
        $apple->price = 0.85;
        $apple->brand()->associate($brand1);
        $apple->save();

        // add another new product of brand 1 in one line
        $brand1->products()->create(['name' => 'Pink Lady', 'description' => 'Just a piece of fruit', 'price' => 0.85]);
        // yes ... you just saw a mass-assignment
    }

    public function demo4(): void
    {
        // product checkup: find products without category or price 0.00
        dump('faulty products ---');
        $faultyProductsBuilder = Product::where('price', 0.00)->orDoesntHave('categories');
        $faultyProductStrings = $faultyProductsBuilder->get()->map(function ($product) {
            return $product->id.'. '.$product->name.' ('.$product->price.'€)';
        });
        dump($faultyProductStrings->all());

        // Let's add both categories to the first faulty product
        $faultyProductsBuilder->first()?->categories()->sync([1, 2]);

        // ... and delete all apples anyway
        Product::where('price', 0.85)->delete();
    }

    public function demo5(): void
    {
        $lazyProduct = Product::find(1);
        $eagerProduct = Product::with('brand')->find(1);
        dump($lazyProduct);  // internal relations field empty
        dump($eagerProduct); // internal relations field with 'brand'

        // no difference
        dump($lazyProduct->brand->name);
        dump($eagerProduct->brand->name);
    }

    // Controller methods for concluding demo 'webshop' of 04.forms

    public function overview(): View
    {
        return view('simple-admin.products', ['products' => Product::all()]);
    }

    /*
    public function show(string $id): View
    {
        $product = Product::findOrFail($id);
        return view('simple-admin.product-detail', ['product' => $product]);
    }
    */

    public function show(Product $product): View
    {
        return view('simple-admin.product-detail', ['product' => $product]);
    }

    public function showCreateForm(): View
    {
        return view('simple-admin.product-add', ['brands' => Brand::all()]);
    }

    public function create(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|unique:products|max:125',
            'price' => 'required|numeric|min:0.10',
            'description' => 'nullable', // because of ConvertEmptyStringsToNull
            'brand_id' => 'required|exists:brands,id',
        ]);

        $product = new Product($request->all());

        // description might be NULL, but this is not allowed in the DB model
        if (! $request->filled('description')) {
            $product->description = '';
        }

        $product->save();

        /* Or, all at once:
        Product::create($request->collect()->map(fn ($i) => ($i ?? ''))->all());
        */

        return redirect('products');

    }
}
