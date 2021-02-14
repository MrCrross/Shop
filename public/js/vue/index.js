// Скрипты главной страницы
new Vue({
    el: '#index',
    data: {
        token: localStorage.token || '',
        expires: localStorage.expires || '',
        token_type: 'bearer',
        products: [],
        productsForBanner: [],
        categories: [],
        error: ''
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
                    })
                    .catch(error => {
                        localStorage.removeItem('token')
                        localStorage.removeItem('expires')
                        this.error = error + " REFRESH ME"
                        outError(this.error)
                    })
            }
        }
        const dataProducts = getProducts()
        dataProducts
            .then(res => {
                const dataLastProducts = getProducts(res.last_page_url)
                dataLastProducts
                    .then(res1 => {
                        const latestLength = res1.data.length
                        const bannerLength = 5
                        if (latestLength < 11) {
                            if (latestLength < bannerLength + 1) {
                                for (let i = latestLength - 1; i >= 0; i--) {
                                    this.products.push(res1.data[i])
                                    this.productsForBanner.push(res1.data[i])
                                }
                            } else if (latestLength >= bannerLength + 1) {
                                for (let i = latestLength - 1; i >= 0; i--) {
                                    this.products.push(res1.data[i])
                                }
                                for (let i = latestLength - 1; i >= latestLength - bannerLength - 1; i--) {
                                    this.productsForBanner.push(res1.data[i])
                                }
                            }
                            const dataPrevLastProducts = getProducts(res1.prev_page_url)
                            dataPrevLastProducts
                                .then(res => {
                                    for (let i = res.data.length - 1; i > latestLength - 1; i--) {
                                        this.products.push(res.data[i])
                                    }
                                    const currentBannerLength = this.productsForBanner.length - 1
                                    if (currentBannerLength < bannerLength) {
                                        for (let i = res.data.length - 1; i > res.data.length - latestLength - currentBannerLength - 1; i--) {
                                            this.productsForBanner.push(res.data[i])
                                        }
                                    }
                                })
                                .catch(error => {
                                    this.error = error
                                    outError(this.error)
                                })
                        } else {
                            this.products = res.data
                            for (let i = res.data.length - 1; i > res.data.length - bannerLength - 1; i--) {
                                this.productsForBanner.push(res.data[i])
                            }
                        }
                        const dataCategories = getCategories()
                        dataCategories
                            .then(res => {
                                this.categories = res
                            })
                            .catch(error => {
                                this.error = error
                                outError(this.error)
                            })
                    })
                    .catch(error => {
                        this.error = error
                        outError(this.error)
                    })
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
                    const dataCart = addProductInCart(this.token, this.token_type, product_id)
                    dataCart
                        .then(res => {
                            this.error = 'Товар добавлен в корзину'
                            outError(this.error)
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
                            const dataCart = addProductInCart(this.token, this.token_type, product_id)
                            dataCart
                                .then(res => {
                                    this.error = 'Товар добавлен в корзину'
                                    outError(this.error)
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
                            this.error = 'Товар добавлен в понравившиеся'
                            outError(this.error)
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
                                    this.error = 'Товар добавлен в понравившиеся'
                                    outError(this.error)
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
    }
});