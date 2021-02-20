// Скрипты страницы Входа
new Vue({
    el: '#cart',
    data: {
        token: localStorage.token || '',
        expires: localStorage.expires || '',
        token_type: 'bearer',
        cart: [],
        totalPay: 0,
        error: ''
    },
    created: function() {
        if (this.token) {
            if (checkExpiresToken(this.expires)) {
                // Токен жив, поэтому сразу отправляет данные в запрос
                //Добавляем в корзину
                const dataCart = getCart(this.token, this.token_type)
                dataCart
                    .then(res => {
                        this.cart = res
                        for (let i = 0; i < res.length; i++) {
                            this.totalPay += res[i].price * res[i].amount
                        }
                    })
                    .catch(error => {
                        this.error = error
                        outError(this.error)
                    })
            } else {
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
                        window.location = ''
                    })
            }
        } else {
            window.location = '/auth/login'
        }
    },
    methods: {
        deleteCart: function(cart_id) {
            const dataCart = deleteCart(cart_id, this.token, this.token_type)
            dataCart
                .then(res => {
                    const dataCart = getCart(this.token, this.token_type)
                    dataCart
                        .then(res => {
                            this.cart = res
                            for (let i = 0; i < res.length; i++) {
                                this.totalPay += res[i].price * res[i].amount
                            }
                        })
                        .catch(error => {
                            this.error = error
                            outError(this.error)
                        })
                    let totalPay = document.getElementById('totalPay')[0].innerHTML
                    document.getElementById('totalPay')[0].innerHTML = totalPay - res.price
                })
                .catch(error => {
                    this.error = error
                    outError(this.error)
                })
        }
    }
});
