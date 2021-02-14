@extends('layouts.menu')

@section('content')
<!-- Start Banner Area -->
<section class="banner-area organic-breadcrumb">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1>Отслеживание заказа</h1>
                <nav class="d-flex align-items-center">
                    <a href="/">Главная<span class="lnr lnr-arrow-right"></span></a>
                    <a href="/profile">Профиль<span class="lnr lnr-arrow-right"></span></a>
                    <a href="/profile/tracking">Отслеживание</a>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- End Banner Area -->

<!--================Tracking Box Area =================-->
<section id = "tracking" class="tracking_box_area section_gap">
    <div class="container">
        <div class="tracking_box_inner">
            <p>Чтобы отслеживать свой заказ, введите свой идентификатор заказа в поле ниже и нажмите кнопку «Отследить». Это было указано в квитанции и в электронном письме с подтверждением, которое вы должны были получить. </p>
            <form class="row tracking_form" novalidate="novalidate">
                <div class="col-md-12 form-group">
                    <input type="text" class="form-control" v-model="track" id="order" name="order" placeholder="Трек-номер" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Трек-номер'" required>
                </div>
                <div class="col-md-12 form-group">
                    <input type="email" class="form-control" v-model="email" id="email" name="email" placeholder="Отчет на почту" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Отчет на почту'" required>
                </div>
                <div class="col-md-12 form-group">
                    <button @click.prevent="onTracking" type="submit" value="submit" class="primary-btn">Отследить заказ</button>
                </div>
            </form>
        </div>
    </div>
</section>
<!--================End Tracking Box Area =================-->
    <script src="/js/vue/profile/tracking.js"></script>
@endsection
