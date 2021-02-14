@extends('layouts.menu')

@section('content')
<!-- Start Banner Area -->
<section class="banner-area organic-breadcrumb">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1> Профиль</h1>
                <nav class="d-flex align-items-center">
                    <a href="/">Главная<span class="lnr lnr-arrow-right"></span></a>
                    <a href="/profile">Профиль</a>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- End Banner Area -->

<!--================Profile Box Area =================-->
<section id="profile" class="blog_area single-post-area section_gap">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="blog_right_sidebar">
                    <aside :id="'user'+user_id" class="single_sidebar_widget author_widget">
                        <img class="author_img rounded-circle" :src="user_avatar" alt="">
                        <h4>@{{user_name}}</h4>
                        <p>@{{user_email}}</p>
                        <div class="social_icon">
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-twitter"></i></a>
                            <a href="#"><i class="fa fa-github"></i></a>
                            <a href="#"><i class="fa fa-behance"></i></a>
                        </div>
                        {{-- <p>Boot camps have its supporters andit sdetractors. Some people do not understand why you
                            should have to spend money on boot camp when you can get. Boot camps have itssuppor
                            ters andits detractors.</p> --}}
                        <div class="br"></div>
                    </aside>
                </div>
            </div>
            <div class="col-lg-9 posts-list">
                <div class="single-post row">
                    <div class="col-lg-3  col-md-3">
                        <div class="blog_info text-left">
                            <ul class="blog_meta list">
                                <li><a v-on:click="change = change != 1 ? 1: 0;">Изменить пароль<i class="lnr lnr-lock"></i></a></li>
                                <li><a v-on:click="change = change != 2 ? 2: 0;">Изменить почту<i class="lnr lnr-envelope"></i></a></li>
                                <li><a v-on:click="change = change != 3 ? 3: 0;">Понравившиеся<i class="lnr lnr-heart"></i></a></li>
                                <li><a href="/cart">Корзина<i class="lnr lnr-cart"></i></a></li>
                                <li><a href="/profile/tracking">Отследить заказ<i class="lnr lnr-map-marker"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-7 col-md-7 blog_details">
                        <template v-if="change == 1">
                            <div  class="login_form_inner">
                                <h3>Изменить пароль</h3>
                                <form class="row login_form" novalidate="novalidate">
                                    <div class="col-md-12 form-group">
                                        <input type="password" class="form-control" v-model="oldPass" placeholder="Старый пароль" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Старый пароль'">
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <input type="password" class="form-control" v-model="newPass" placeholder="Новый пароль" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Новый пароль'">
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <input type="password" class="form-control" v-model="newPass_Conf" placeholder="Подтвердите новый пароль" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Подтвердите новый пароль'">
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <input type="text" class="form-control" v-model="tokenPass" placeholder="Ваш токен" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Ваш токен'">
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <button @click.prevent="onChangePass" class="primary-btn">Изменить пароль</button>
                                        <div class="col-md-12 form-group bg-danger text-light" v-show="error">
                                            @{{error}}
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </template>
                        <template v-else-if="change == 2">
                            <div class="login_form_inner">
                                <h3>Изменить почту</h3>
                                <form class="row login_form" novalidate="novalidate">
                                    <div class="col-md-12 form-group">
                                        <input type="email" class="form-control" v-model="newEmail" placeholder="Новый Email" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Новый Email'">
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <input type="text" class="form-control" v-model="tokenEmail" placeholder="Ваш токен" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Ваш токен'">
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <button @click.prevent="onChangeEmail" class="primary-btn">Изменить почту</button>
                                        <div class="col-md-12 form-group bg-danger text-light" v-show="error">
                                            @{{error}}
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </template>
                        <template v-else-if="change == 3">

                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--================End Profile Box Area =================-->
    <script src="/js/vue/profile/profile.js"></script>
@endsection
