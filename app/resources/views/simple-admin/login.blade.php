@extends('simple-admin.app')

@section('title', 'Webshop administration')

@section('content')
    <div class="col-sm-offset-2 col-sm-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                Please log in
            </div>
            <div class="panel-body">

                @include('simple-admin.errors')

                <form action="{{ route('login')}}" method="POST" class="form-horizontal">
                    @csrf

                    <div class="form-group">
                        <label for="email" class="col-sm-3 control-label">Email</label>

                        <div class="col-sm-9">
                            <input type="text" name="email" id="email" class="form-control" value="{{ old('email') }}" required="required" autofocus="autofocus">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-sm-3 control-label">Password</label>

                        <div class="col-sm-9">
                            <input type="password" name="password" id="password" class="form-control" value="" autocomplete="off">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="remember_me" class="col-sm-3 control-label">Remember me</label>

                        <div class="col-sm-8">
                            <div class="radio">
                                <input type="checkbox" name="remember" id="remember_me">
                            </div>

                        </div>
                    </div>


                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-6">
                            <button type="submit" class="btn btn-default">
                                Log in
                            </button>
                        </div>
                    </div>
                </form>
                <p class="text-left">
                {{--a href="{{ route('password.request') }}">
                    Forgot your password?
                </a--}}
</p>
</div>
</div>
</div>
@endsection
