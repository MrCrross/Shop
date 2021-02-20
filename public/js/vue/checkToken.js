// Скрипты получения данных пользователя для страниц
// И выхода пользователя
new Vue({
    el: "#header",
    data: {
        token: localStorage.token || '',
        expires: localStorage.expires || '',
        token_type: 'bearer',
        user_name: '',
        user_id: 0,
        user_email: '',
        user_avatar: '',
        error: '',
    },
    created: function() {
        // До загрузки страницы проверяем имеется ли авторизованный пользователь
        // и устарел ли токен в локальном хранилище
        if (this.token) {
            if (checkExpiresToken(this.expires)) {
                // Токен жив, поэтому получаем данные пользователя
                const dataUser = getUserData(this.token, this.token_type)
                dataUser
                    .then(res => {
                        this.user_id = res.id
                        this.user_name = res.name
                        this.user_email = res.email
                        this.user_avatar = res.avatar
                    })
                    .catch(error => {
                        this.error = error + " ME"
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
                        const dataUser = getUserData(this.token, this.token_type)
                        dataUser
                            .then(res => {
                                this.user_id = res.id
                                this.user_name = res.name
                                this.user_email = res.email
                                this.user_avatar = res.avatar
                            })
                            .catch(error => {
                                this.error = error + "ME REFRESH ME"
                            })
                    })
                    .catch(error => {
                        localStorage.removeItem('token')
                        localStorage.removeItem('expires')
                        window.location = ''
                        this.error = error + " REFRESH ME"
                    })
            }
        }
    },
    methods: {
        //  Обработчик Выхода пользователя
        logout: function() {
            // Проверяем жизнь токена
            if (checkExpiresToken(this.expires)) {
                // Токен жив, поэтому разлогиниваем пользователя
                const dataLogout = logout(this.token, this.token_type)
                dataLogout
                    .then(res => {
                        localStorage.removeItem('token')
                        localStorage.removeItem('expires')
                        window.location = "/"
                    })
                    .catch(error => {
                        window.location = '/'
                        this.error = error + " LOGOUT"
                    })

            } else {
                // Токен устарел, поэтому обновляем после чего разлогиниваем
                const dataRefresh = refreshToken(this.token, this.token_type)
                dataRefresh
                    .then(res => {
                        localStorage.token = res.access_token
                        localStorage.expires = getDateExpires()
                        this.token = res.access_token
                        this.expires = getDateExpires()
                        this.token_type = res.token_type
                        const dataLogout = logout(this.token, this.token_type)
                        dataLogout
                            .then(res => {
                                localStorage.removeItem('token')
                                localStorage.removeItem('expires')
                                window.location = '/'
                            })
                            .catch(error => {
                                window.location = '/'
                                this.error = error + " LOGOUT REFRESH LOGOUT"
                            })

                    })
                    .catch(error => {
                        localStorage.removeItem('token')
                        localStorage.removeItem('expires')
                        window.location = ''
                        this.error = error + " LOGOUT REFRESH"
                    })
            }
        },
        closeError: function() {
            this.error = ""
            document.getElementById('modal_errors').style.display = 'none'
        }
    }
})
