// Скрипты страницы Магазин
new Vue({
    el: '#shop',
    data: {
        token: localStorage.token || '',
        expires: localStorage.expires || '',
        token_type: 'bearer',
        products: [],
        categories: [],
        filters: [],
        numPages: [],
        first_page: '',
        prev_page: '',
        next_page: '',
        last_page: '',
        product: '',
        error: '',
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
                        window.location = ''
                    })
            }
        }
        // Перед загрузкой получаем данные о товарах
        const dataProducts = getProducts();
        dataProducts
            .then(res => {
                this.products = res.data
                for (let i = 1; i <= res.last_page; i++) {
                    this.numPages.push({
                        'id': i,
                        'link': '/api/v1/products?page=' + i,
                        'active': i == res.current_page ? 'active' : ''
                    })
                }
                for (let i = 0; i < res.links.length; i++) {
                    if (res.links[i].url === null) {
                        res.links[i].url = '/api/v1/products?page=1'
                    }
                }
                this.links = res.links
                this.first_page = res.first_page_url
                this.last_page = res.last_page_url

            })
            .catch(error => {
                this.error = error
                outError(this.error)
            })
        const dataCategories = getCategories();
        dataCategories
            .then(res => {
                this.categories = res
            })
            .catch(error => {
                this.error = error
                outError(this.error)
            })
    },
    methods: {
        // Обработчик получения данных по страницам
        getPage: function(page) {
            let dataProducts = {}
                // проверяем является ли полученные данные ссылкой
            if (!this[page]) {
                dataProducts = getProducts(page);
            } else {
                dataProducts = getProducts(this[page].url);
            }
            dataProducts
                .then(res => {
                    this.products = res.data
                    this.numPages = []
                    for (let i = 1; i <= res.last_page; i++) {
                        this.numPages.push({
                            'id': i,
                            'link': '/api/v1/products?page=' + i,
                            'active': i == res.current_page ? 'active' : ''
                        })
                    }
                    // Если понадобиться кнопки на прошлую и следующую страницу
                    for (let i = 0; i < res.links.length; i++) {
                        if (res.links[i].url === null) {
                            res.links[i].url = '/api/v1/products?page=1'
                        }
                    }
                    this.prev_page = res.links[0]
                    this.next_page = res.links[2]
                    this.first_page = res.first_page_url
                    this.last_page = res.last_page_url
                })
                .catch(error => {
                    this.error = error
                    outError(this.error)
                })
        },

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
                            window.location = ''
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
                            window.location = ''
                        })
                }
            } else {
                window.location = '/auth/login'
            }
        },
    }
});
