@extends('layouts.app')

@section('title', __('messages.verification_email'))

@section('main-content')
    <div class="page-body">
        <div class="container-xl">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <p>
                                {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
                            </p>

                            @if (session('status') == 'verification-link-sent')
                                <div class="alert alert-important bg-green-lt text-center mb-4" role="alert">
                                    {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                                </div>
                            @endif

                            <div class="d-flex">
                                <form method="POST" action="{{ route('verification.send') }}">
                                    @csrf

                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Resend Verification Email') }}
                                    </button>
                                </form>

                                <form class="ms-auto" method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <button type="submit" class="btn btn-link">{{ __('Log Out') }}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
