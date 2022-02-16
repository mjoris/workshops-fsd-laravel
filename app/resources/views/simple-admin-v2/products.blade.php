@extends('simple-admin-v2.app')

@section('title', 'Webshop administration')

@section('content')
    <div class="col-sm-offset-2 col-sm-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                Products
                @can ('add-product')
                <a class="btn btn-sm btn-default text-right" href="{{ url('products/create') }}" role="button">
                    <i class="fa fa-btn fa-plus"></i><span class="button-text">Create</span>
                </a>
                @endcan
            </div>
            <div class="panel-body">

                @if ($products)

                <table class="table table-striped task-table" >
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Brand</th>
                        <th>Categories</th>
                        <th>&nbsp;</th>
                    </tr>

                    </thead>
                    <tbody>
                    @foreach($products as $product)

                    <tr>
                        <td class="table-text">
                            {{ $product->name }}
                        </td>
                        <td class="table-text">
                            &euro; {{ $product->price }}
                        </td>
                        <td class="table-text">
                            {{ $product->brand->name }}
                        </td>
                        <td class="table-text">
                            {{ $product->categories->pluck('name')->implode(' | ') }}
                        </td>
                        <td>
                            <a class="btn btn-sm btn-info" href="{{ url('products/' . $product->id) }}" role="button">
                                <i class="fa fa-btn fa-info"></i><span class="button-text">Details</span>
                            </a>
                            <!--a class="btn btn-primary" href="{{ url('products/' . $product->id . '/update') }}" role="button">
                                <i class="fa fa-btn fa-pencil"></i><span class="button-text">Update</span>
                            </a>
                            <a class="btn btn-danger" href="{{ url('products/' . $product->id . '/delete') }}" role="button">
                                <i class="fa fa-btn fa-trash"></i><span class="button-text">Delete</span>
                            </a-->
                        </td>

                    </tr>
                    @endforeach

                    </tbody>
                </table>
                @else
                <p>No products available.</p>
                @endif
            </div>
        </div>
    </div>
@endsection
