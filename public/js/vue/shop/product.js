// Скрипты страницы одного продукта
new Vue({
    el: '#product',
    data: {
        token: localStorage.token || '',
        expires: localStorage.expires || '',
        token_type: 'bearer',
        product_id: 0,
        product_name: '',
        desc: '',
        category: '',
        main_img: '',
        price: 0,
        images: [],
        videos: [],
        models: [],
        reviews: [],
        comments: [],
        review_comments: [],
        reply_comments: [],
        details: [],
        avg: '',
        total: 0,
        rating: {},
        error: '',
        newReviewText: '',
        newReviewRating: '',
    },
    created: function() {
        if (this.token) {
            if (!checkExpiresToken(this.expires)) {
                // Если токен не действителен, то запрашиваем обновление
                // и последующее получение данных
                const dataRefresh = refreshToken(this.token, this.token_type)
                dataRefresh
                    .then(res => {
                        localStorage.token = res.access_token
                        localStorage.expires = getDateExpires()
                        this.token = res.access_token
                        this.expires = getDateExpires()
                        this.token_type = res.token_type
                        window.location.reload()
                    })
                    .catch(error => {
                        localStorage.removeItem('token')
                        localStorage.removeItem('expires')
                        this.error = error + " REFRESH ME"
                        outError(this.error)
                    })
            }
        }
        // Перед загрузкой получаем данные о товаре
        // берем id товара из url страницы
        const url = window.location.pathname
        this.product_id = url.slice(url.indexOf('/', 2) + 1, url.length)
            //  и отправляем в запрос
        const dataProduct = getProductData(this.product_id);
        dataProduct
            .then(res => {
                this.product_name = res.name
                this.desc = res.description
                this.main_img = res.main_img
                this.price = res.price
                this.category = res.category.title
                this.models = res.models
                this.reviews = res.reviews
                this.comments = res.comments
                this.images = res.images
                this.videos = res.videos
                for (let i = 0; i < this.comments.length; i++) {
                    if (this.comments[i].reply_review_id != null) { this.comments[i].reply_review = this.comments[i].id } else { this.comments[i].reply_review = 0 }
                    if (this.comments[i].reply_comment_id != null) { this.comments[i].reply_comment = this.comments[i].id } else { this.comments[i].reply_comment = 0 }
                }
                this.details = res.details
            })
            .catch(error => {
                this.error = error
                outError(this.error)
            })

        const dataReviewTotals = getProductTotal(this.product_id);
        dataReviewTotals
            .then(res => {
                this.avg = res.avg
                this.total = res.total
                this.rating = res.ratings_counts
            })
            .catch(error => {
                this.error = error
                outError(this.error)
            })

        const dataReviews = getProductReview(this.product_id);
        dataReviews
            .then(res => {
                this.review_comments = res
                for (let i = 0; i < this.review_comments.length; i++) {
                    switch (this.review_comments[i].rating) {
                        case 1:
                            this.review_comments[i].ratingStars = `<div class='rating-mini'><span class='active'></span><span></span><span></span><span></span><span></span></div>`
                            break
                        case 2:
                            this.review_comments[i].ratingStars = `<div class='rating-mini'><span class='active'></span><span class='active'></span><span></span><span></span><span></span></div>`
                            break
                        case 3:
                            this.review_comments[i].ratingStars = `<div class='rating-mini'><span class='active'></span><span class='active'></span><span class='active'></span><span></span><span></span></div>`
                            break
                        case 4:
                            this.review_comments[i].ratingStars = `<div class='rating-mini'><span class='active'></span><span class='active'></span><span class='active'></span><span class='active'></span><span></span></div>`
                            break
                        case 5:
                            this.review_comments[i].ratingStars = `<div class='rating-mini'><span class='active'></span><span class='active'></span><span class='active'></span><span class='active'></span><span class='active'></span></div>`
                            break
                    }
                }
            })
            .catch(error => {
                this.error = error
                outError(this.error)
            })
    },
    methods: {
        addProductInCart: function(product_id) {
            if (this.token) {
                if (checkExpiresToken(this.expires)) {
                    // Токен жив, поэтому сразу отправляет данные в запрос
                    //Добавляем в корзину
                    const dataCart = addProductInCart(this.token, this.token_type, product_id)
                    dataCart
                        .then(res => {
                            alert('Товар добавлен в корзину')
                        })
                        .catch(error => {
                            this.error = error + " Add In Cart"
                            outError(this.error)
                        })
                } else {
                    // Если токен не действителен, то запрашиваем обновление
                    // и последующее получение данных пользователя
                    const dataRefresh = refreshToken(this.token, this.token_type)
                    dataRefresh
                        .then(res => {
                            localStorage.token = res.access_token
                            localStorage.expires = getDateExpires()
                            this.token = res.access_token
                            this.expires = getDateExpires()
                            this.token_type = res.token_type
                                //Добавляем в корзину
                            const dataCart = addProductInCart(this.token, this.token_type, product_id)
                            dataCart
                                .then(res => {
                                    alert('Товар добавлен в корзину')
                                    window.location.reload()
                                })
                                .catch(error => {
                                    this.error = error + " Add In Cart"
                                    outError(this.error)
                                })
                        })
                        .catch(error => {
                            localStorage.removeItem('token')
                            localStorage.removeItem('expires')
                            this.error = error + " REFRESH ME"
                            outError(this.error)
                        })
                }
            } else {
                window.location = '/auth/login'
            }
        },

        addLikeProductUser: function(product_id) {
            if (this.token) {
                if (checkExpiresToken(this.expires)) {
                    // Токен жив, поэтому сразу отправляет данные в запрос
                    const dataLike = addLikeProductUser(this.token, this.token_type, product_id)
                    dataLike
                        .then(res => {
                            alert('Товар добавлен в понравившиеся')
                        })
                        .catch(error => {
                            this.error = error + " Add In Like"
                            outError(this.error)
                        })
                } else {
                    // Если токен не действителен, то запрашиваем обновление
                    // и последующее получение данных пользователя
                    const dataRefresh = refreshToken(this.token, this.token_type)
                    dataRefresh
                        .then(res => {
                            localStorage.token = res.access_token
                            localStorage.expires = getDateExpires()
                            this.token = res.access_token
                            this.expires = getDateExpires()
                            this.token_type = res.token_type
                            const dataLike = addLikeProductUser(this.token, this.token_type, product_id)
                            dataLike
                                .then(res => {
                                    alert('Товар добавлен в понравившиеся')
                                    window.location.reload()
                                })
                                .catch(error => {
                                    this.error = error + " Add In Like"
                                    outError(this.error)
                                })
                        })
                        .catch(error => {
                            localStorage.removeItem('token')
                            localStorage.removeItem('expires')
                            this.error = error + " REFRESH ME"
                            outError(this.error)
                        })
                }
            } else {
                window.location = '/auth/login'
            }
        },
        getReplyComments: function(comment_id) {
            // if (this.reply_comments.length != 0) {
            //     this.reply_comments = []
            //         // document.getElementById('reply_comments').innerHTML = ''
            // } else {
            const dataReplyComments = getReplyComments(this.product_id, comment_id);
            dataReplyComments
                .then(res => {
                    this.reply_comments = res.reply_comments.data
                    for (let i = 0; i < this.reply_comments.length; i++) {
                        this.reply_comments[i].main_id = comment_id
                    }
                })
                .catch(error => {
                    this.error = error
                    outError(this.error)
                })
                // }
        },
        setNewReview: function() {
            if (this.token) {
                if (checkExpiresToken(this.expires)) {
                    // Токен жив, поэтому сразу отправляет данные в запрос
                    const dataNewReview = setNewReview(this.newReviewText, this.newReviewRating, this.token, this.token_type, this.product_id);
                    dataNewReview
                        .then(res => {
                            this.review_comments.push(res)
                        })
                        .catch(error => {
                            this.error = error
                            outError(this.error)
                        })
                } else {
                    // Если токен не действителен, то запрашиваем обновление
                    // и последующее получение данных пользователя
                    const dataRefresh = refreshToken(this.token, this.token_type)
                    dataRefresh
                        .then(res => {
                            localStorage.token = res.access_token
                            localStorage.expires = getDateExpires()
                            this.token = res.access_token
                            this.expires = getDateExpires()
                            this.token_type = res.token_type
                            const dataNewReview = setNewReview(this.newReviewText, this.newReviewRating, this.token, this.token_type, this.product_id);
                            dataNewReview
                                .then(res => {
                                    this.review_comments.push(res)
                                    window.location.reload()
                                })
                                .catch(error => {
                                    this.error = error
                                    outError(this.error)
                                })
                        })
                        .catch(error => {
                            localStorage.removeItem('token')
                            localStorage.removeItem('expires')
                            this.error = error + " REFRESH ME"
                            outError(this.error)
                        })
                }
            } else {
                window.location = '/auth/login'
            }
        },
    }
});
