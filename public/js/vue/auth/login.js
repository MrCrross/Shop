// Скрипты страницы Входа
new Vue({
    el: '#loginForm',
    data: {
        token: localStorage.token || '',
        expires: localStorage.expires || '',
        token_type: 'bearer',
        email: '',
        pass: '',
        user_id: 0,
        user_name: '',
        user_email: '',
        error_text: ''
    },
    created: function() {
        // Перед тем как пользователь зайдет на страницу входа проверяем авторизован ли он
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
        // Обработчик Входа пользователя
        onSubmit: function(e) {
            const dataLogin = login(this.email, this.pass)
            dataLogin
                .then(res => {
                    localStorage.token = res.access_token
                    localStorage.expires = getDateExpires()
                    window.location = '/'
                })
                .catch(error => {
                    this.error_text = error
                })
        },
    }
});