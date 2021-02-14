// Скрипты страницы Регистрации
new Vue({
    el: '#regForm',
    data: {
        token: localStorage.token || '',
        expires: localStorage.expires || '',
        name: '',
        email: '',
        pass: '',
        pass_conf: '',
        error: ''
    },
    created: function() {
        // Перед тем как пользователь зайдет на страницу регистрации проверяем авторизован ли он
        if (this.token) {
            // а так как обычным путем пользователь не может войти на эту страницу
            // разлогиниваем его

            // const dataLogout = logout(this.token, this.token_type)
            // dataLogout
            //     .then(res => {
            //         localStorage.removeItem('token')
            //         localStorage.removeItem('expires')
            //         window.location = "/"
            //     })
            //     .catch(error => {
            //         window.location = '/'
            //         this.error = error + " LOGOUT"
            //     })

            // Или просто переадресовываем его на главную страницу
            window.location = "/"
        }
    },
    methods: {
        onSubmit: function(e) {
            if (this.pass == this.pass_conf) {
                this.error = ""
                const dataReg = registration(this.name, this.email, this.pass, this.pass_conf)
                dataReg
                    .then(res => {
                        console.log(res)
                        const dataLogin = login(this.email, this.pass)
                        dataLogin
                            .then(res => {
                                console.log(res)
                                localStorage.token = res.access_token
                                localStorage.expires = getDateExpires()
                                window.location = '/'
                            })
                            .catch(error => {
                                this.error = error
                                outError(this.error)
                            })
                    })
                    .catch(error => {
                        if (typeof(error) == 'object') {
                            error.then(error => {
                                this.error = error
                            })
                        } else {
                            this.error = error
                        }
                    })
            } else {
                this.error = "Пароли не совпадают."
                this.pass = ''
                this.pass_conf = ''
            }
        },
    }
});