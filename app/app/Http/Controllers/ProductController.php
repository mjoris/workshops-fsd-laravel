<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

// Eloquent model for concluding demo 'webshop' of 02.lets.mvc
class ProductController extends Controller
{

    public function demo1()
    {
        // retrieve product (data record) with ID 1
        $product = Product::find(1);
        dump($product->name);
        dump($product->price);

        // retrieve the product's brand (data record) through many-to-one
        $brand = $product->brand;
        dump('brand: ' . $brand->name);

        // retrieve the product's categories (collection of data records) through many-to-many
        $categories = $product->categories;
        foreach ($categories as $category) {
            dump('category: ' . $category->name);
        }

        // retrieve all products (collection of data records)
        $products = Product::all();
        dump('# products: ' . $products->count()); // count of collection
        dump('# products: ' . Product::count());   // count in DB query (faster!)
    }

    public function demo2()
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

        // v3: the preferable solution
        $productsOfCategoryTwo = Product::whereHas('categories', function (Builder $query) use ($id) {
            $query->where('id', $id);
        })->get();
        dump($productsOfCategoryTwo);
    }

    public function demo3()
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

    public function demo4()
    {
        // product checkup: find products without category or price 0.00
        dump('faulty products ---');
        $faultyProductsBuilder = Product::where('price', 0.00)->orDoesntHave('categories');
        $faultyProductStrings = $faultyProductsBuilder->get()->map(function ($product) {
            return $product->id . '. ' . $product->name . ' (' . $product->price . '€)';
        });
        dump($faultyProductStrings->all());

        // Let's add both categories to the first faulty product
        $faultyProductsBuilder->first()?->categories()->sync([1, 2]);

        // ... and delete all apples anyway
        Product::where('price', 0.85)->delete();
    }

    public function overview()
    {
        return view('simple-admin.products', ['products' => Product::all()]);
    }

    public function showCreateForm()
    {
        return view('simple-admin.product-add', ['brands' => Brand::all(), 'formErrors' => ['yes indeed']]);
    }


}
