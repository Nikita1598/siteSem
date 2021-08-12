function open_form() {
    document.getElementById('background_auth_form').style.display = 'block';
}

function open_form_registration() {
    document.getElementById('background_registration_form').style.display = 'block';
}

function close_form() {
    document.getElementById('background_auth_form').style.display = 'none';
}

function close_form_registration() {
    document.getElementById('background_registration_form').style.display = 'none';
}

function auth() {
    let name = document.getElementById('user').value;
    let password = document.getElementById('password').value;
    if (name !== "" || password !== '') {
        $.ajax({
            url: 'auth.php',
            type: 'POST',
            data: ({user: name, password: password}),
            dataType: 'html',
            beforeSend: function () {
                document.getElementById('error_message').style.color = 'black';
                document.getElementById('error_message').innerHTML = "Подождите...";
            },
            success: function (data) {
                if (data.includes('Неверный')) {
                    document.getElementById('error_message').style.color = 'red';
                    document.getElementById('error_message').innerHTML = data;
                } else {
                    document.getElementById('error_message').style.color = 'black';
                    document.getElementById('error_message').innerHTML = 'Успешная авторизация';
                    document.location.href = data;
                }
            }
        })
    } else {
        document.getElementById('error_message').style.color = 'red';
        document.getElementById('error_message').innerHTML = 'Заполните все поля';
    }
}

function registration() {
    let user = document.getElementById('user1').value.trim();
    let password = document.getElementById('password1').value.trim();
    let repeat_password = document.getElementById('repeat_password').value.trim();
    let email = document.getElementById('email').value.trim();
    if (/^[a-zA-Z1-9]+$/.test(user) === false) {
        document.getElementById('error_message_reg').style.color = 'red';
        document.getElementById('error_message_reg').innerHTML = 'Недопустимые символы в логине';
        return false;
    }
    if (user.length < 4 || user.length > 20) {
        document.getElementById('error_message_reg').style.color = 'red';
        document.getElementById('error_message_reg').innerHTML = 'В логине должен быть от 4 до 20 символов';
        return false;
    }
    if (/^[a-zA-Z1-9]+$/.test(password) === false) {
        document.getElementById('error_message_reg').style.color = 'red';
        document.getElementById('error_message_reg').innerHTML = 'Недопустимые символы в пароле';
        return false;
    }
    if (password.length < 4 || password.length > 20) {
        document.getElementById('error_message_reg').style.color = 'red';
        document.getElementById('error_message_reg').innerHTML = 'В пароле должен быть от 4 до 20 символов';
        return false;
    }
    if (user === '' || password === '' || repeat_password === '' || email === '') {
        document.getElementById('error_message_reg').style.color = 'red';
        document.getElementById('error_message_reg').innerHTML = 'Заполните все поля';
    } else {
        if (password !== repeat_password) {
            document.getElementById('error_message_reg').style.color = 'red';
            document.getElementById('error_message_reg').innerHTML = 'Пароли не совпадают';
        } else {
            $.ajax({
                url: 'registration.php',
                type: 'POST',
                data: ({user: user, password: password, email: email}),
                dataType: 'html',
                beforeSend: function () {
                    document.getElementById('error_message_reg').style.color = 'black';
                    document.getElementById('error_message_reg').innerHTML = "Подождите...";
                },
                success: function (data) {
                    if (data.includes('занят')) {
                        document.getElementById('error_message').style.color = 'red';
                        document.getElementById('error_message').innerHTML = data;
                    } else {
                        document.getElementById('error_message').style.color = 'black';
                        document.getElementById('error_message').innerHTML = 'Успешная Регистрация';
                        document.location.href = data;
                    }
                }
            })
        }
    }
}