@extends('layouts.menu')

@section('content')
       <!-- Start Banner Area -->
       <section class="banner-area organic-breadcrumb">
        <div class="container">
            <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
                <div class="col-first">
                    <h1>Регистрация</h1>
                    <nav class="d-flex align-items-center">
                        <a href="/">Главная<span class="lnr lnr-arrow-right"></span></a>
                        <a href="/auth/login">Вход/Регистрация</a>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- End Banner Area -->

    <!--================Registration Box Area =================-->
    <section class="login_box_area section_gap">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="login_form_inner">
                        <h3>Зарегистрируйся, чтобы войти</h3>
                        <form class="row login_form" id="regForm" novalidate="novalidate">
                            <div class="col-md-12 form-group">
                                <input type="text" class="form-control" v-model="name" id="name" placeholder="Username" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Username'" required>
                            </div>
                            <div class="col-md-12 form-group">
                                <input type="email" class="form-control" v-model="email" id="email" placeholder="Email" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Email'" required>
                            </div>
                            <div class="col-md-12 form-group">
                                <input type="password" class="form-control" v-model="pass" id="password" placeholder="Password" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Password'" required>
                            </div>
                            <div class="col-md-12 form-group">
                                <input type="password" class="form-control" v-model="pass_conf" id="password_confirmation" placeholder="Repeat Password" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Repeat Password'" required>
                            </div>
                            <div class="col-md-12 form-group">
                                <button v-on:click.prevent="onSubmit" value="submit" class="primary-btn">Зарегистрироваться</button>
                                <div class="col-md-12 form-group bg-danger text-light" v-show="error">
                                    @{{error}}
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================End Registration Box Area =================-->
    <script src="/js/vue/auth/registration.js"></script>
@endsection

