@extends('simple-admin-v2.app')

@section('title', 'Webshop administration')

@section('content')
    <div class="col-sm-offset-2 col-sm-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                Please register
            </div>
            <div class="panel-body">

                @include('simple-admin.errors')

                <form action="{{ url('register')}}" method="post" class="form-horizontal">
                    @csrf

                    <div class="form-group">
                        <label for="name" class="col-sm-3 control-label">Name</label>

                        <div class="col-sm-9">
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required="required" autofocus="autofocus">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email" class="col-sm-3 control-label">Email</label>

                        <div class="col-sm-9">
                            <input type="text" name="email" id="email" class="form-control" value="{{ old('email') }}" required="required">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-sm-3 control-label">Password</label>

                        <div class="col-sm-9">
                            <input type="password" name="password" id="password" class="form-control" value="" autocomplete="off">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation" class="col-sm-3 control-label">Confirm password</label>

                        <div class="col-sm-9">
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" value="" autocomplete="off">
                        </div>
                    </div>


                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-6">
                            <button type="submit" class="btn btn-default">
                                Registreer
                            </button>
                        </div>
                    </div>
                </form>
                <p class="text-left">
                    <a href="{{ route('login') }}">
                        Already registered?
                    </a>
                </p>
            </div>
        </div>
    </div>
@endsection
