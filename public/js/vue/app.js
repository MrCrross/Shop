// Вывод в окно ошибокS
function outError(error) {
    document.getElementById('modal_errors').style.display = 'block'
    document.getElementById('modal_errors-text').innerHTML = error
}

// Парсинг даты для таймера
function getTimer(dateTimer) {
    let seconds = parseInt((dateTimer / 1000) % 60)
    let minutes = parseInt((dateTimer / (1000 * 60)) % 60)
    let hours = parseInt((dateTimer / (1000 * 60 * 60)) % 24)
    let days = parseInt(dateTimer / (1000 * 60 * 60 * 24))
    hours = (hours < 10) ? "0" + hours : hours
    minutes = (minutes < 10) ? "0" + minutes : minutes
    seconds = (seconds < 10) ? "0" + seconds : seconds
    document.getElementById('days').innerHTML = days
    document.getElementById('hours').innerHTML = hours
    document.getElementById('minutes').innerHTML = minutes
    document.getElementById('seconds').innerHTML = seconds
}

//  Вспомогательные функции в проверке токена

if (localStorage.token) {
    if (!checkExpiresToken(localStorage.expires)) timerRefreshToken(localStorage.token, 'bearer')
}

// Проверка на жизнь токена каждую минуту для последующего обновления токена

setInterval(function() {
    if (localStorage.token) {
        if (!checkExpiresToken(localStorage.expires)) timerRefreshToken(localStorage.token, 'bearer')
    }
}, 60000)

// Проверка времени жизни токена с текущим

function checkExpiresToken(expires) {
    return flag = expires > getDateNow() ? true : false
}

// Получить текущее время

function getDateNow() {
    return new Date().getTime()
}

// Задать срок жизни токена

function getDateExpires() {
    return new Date().getTime() + 900000
}

// Обновление токена в Локальном хранилище

function timerRefreshToken(token, token_type) {
    const dataRefresh = refreshToken(token, token_type)
    dataRefresh
        .then(res => {
            localStorage.token = res.access_token
            localStorage.expires = getDateExpires()
        })
        .catch(error => {
            localStorage.removeItem('token')
            localStorage.removeItem('expires')
            console.log(error + " REFRESH ME")
        })
}

//  Начала функций связанных с авторизацией и токеном

// Запрос к БД для регистрации пользователя

function registration(name, email, pass, pass_conf) {
    return fetch('/api/v1/users', {
        method: 'POST',
        headers: {
            Accept: 'application/json',
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            name: name,
            email: email,
            password: pass,
            password_confirmation: pass_conf
        })
    }).then(res => {
        if (res.ok) {
            return res.json()
        } else if (res.status = 422) {
            let error = res.json().then(res1 => {
                let error = ''
                if (res1.errors.email) { error += res1.errors.email[0] + `\n` }
                if (res1.errors.password) { error += res1.errors.password[0] + `\n` }
                return error
            })
            throw error
        } else if (res.status != 500) {
            const error = 'Не вышло зарегистрироваться. Проверьте правильность заполнение полей.'
            throw error
        } else if (res.status == 500) {
            const error = "Сервер не отвечает"
            throw error
        }
    })
}

// Запрос на вход пользователя

function login(email, password) {
    return fetch('/api/v1/auth/login', {
            method: 'POST',
            headers: {
                Accept: 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                email: email,
                password: password
            })
        })
        .then(res => {
            if (res.ok) {
                return res.json()
            } else if (res.status != 500) {
                const error = 'Неправильный логин или пароль!'
                throw error
            } else if (res.status == 500) {
                const error = "Сервер не отвечает"
                throw error
            }
        })
}

// Запрос на выход пользователя

function logout(token, token_type) {
    return fetch('/api/v1/auth/logout', {
            method: 'POST',
            headers: {
                Accept: 'application/json',
                'Content-Type': 'application/json',
                Authorization: token_type + ' ' + token
            },
        })
        .then(res => {
            if (res.ok) {
                return res.json()
            } else if (res.status != 500) {
                const error = 'Нет авторизованного пользователя с таким токеном.'
                throw error
            } else if (res.status == 500) {
                const error = "Сервер не отвечает"
                throw error
            }
        })
}

// Запрос на данные пользователя

function getUserData(token, token_type) {
    return fetch('/api/v1/auth/me', {
            method: 'GET',
            headers: {
                Accept: 'application/json',
                'Content-Type': 'application/json',
                Authorization: token_type + ' ' + token
            },
        })
        .then(res => {
            if (res.ok) {
                return res.json()
            } else if (res.status != 500) {
                const error = "Пользователя с таким токеном не существует. Попробуйте обновить токен."
                throw error
            } else if (res.status == 500) {
                const error = "Сервер не отвечает"
                throw error
            }
        })
}

// Запрос на обновление токена
function refreshToken(token, token_type) {
    return fetch('/api/v1/auth/refresh', {
            method: 'POST',
            headers: {
                Accept: 'application/json',
                'Content-Type': 'application/json',
                Authorization: token_type + ' ' + token
            },
        })
        .then(res => {
            if (res.ok) {
                return res.json()
            } else if (res.status != 500) {
                const error = "Невозможно обновить токен."
                throw error
            } else if (res.status == 500) {
                const error = "Сервер не отвечает"
                throw error
            }
        })
}

//  Конец функций связанных с авторизацией и токеном

// Начала функций связанных с товаром

// Запрос на получение продуктов одной страницы
function getProducts(page = '/api/v1/products') {
    return fetch(page, {
        method: 'GET',
        headers: {
            Accept: 'application/json',
            'Content-Type': 'application/json',
        },
    }).then(res => {
        if (res.ok) {
            return res.json()
        } else if (res.status != 500) {
            const error = "Невозможно получить товары."
            throw error
        } else if (res.status == 500) {
            const error = "Сервер не отвечает"
            throw error
        }
    })
}

// Запрос на получение категорий
function getCategories() {
    return fetch('/api/v1/categories', {
        method: 'GET',
        headers: {
            Accept: 'application/json',
            'Content-Type': 'application/json'
        },
    }).then(res => {
        if (res.ok) {
            return res.json()
        } else if (res.status != 500) {
            const error = "Категории пусты"
            throw error
        } else if (res.status == 500) {
            const error = "Сервер не отвечает"
            throw error
        }
    })
}

// Запрос на получение данных продукта
function getProductData(product_id) {
    return fetch('/api/v1/products/' + product_id, {
        method: 'GET',
        headers: {
            Accept: 'application/json',
            'Content-Type': 'application/json',
        },
    }).then(res => {
        if (res.ok) {
            return res.json()
        } else if (res.status != 500) {
            const error = "Такого товара нет."
            throw error
        } else if (res.status == 500) {
            const error = "Сервер не отвечает"
            throw error
        }
    })
}

// Запрос на получение комментариев комментария
function getReplyComments(product_id, comment_id) {
    return fetch('/api/v1/products/' + product_id + '/comments/' + comment_id, {
        method: 'GET',
        headers: {
            Accept: 'application/json',
            'Content-Type': 'application/json',
        },
    }).then(res => {
        if (res.ok) {
            return res.json()
        } else if (res.status != 500) {
            const error = "У этого пользователя или товара не комментариев."
            throw error
        } else if (res.status == 500) {
            const error = "Сервер не отвечает"
            throw error
        }
    })
}

// Запрос на получение рейтинга продукта
function getProductTotal(product_id) {
    return fetch('/api/v1/products/' + product_id + '/reviews/totals', {
        method: 'GET',
        headers: {
            Accept: 'application/json',
            'Content-Type': 'application/json',
        },
    }).then(res => {
        if (res.ok) {
            return res.json()
        } else if (res.status != 500) {
            const error = "У этого товара нет оценок"
            throw error
        } else if (res.status == 500) {
            const error = "Сервер не отвечает"
            throw error
        }
    })
}

// Запрос на получение отзывов продукта
function getProductReview(product_id) {
    return fetch('/api/v1/products/' + product_id + '/reviews/', {
        method: 'GET',
        headers: {
            Accept: 'application/json',
            'Content-Type': 'application/json',
        },
    }).then(res => {
        if (res.ok) {
            return res.json()
        } else if (res.status != 500) {
            const error = "У этого товара нет отзывов"
            throw error
        } else if (res.status == 500) {
            const error = "Сервер не отвечает"
            throw error
        }
    })
}

// Запрос на добавление нового отзыва
function setNewReview(text, rating, token, token_type, product_id) {
    return fetch('/api/v1/products/' + product_id + '/reviews/', {
        method: 'POST',
        headers: {
            Accept: 'application/json',
            'Content-Type': 'application/json',
            Authorization: token_type + ' ' + token
        },
        body: JSON.stringify({
            text: text,
            rating: rating
        })
    }).then(res => {
        if (res.ok) {
            try {
                JSON.parse(res)
            } catch (e) {
                const error = 'Ошибка авторизации'
                throw error
            }
            return res.json()
        } else if (res.status != 500) {
            const error = "В данный момент невохможно к этому товару оставить отзыв"
            throw error
        } else if (res.status == 500) {
            const error = "Сервер не отвечает"
            throw error
        }
    })
}
// // Запрос на добавление нового комментария
// function setNewComment(text, token, token_type, product_id) {
//     return fetch('/api/v1/products/' + product_id + '/comments/', {
//         method: 'POST',
//         headers: {
//             Accept: 'application/json',
//             'Content-Type': 'application/json',
//             Authorization: token_type + ' ' + token
//         },
//         body: JSON.stringify({
//             text: text,
//         })
//     }).then(res => {
//         if (res.ok) {
//             return res.json()
//         } else if (res.status != 500) {
//             const error = "У этого товара нет отзывов"
//             throw error
//         } else if (res.status == 500) {
//             const error = "Сервер не отвечает"
//             throw error
//         }
//     })
// }
// Запрос на добавление продукта в корзину
function addProductInCart(token, token_type, product_id, amount = 1) {
    return fetch('/api/v1/products/' + product_id + '/carts', {
        method: 'POST',
        headers: {
            Accept: 'application/json',
            'Content-Type': 'application/json',
            Authorization: token_type + ' ' + token
        },
        body: JSON.stringify({
            amount: amount
        })
    }).then(res => {
        if (res.ok) {
            return res.json()
        } else if (res.status != 500) {
            const error = "Невозможно добавить товар в корзину."
            throw error
        } else if (res.status == 500) {
            const error = "Сервер не отвечает"
            throw error
        }
    })
}

// Запрос на добавление товара в понравившиеся
function addLikeProductUser(token, token_type, product_id) {
    return fetch('/api/v1/products/' + product_id + '/like', {
        method: 'POST',
        headers: {
            Accept: 'application/json',
            'Content-Type': 'application/json',
            Authorization: token_type + ' ' + token
        },
        body: JSON.stringify({
            id: product_id
        })
    }).then(res => {
        if (res.ok) {
            return res.json()
        } else if (res.status != 500) {
            const error = "Невозможно добавить товар в понравившиеся."
            throw error
        } else if (res.status == 500) {
            const error = "Сервер не отвечает"
            throw error
        }
    })
}

// Конец функций связанных с товаром

// Начала функций связанных с корзиной

// Запрос на получение данных корзины

function getCart(token, token_type) {
    return fetch('/api/v1/carts', {
        method: 'GET',
        headers: {
            Accept: 'application/json',
            'Content-Type': 'application/json',
            Authorization: token_type + ' ' + token
        },
    }).then(res => {
        if (res.ok) {
            return res.json()
        } else if (res.status != 500) {
            const error = "Корзина пустая"
            throw error
        } else if (res.status == 500) {
            const error = "Сервер не отвечает"
            throw error
        }
    })
}

// Запрос на удаление товара из корзины

function deleteCart(cart_id, token, token_type) {
    return fetch('/api/v1/carts/' + cart_id, {
        method: 'DELETE',
        headers: {
            Accept: 'application/json',
            'Content-Type': 'application/json',
            Authorization: token_type + ' ' + token
        },
    }).then(res => {
        if (res.ok) {
            return res.json()
        } else if (res.status != 500) {
            const error = "Удаление товара невозможно"
            throw error
        } else if (res.status == 500) {
            const error = "Сервер не отвечает"
            throw error
        }
    })
}

// Конец функций связанных с корзиной

// Начало функций связанных с профилем

// Изменить пароль на странице профиля

function changePass(oldPass, newPass, newPass_Conf, tokenPass, token, token_type) {
    return fetch('/api/v1/security/password', {
        method: 'PUT',
        headers: {
            Accept: 'application/json',
            'Content-Type': 'application/json',
            Authorization: token_type + ' ' + token
        },
        body: JSON.stringify({
            old_password: oldPass,
            new_password: newPass,
            new_password_confirmation: newPass_Conf,
            token: tokenPass
        })
    }).then(res => {
        if (res.ok) {
            return res.json()
        } else if (res.status = 422) {
            let error = res.json().then(res1 => {
                let error = ''
                if (res1.errors.checked_password) { error += `Старый пароль введен неверно. \n` }
                if (res1.errors.new_password) { error += `Новый пароль должен иметь минимум 8 символов.\n` }
                return error
            })
            throw error
        } else if (res.status != 500) {
            const error = "Не удалось изменить пароль"
            throw error
        } else if (res.status == 500) {
            const error = "Сервер не отвечает"
            throw error
        }

    })
}

// Изменить почты на странице профиля

function changeEmail(newEmail, tokenEmail, token, token_type) {
    return fetch('/api/v1/security/email', {
        method: 'PUT',
        headers: {
            Accept: 'application/json',
            'Content-Type': 'application/json',
            Authorization: token_type + ' ' + token
        },
        body: JSON.stringify({
            email: newEmail,
            token: tokenEmail
        })
    }).then(res => {
        if (res.ok) {
            return res.json()
        } else if (res.status = 422) {
            let error = res.json().then(res1 => {
                let error = ''
                if (res1.errors.email) { error += `Email не верен. \n` }
                // if (res1.errors.new_password) { error += `Новый пароль должен иметь минимум 8 символов.\n` }
                return error
            })
            throw error
        } else if (res.status != 500) {
            const error = "Не удалось изменить почту"
            throw error
        } else if (res.status == 500) {
            const error = "Сервер не отвечает"
            throw error
        }
    })
}

// Отслеживание по трек-номеру на странице профиля

function setTracking(track, email, token, token_type) {
    return fetch('/api/v1/tracking', {
        method: 'POST',
        headers: {
            Accept: 'application/json',
            'Content-Type': 'application/json',
            Authorization: token_type + ' ' + token
        },
        body: JSON.stringify({
            track: track,
            email: email
        })
    }).then(res => {
        if (res.ok) {
            return res.json()
        } else if (res.status != 500) {
            const error = "Трек номер не существует"
            throw error
        } else if (res.status == 500) {
            const error = "Сервер не отвечает"
            throw error
        }
    })
}

// Конец функций связанных с профилем