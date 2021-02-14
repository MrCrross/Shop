@extends('layouts.menu')

@section('content')

<div id ="product">
<!-- Start Banner Area -->
<section class="banner-area organic-breadcrumb">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1>Магазин</h1>
                <nav class="d-flex align-items-center">
                    <a href="/">Главная<span class="lnr lnr-arrow-right"></span></a>
                    <a href="/shop">Магазин<span class="lnr lnr-arrow-right"></span></a>
                    {{-- <a :href="'/shop/'+product.id">Магазин<span class="lnr lnr-arrow-right"></span></a> --}}
                </nav>
            </div>
        </div>
    </div>
</section>
<!--================Single Product Area =================-->
<div class="product_image_area">
    <div class="container">
        <div class="row s_product_inner">
            <div class="col-lg-6">
                <div class="s_Product_carousel">
                    <div class="single-prd-item">
                        <img class="img-fluid" :src="main_img" alt="">
                    </div>
                    <div v-for="image of images" class="single-prd-item">
                        <img class="img-fluid" :src="image.path" alt="">
                    </div>
                    <div v-for="video of videos" class="single-prd-item">
                        <video class="img-fluid" controls="controls" :poster="main_img">
                            <source :src="video.path" type='video/mp4; codecs="avc1.42E01E, mp4a.40.2"'>
                        </video>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 offset-lg-1">
                <div class="s_product_text">
                    <h3>@{{product_name}}</h3>
                    <h2>@{{price}}</h2>
                    <ul class="list">
                        <li><a class="active" href="#"><span>Категории :</span>@{{category}}</a></li>
                        <li><a href="#"><span>Имеется</span> Но это не точно</a></li>
                    </ul>
                    <p>@{{desc}}</p>
                    <div class="product_count">
                        <label for="qty">Количество:</label>
                        <input type="text" name="qty" id="sst" maxlength="12" value="1" title="Количество:" class="input-text qty">
                        <button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst )) result.value++;return false;"
                         class="increase items-count" type="button"><i class="lnr lnr-chevron-up"></i></button>
                        <button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst ) &amp;&amp; sst > 0 ) result.value--;return false;"
                         class="reduced items-count" type="button"><i class="lnr lnr-chevron-down"></i></button>
                    </div>
                    <div class="card_area d-flex align-items-center">
                        <a v-on:click="addProductInCart(product_id)" class="primary-btn" >В корзину</a>
                        <a class="icon_btn"><i class="lnr lnr lnr-diamond"></i></a>
                        <a v-on:click="addLikeProductUser(product_id)" class="icon_btn"><i class="lnr lnr lnr-heart"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--================End Single Product Area =================-->

<!--================Product Description Area =================-->
<section class="product_description_area">
    <div class="container">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Описание</a>
            </li>
            {{-- <li class="nav-item">
                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile"
                 aria-selected="false">Характеристики</a>
            </li> --}}
            <li class="nav-item">
                <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact"
                 aria-selected="false">Комментарии</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" id="review-tab" data-toggle="tab" href="#review" role="tab" aria-controls="review"
                 aria-selected="false">Обзоры</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade" id="home" role="tabpanel" aria-labelledby="home-tab">
                @{{desc}}
            </div>
            {{-- <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <div class="table-responsive">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>
                                    <h5>Width</h5>
                                </td>
                                <td>
                                    <h5>128mm</h5>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h5>Height</h5>
                                </td>
                                <td>
                                    <h5>508mm</h5>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h5>Depth</h5>
                                </td>
                                <td>
                                    <h5>85mm</h5>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h5>Weight</h5>
                                </td>
                                <td>
                                    <h5>52gm</h5>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h5>Quality checking</h5>
                                </td>
                                <td>
                                    <h5>yes</h5>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h5>Freshness Duration</h5>
                                </td>
                                <td>
                                    <h5>03days</h5>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h5>When packeting</h5>
                                </td>
                                <td>
                                    <h5>Without touch of hand</h5>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h5>Each Box contains</h5>
                                </td>
                                <td>
                                    <h5>60pcs</h5>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div> --}}
            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="comment_list">
                            <div v-for="comment of comments" class="review_item">
                                <div class="media">
                                    <div class="d-flex">
                                        <img src="/img/product/review-1.png" alt="">
                                    </div>
                                    <div class="media-body">
                                        <h4>Blake Ruiz</h4>
                                        <h5>12th Feb, 2018 at 05:56 pm</h5>
                                        <a v-on:click="getReplyComments(comment.id)" class="reply_btn">Reply</a>
                                    </div>
                                </div>
                                <p>@{{comment.text}}</p>
                                <div v-for="reply_comment of reply_comments" v-show="reply_comments" class="review_item reply">
                                    <template v-if="comment.reply_comment == reply_comment.main_id">
                                            <div class="media">
                                                <div class="d-flex">
                                                    <img src="/img/product/review-2.png" alt="">
                                                </div>
                                                <div class="media-body">
                                                    <h4>Blake Ruiz</h4>
                                                    <h5>12th Feb, 2018 at 05:56 pm</h5>
                                                    <a v-on:click="getReplyComments(reply_comment.id)" class="reply_btn">Reply</a>
                                                </div>
                                            </div>
                                            <p>@{{reply_comment.text}}</p>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="col-lg-6">
                        <div class="review_box">
                            <h4>Post a comment</h4>
                            <form class="row contact_form" novalidate="novalidate">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="name_comment" name="name" placeholder="Your Full name">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="email" class="form-control" id="email_comment" name="email" placeholder="Email Address">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="number_comment" name="number" placeholder="Phone Number">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <textarea class="form-control" name="message" id="message_comment" rows="1" placeholder="Message"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 text-right">
                                    <button type="submit" value="submit" class="btn primary-btn">Submit Now</button>
                                </div>
                            </form>
                        </div>
                    </div> --}}
                </div>
            </div>
            <div class="tab-pane fade show active" id="review" role="tabpanel" aria-labelledby="review-tab">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="row total_rate">
                            <div class="col-6">
                                <div class="box_total">
                                    <h5>Срений балл</h5>
                                    <h4>@{{avg}}</h4>
                                    <h6>(@{{total}} отзыва)</h6>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="rating_list">
                                    <h3>На основе @{{total}} отзывов</h3>
                                    <ul class="list">
                                        <li>
                                            <a href="#">5 Star
                                                <div class="rating-mini">
                                                    <span class="active"></span>
                                                    <span class="active"></span>
                                                    <span class="active"></span>
                                                    <span class="active"></span>
                                                    <span class="active"></span>
                                                </div>
                                                @{{rating["5"]}}
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">4 Star
                                                <div class="rating-mini">
                                                    <span class="active"></span>
                                                    <span class="active"></span>
                                                    <span class="active"></span>
                                                    <span class="active"></span>
                                                    <span ></span>
                                                </div>
                                                @{{rating["4"]}}
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">3 Star
                                                <div class="rating-mini">
                                                    <span class="active"></span>
                                                    <span class="active"></span>
                                                    <span class="active"></span>
                                                    <span></span>
                                                    <span></span>
                                                </div>
                                                @{{rating["3"]}}
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">2 Star
                                                <div class="rating-mini">
                                                    <span class="active"></span>
                                                    <span class="active"></span>
                                                    <span></span>
                                                    <span></span>
                                                    <span></span>
                                                </div>
                                                @{{rating["2"]}}
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">1 Star
                                                <div class="rating-mini">
                                                    <span class="active"></span>
                                                    <span></span>
                                                    <span></span>
                                                    <span></span>
                                                    <span></span>
                                                </div>
                                                @{{rating["1"]}}
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="review_list">
                            <div v-for="review_comment of review_comments" class="review_item">
                                <div class="media">
                                    <div class="d-flex">
                                        <img src="/img/product/review-1.png" alt="">
                                    </div>
                                    <div class="media-body">
                                        <h4>Blake Ruiz</h4>
                                        <div v-html="review_comment.ratingStars"></div>
                                        <a v-on:click="getReplyComments(review_comment.id)" class="reply_btn">Reply</a>
                                    </div>
                                </div>
                                <p>@{{review_comment.text}}</p>
                                    <div v-for="reply_comment of reply_comments" v-show="reply_comments" class="review_item reply">
                                        <template v-if="review_comment.id == reply_comment.main_id">
                                                <div class="media">
                                                    <div class="d-flex">
                                                        <img src="/img/product/review-2.png" alt="">
                                                    </div>
                                                    <div class="media-body">
                                                        <h4>Blake Ruiz</h4>
                                                        <h5>12th Feb, 2018 at 05:56 pm</h5>
                                                        <a v-on:click="getReplyComments(reply_comment.id)" class="reply_btn">Reply</a>
                                                    </div>
                                                </div>
                                                <p>@{{reply_comment.text}}</p>
                                        </template>
                                    </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="review_box">
                            <h4>Оставить отзыв</h4>
                            <p>Ваша оценка:</p>
                            <form class="row contact_form" id="reviewForm" novalidate="novalidate">
                            <div  class="rating-area">
                                <input type="radio" id="star-5" v-model="newReviewRating" name="rating" value="5">
                                <label for="star-5" title="Оценка «5»"></label>
                                <input type="radio" id="star-4" v-model="newReviewRating" name="rating" value="4">
                                <label for="star-4" title="Оценка «4»"></label>
                                <input type="radio" id="star-3" v-model="newReviewRating" name="rating" value="3">
                                <label for="star-3" title="Оценка «3»"></label>
                                <input type="radio" id="star-2" v-model="newReviewRating" name="rating" value="2">
                                <label for="star-2" title="Оценка «2»"></label>
                                <input type="radio" id="star-1" v-model="newReviewRating" name="rating" value="1">
                                <label for="star-1" title="Оценка «1»"></label>
                            </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <textarea class="form-control" v-model="newReviewText" name="message" id="message" rows="1" placeholder="Отзыв" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Отзыв'"></textarea></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 text-right">
                                    <button @click.prevent="setNewReview" class="primary-btn">Отправить</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--================End Product Description Area =================-->

<!-- Start related-product Area -->
<section class="related-product-area section_gap_bottom">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 text-center">
                <div class="section-title">
                    <h1>Deals of the Week</h1>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore
                        magna aliqua.</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-9">
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-6 mb-20">
                        <div class="single-related-product d-flex">
                            <a href="#"><img src="/img/r1.jpg" alt=""></a>
                            <div class="desc">
                                <a href="#" class="title">Black lace Heels</a>
                                <div class="price">
                                    <h6>$189.00</h6>
                                    <h6 class="l-through">$210.00</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 mb-20">
                        <div class="single-related-product d-flex">
                            <a href="#"><img src="/img/r2.jpg" alt=""></a>
                            <div class="desc">
                                <a href="#" class="title">Black lace Heels</a>
                                <div class="price">
                                    <h6>$189.00</h6>
                                    <h6 class="l-through">$210.00</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 mb-20">
                        <div class="single-related-product d-flex">
                            <a href="#"><img src="/img/r3.jpg" alt=""></a>
                            <div class="desc">
                                <a href="#" class="title">Black lace Heels</a>
                                <div class="price">
                                    <h6>$189.00</h6>
                                    <h6 class="l-through">$210.00</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 mb-20">
                        <div class="single-related-product d-flex">
                            <a href="#"><img src="/img/r5.jpg" alt=""></a>
                            <div class="desc">
                                <a href="#" class="title">Black lace Heels</a>
                                <div class="price">
                                    <h6>$189.00</h6>
                                    <h6 class="l-through">$210.00</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 mb-20">
                        <div class="single-related-product d-flex">
                            <a href="#"><img src="/img/r6.jpg" alt=""></a>
                            <div class="desc">
                                <a href="#" class="title">Black lace Heels</a>
                                <div class="price">
                                    <h6>$189.00</h6>
                                    <h6 class="l-through">$210.00</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 mb-20">
                        <div class="single-related-product d-flex">
                            <a href="#"><img src="/img/r7.jpg" alt=""></a>
                            <div class="desc">
                                <a href="#" class="title">Black lace Heels</a>
                                <div class="price">
                                    <h6>$189.00</h6>
                                    <h6 class="l-through">$210.00</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6">
                        <div class="single-related-product d-flex">
                            <a href="#"><img src="/img/r9.jpg" alt=""></a>
                            <div class="desc">
                                <a href="#" class="title">Black lace Heels</a>
                                <div class="price">
                                    <h6>$189.00</h6>
                                    <h6 class="l-through">$210.00</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6">
                        <div class="single-related-product d-flex">
                            <a href="#"><img src="/img/r10.jpg" alt=""></a>
                            <div class="desc">
                                <a href="#" class="title">Black lace Heels</a>
                                <div class="price">
                                    <h6>$189.00</h6>
                                    <h6 class="l-through">$210.00</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6">
                        <div class="single-related-product d-flex">
                            <a href="#"><img src="/img/r11.jpg" alt=""></a>
                            <div class="desc">
                                <a href="#" class="title">Black lace Heels</a>
                                <div class="price">
                                    <h6>$189.00</h6>
                                    <h6 class="l-through">$210.00</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="ctg-right">
                    <a href="#" target="_blank">
                        <img class="img-fluid d-block mx-auto" src="/img/category/c5.jpg" alt="">
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
</div>
<!-- End related-product Area -->

    <script src="/js/vue/shop/product.js"></script>
@endsection


