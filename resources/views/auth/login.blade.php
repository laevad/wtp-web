<x-guest-layout>
    <div class="container">
        <div class="row">
            <div class="offset-md-2 col-lg-5 col-md-7 offset-lg-4 offset-md-3">
                <div class="panel border bg-white p-2">
                    <div class="panel-heading">
                        <h3 class="pt-3 font-weight-bold text-center">{{ config('app.name', 'WT&P Management System') }}</h3>
                    </div>
                    <div class="panel-body p-3">
                        <form  method="POST" action="{{ route('login') }}">
                            @csrf
                            <div>
                                <label for="email" class="col-md-5 col-form-label text-md-end ">{{ __('Email Address') }}</label>
                                <input id="email" style="width: 100%" type="text" class="form-control  border @error('email') is-invalid @enderror" placeholder="Enter your Email" name="email" value="{{ old('email') }}"  autocomplete="email" autofocus>

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="py-1 pb-2">
                                <div class=" ">
                                    <label for="password" class="col-md-4 col-form-label text-md-end ">{{ __('Password') }}</label>
                                    <input id="password" type="password" class="form-control border @error('password') is-invalid @enderror" name="password" placeholder="Enter your Password"  autocomplete="current-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <button class="btn btn-primary btn-block mt-3 customPrimaryColor border-0" type="submit"> {{ __('Login') }}</button>


                        </form>
                        {{--center div--}}
                        <div style="background-color: #f5f5f5; border-radius: 5px; padding: 10px; margin-top: 10px">

                            <p class="text-center">Email:
                            <span>a@a.a</span>
                            </p>
                            <p class="text-center">Password: 1234 </p>
                        </div>
                    </div>





                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
