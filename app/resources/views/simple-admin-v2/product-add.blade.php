@extends('simple-admin-v2.app')

@section('title', 'Webshop administration')

@section('content')
    <div class="col-sm-12">

        <div class="panel panel-default">
            <div class="panel-heading">
               Create product
            </div>
            <div class="panel-body">

                @include('simple-admin.errors')


                <form action="{{ url('products/create') }}" method="post" class="form-horizontal" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="name" class="col-sm-4 control-label">Name</label>
                        <div class="col-sm-8">
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', '') }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="price" class="col-sm-4 control-label">Price</label>
                        <div class="col-sm-8">
                            <input type="number" min="1" step="any" name="price" id="price" class="form-control" value="{{ old('price', 0.00) }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description" class="col-sm-4 control-label">Description</label>
                        <div class="col-sm-8">
                            <textarea name="description" id="description" class="form-control" >{{ old('description', '') }}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="brand" class="col-sm-4 control-label">Brand</label>
                        <div class="col-sm-8">
                            <select name="brand_id" id="brand_id" class="form-control">
                                @foreach ($brands as $brand)
                                    <option value="{{ $brand->id }}" @if (old('brand_id', '') == $brand->id) selected="selected" @endif>{{ $brand->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <input type="hidden" name="moduleAction" value="create" />
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-6">
                            <button type="submit" class="btn btn-default">
                                <i class="fa fa-btn fa-plus"></i><span class="button-text">Create product</span>
                            </button>
                        </div>
                    </div>
                </form>
                <p class="text-left"><a href="{{ url('/products') }}">Cancel and back to overview</a></p>


            </div>
        </div>

    </div>
@endsection
