@extends('layouts.menu')

@section('content')
       <!-- Start Banner Area -->
       <section class="banner-area organic-breadcrumb">
        <div class="container">
            <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
                <div class="col-first">
                    <h1>Вход</h1>
                    <nav class="d-flex align-items-center">
                        <a href="/">Главная<span class="lnr lnr-arrow-right"></span></a>
                        <a href="/auth/login">Вход/Регистрация</a>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- End Banner Area -->

    <!--================Login Box Area =================-->
    <section class="login_box_area section_gap" >
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="login_box_img">
                        <img class="img-fluid" src="/img/login.jpg" alt="">
                        <div class="hover">
                            <h4>Впервые на нашем сайте?</h4>
                            <p>There are advances being made in science and technology everyday, and a good example of this is the</p>
                            <a class="primary-btn" href="/auth/registration">Зарегистрироваться</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="login_form_inner">
                        <h3>Авторизуйтесь, чтобы войти</h3>

                        <form class="row login_form" id="loginForm" novalidate="novalidate">
                            <div class="col-md-12 form-group">
                                <input type="email" class="form-control" v-model="email" id="email" placeholder="Email" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Email'" required>
                            </div>
                            <div class="col-md-12 form-group">
                                <input type="password" class="form-control" v-model="pass" id="password" placeholder="Password" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Password'" >
                            </div>
                            {{-- <div class="col-md-12 form-group">
                                <div class="creat_account">
                                    <input type="checkbox" id="f-option2" name="selector">
                                    <label for="f-option2">Запомнить меня</label>
                                </div>
                            </div> --}}
                            <div class="col-md-12 form-group">
                                <button @click.prevent="onSubmit" type="submit" class="primary-btn">Вход</button>
                                <a href="/auth/login/changePassword">Забыли пароль?</a>
                                <div class="col-md-12 form-group bg-danger text-light" v-show="error_text">
                                    @{{error_text}}
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================End Login Box Area =================-->

    <script src="/js/vue/auth/login.js"></script>
@endsection


