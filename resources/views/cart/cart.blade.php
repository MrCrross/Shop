@extends('layouts.menu')

@section('content')

<!-- Start Banner Area -->
<section class="banner-area organic-breadcrumb">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1>Корзина</h1>
                <nav class="d-flex align-items-center">
                    <a href="/">Главная<span class="lnr lnr-arrow-right"></span></a>
                    <a href="/cart">Корзина<span class="lnr lnr-arrow-right"></span></a>
                </nav>
            </div>
        </div>
    </div>
</section>
<!--================Cart Area =================-->
<section id="cart" class="cart_area">
    <div class="container">
        <div class="cart_inner">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Товар</th>
                            <th scope="col">Цена</th>
                            <th scope="col">Количество</th>
                            <th scope="col">Всего</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for = "product of cart" :id="'productInCart'+product.id">
                            <td>
                                <div class="media">
                                    <div class="d-flex">
                                        <img :src="product.main_img" alt="">
                                    </div>
                                    <div class="media-body">
                                        <p>@{{product.name}}</p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <h5>@{{"P"+product.price}}</h5>
                            </td>
                            <td>
                                <div class="product_count">
                                    <input :id="'sst'+product.id" :oninput="`var amount = document.getElementById('sst`+product.id+`').value; document.getElementById('sum`+product.id+`').innerHTML = 'P'+`+product.price+` * amount;`" type="number" name="qty"  maxlength="12" :value="product.amount" title="Количество:"
                                        class="input-text qty">
                                    {{-- <button :onclick="`var result = document.getElementById('sst`+product.id+`'); var sst = result.value; if( !isNaN( sst )) result.value++;return false;`"
                                        class="increase items-count" type="button"><i class="lnr lnr-chevron-up"></i></button>
                                    <button :onclick="`var result = document.getElementById('sst`+product.id+`'); var sst = result.value; if( !isNaN( sst ) &amp;&amp; sst > 0 ) result.value--;return false;`"
                                        class="reduced items-count" type="button"><i class="lnr lnr-chevron-down"></i></button> --}}
                                </div>
                            </td>
                            <td>
                                <h5 :id="'sum'+product.id" class="sum">@{{"P"+product.amount * product.price}}</h5>
                            </td>
                            <td>
                                <button v-on:click="deleteCart(product.id)" class="btn btn-danger"><i class="lnr lnr-cross"></i></button>
                            </td>
                        </tr>
                        <tr class="bottom_button">
                            <td>
                                <a class="gray_btn" href="/cart">Обновить корзину</a>
                            </td>
                            <td>

                            </td>
                            <td>

                            </td>
                            <td>

                            </td>
                            <td>
                                <div class="cupon_text d-flex align-items-center">
                                    <input type="text" placeholder="Купон">
                                    <a class="primary-btn" href="#">Использовать</a>
                                    <a class="gray_btn" href="#">Закрыть купон</a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>

                            </td>
                            <td>

                            </td>
                            <td>
                                <h5>К оплате:</h5>
                            </td>
                            <td>
                                <h5 id = "totalPay" >@{{"P"+totalPay}}</h5>
                            </td>
                            <td>

                            </td>
                        </tr>
                        {{-- <tr class="shipping_area">
                            <td>

                            </td>
                            <td>

                            </td>
                            <td>
                                <h5>Shipping</h5>
                            </td>
                            <td>
                                <div class="shipping_box">
                                    <ul class="list">
                                        <li><a href="#">Flat Rate: $5.00</a></li>
                                        <li><a href="#">Free Shipping</a></li>
                                        <li><a href="#">Flat Rate: $10.00</a></li>
                                        <li class="active"><a href="#">Local Delivery: $2.00</a></li>
                                    </ul>
                                    <h6>Calculate Shipping <i class="fa fa-caret-down" aria-hidden="true"></i></h6>
                                    <select class="shipping_select">
                                        <option value="1">Bangladesh</option>
                                        <option value="2">India</option>
                                        <option value="4">Pakistan</option>
                                    </select>
                                    <select class="shipping_select">
                                        <option value="1">Select a State</option>
                                        <option value="2">Select a State</option>
                                        <option value="4">Select a State</option>
                                    </select>
                                    <input type="text" placeholder="Postcode/Zipcode">
                                    <a class="gray_btn" href="#">Update Details</a>
                                </div>
                            </td>
                        </tr> --}}
                        <tr class="out_button_area">
                            <td>

                            </td>
                            <td>

                            </td>
                            <td>

                            </td>
                            <td>

                            </td>
                            <td>
                                <div class="checkout_btn_inner d-flex align-items-center">
                                    <a class="gray_btn" href="/shop">Продолжить покупки</a>
                                    <a class="primary-btn" href="/cart/pay">Оплатить</a>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<!--================End Cart Area =================-->

    <script>
        $('document').ready(function(){
            $('.qty').on('change',function(){
            let totalPay = 0
            $('.sum').each(function(){
                let sumProduct= this.innerHTML
                totalPay += parseInt(sumProduct.slice(1,sumProduct.length))
            })
            $('#totalPay')[0].innerHTML = "P"+totalPay
            })
        })
    </script>
    <script src="/js/vue/cart/cart.js"></script>
@endsection


