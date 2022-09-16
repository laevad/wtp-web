<x-guest-layout>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-6">
                <div class="card">
                    <div class="card-header font-weight-bold ">{{ __('Register') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="row mb-3">
                                <label for="name" class="col-md-4 col-form-label text-md-end ">{{ __('Name') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control border @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control border @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password-confirm" class="col-md-4  col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control border" name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="">
                                <div class="offset-md-4 col-md-6">
                                    <button type="submit" class="btn btn-primary customPrimaryColor border-0 btn-block">
                                        {{ __('Register') }}
                                    </button>
                                </div>
                            </div>
                            <div class="text-center text-muted mt-4">Already have an account? <a href="{{ url('/') }}" class="customColor">Sign in</a> </div>
                        </form>
                    </div>
{{--                    <div class="mx-3 my-2 py-2  bordert">--}}
{{--                        <div class="text-center py-3">--}}
{{--                            <a href="" target="_blank" class="px-2">--}}
{{--                                <img src="https://www.dpreview.com/files/p/articles/4698742202/facebook.jpeg" alt="">--}}
{{--                            </a>--}}
{{--                            <a href="" target="_blank" class="px-2">--}}
{{--                                <img src="https://www.freepnglogos.com/uploads/google-logo-png/google-logo-png-suite-everything-you-need-know-about-google-newest-0.png"--}}
{{--                                     alt="">--}}
{{--                            </a>--}}


{{--                        </div>--}}
{{--                    </div>--}}
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
