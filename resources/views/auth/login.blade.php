@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ url('auth/google') }}">
                                <img src="https://developers.google.com/identity/images/btn_google_signin_dark_normal_web.png"
                                    style="margin-left: 3em;">
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
