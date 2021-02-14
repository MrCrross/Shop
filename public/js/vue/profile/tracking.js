// Скрипты страницы отслеживания товара
new Vue({
    el: '#tracking',
    data: {
        token: localStorage.token || '',
        expires: localStorage.expires || '',
        token_type: 'bearer',
        track: '',
        email: '',
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
                        window.location.reload()
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
        onTracking: function() {
            const dataTracking = setTracking(this.track, this.email, this.token, this.token_type)
            dataTracking
                .then(res => {
                    alert(res)
                })
                .catch(error => {
                    this.error = error + " TRACKING"
                    outError(this.error)
                })
        }
    }
});