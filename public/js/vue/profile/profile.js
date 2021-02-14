// Скрипты страницы Профиля
new Vue({
    el: '#profile',
    data: {
        token: localStorage.token || '',
        expires: localStorage.expires || '',
        token_type: 'bearer',
        user_id: 0,
        user_name: '',
        user_email: '',
        user_avatar: '',
        change: 0,
        oldPass: '',
        newPass: '',
        newPass_Conf: '',
        tokenPass: '',
        newEmail: '',
        tokenEmail: '',
        error: '',
    },
    created: function() {
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
    methods: {
        onChangePass: function() {
            if (this.newPass == this.newPass_Conf) {
                const dataNewPass = changePass(this.oldPass, this.newPass, this.newPass_Conf, this.tokenPass, this.token, this.token_type)
                dataNewPass
                    .then(res => {
                        if (res.changed) {
                            this.error = 'Пароль изменен успешно'
                            outError(this.error)
                        } else {
                            this.error = 'Отправленный токен не верен. Пароль изменить не удалось!'
                        }
                    })
                    .catch(error => {
                        if (typeof(error) == 'object') {
                            error.then(error => {
                                this.error_text = error
                            })
                        } else {
                            this.error = error + " CHANGE PASSWORD"
                            this.error_text = error + " CHANGE PASSWORD"
                            outError(this.error)
                        }
                    })
            } else {
                this.error_text = "Пароли не совпадают"
                this.newPass = ''
                this.newPass_Conf = ''
            }
        },
        onChangeEmail: function() {
            const dataNewEmail = changeEmail(this.newEmail, this.tokenEmail, this.token, this.token_type)
            dataNewEmail
                .then(res => {
                    if (res.changed) {
                        this.error = 'Почта изменена успешно'
                        outError(this.error)
                    } else {
                        this.error = 'Отправленный токен не верен. Почту изменить не удалось!'
                    }
                })
                .catch(error => {
                    this.error = error + " CHANGE EMAIL"
                    outError(this.error)
                })
        },
    }
});