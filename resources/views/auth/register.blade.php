@extends('layouts.auth')

@section('content')
    <div id="wrapper">

        <div class="card card-authentication1 mx-auto my-4">
            <div class="card-body">
                <div class="card-content p-2">
                    <div class="text-center">
                        <img src="assets/images/apiibaru.png" alt="logo icon">
                    </div>
                    <div class="card-title text-uppercase text-center py-3">Sign Up</div>
                    <form class="mt-4" action="{{ route('register') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputName" class="sr-only">Name</label>
                            <div class="position-relative has-icon-right">
                                <input name="name" type="text" id="exampleInputName" class="form-control input-shadow"
                                    placeholder="Enter Your Name">
                                <div class="form-control-position">
                                    <i class="icon-user"></i>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmailId" class="sr-only">Email</label>
                            <div class="position-relative has-icon-right">
                                <input name="email" type="email" id="exampleInputEmailId"
                                    class="form-control input-shadow" placeholder="Enter Your Email ID">
                                <div class="form-control-position">
                                    <i class="icon-envelope-open"></i>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPhoneNumber" class="sr-only">Phone Number</label>
                            <div class="position-relative has-icon-right">
                                <input name="phone_number" type="text" id="exampleInputPhoneNumber"
                                    class="form-control input-shadow" placeholder="Enter Your Phone Number">
                                <div class="form-control-position">
                                    <i class="icon-phone"></i>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password" class="sr-only">Password</label>
                            <div class="position-relative has-icon-right">
                                <input name="password" type="password" id="password" class="form-control input-shadow"
                                    placeholder="Password">
                                <div class="form-control-position">
                                    <i class="icon-lock"></i>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation" class="sr-only">Password Confirmation</label>
                            <div class="position-relative has-icon-right">
                                <input name="password_confirmation" type="password" id="password_confirmation"
                                    class="form-control input-shadow" placeholder="Password Confirmation">
                                <div class="form-control-position">
                                    <i class="icon-lock"></i>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="icheck-material-white">
                                <input type="checkbox" id="user-checkbox" checked="" />
                                <label for="user-checkbox">I Agree With Terms & Conditions</label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-light btn-block waves-effect waves-light">Sign Up</button>




                    </form>
                </div>
            </div>
            <div class="card-footer text-center py-3">
                <p class="text-warning mb-0">Already have an account? <a href="{{ route('login') }}"> Sign In here</a></p>
            </div>
        </div>

        <!--Start Back To Top Button-->
        <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
        <!--End Back To Top Button-->

        <!--start color switcher-->
        <div class="right-sidebar">
            <div class="switcher-icon">
                <i class="zmdi zmdi-settings zmdi-hc-spin"></i>
            </div>
            <div class="right-sidebar-content">

                <p class="mb-0">Gaussion Texture</p>
                <hr>

                <ul class="switcher">
                    <li id="theme1"></li>
                    <li id="theme2"></li>
                    <li id="theme3"></li>
                    <li id="theme4"></li>
                    <li id="theme5"></li>
                    <li id="theme6"></li>
                </ul>

                <p class="mb-0">Gradient Background</p>
                <hr>

                <ul class="switcher">
                    <li id="theme7"></li>
                    <li id="theme8"></li>
                    <li id="theme9"></li>
                    <li id="theme10"></li>
                    <li id="theme11"></li>
                    <li id="theme12"></li>
                    <li id="theme13"></li>
                    <li id="theme14"></li>
                    <li id="theme15"></li>
                </ul>

            </div>
        </div>
        <!--end color switcher-->

    </div>
@endsection
