/** закрывать при клике вне */
function openPersonPopup() {
    let popupClasses = $("#person-popup").attr('class');
    if (popupClasses.indexOf('no-display') >= 0) {
        $("#person-popup").removeClass('no-display');
    } else {
        $("#person-popup").addClass('no-display');
    }
}

jQuery(function($){
    $(document).mouseup( function(e) {
        var div = $("#person-popup");
        if ( !div.is(e.target) && div.has(e.target).length === 0 ) {
            $("#person-popup").addClass('no-display');
        }
    });
});

function openPage(page) {
    window.location.href = page;
}

function openPopup() {
    $('#add-comment').removeClass('no-display');
}

function openReviewUpdate(id) {
    $(`#review-update${id}`).removeClass('no-display');
}

function openAddReview() {
    $('#add-comment').removeClass('no-display');
}

function openChangeAvatar(){
    $(`#change-avatar-block`).removeClass('no-display');
}

function closePopup() {
    $('#add-comment').addClass('no-display');
    $('#popup-comment').addClass('no-display');
}

function closeReviewPopup(id) {
    $(`#popup-comment${id}`).addClass('no-display');
    $(`#review-update${id}`).addClass('no-display');
}

function closeChangeAvatar(){
    $(`#change-avatar-block`).addClass('no-display');
}

function isAuthorized () {
    setTimeout(function() {
        let authorized = false;
        if (authorized) {
            $('[authorized]').removeClass('no-display');
            $('[not-authorized]').addClass('no-display');
        } else {
            $('[authorized]').addClass('no-display');
            $('[not-authorized]').removeClass('no-display');
        }
    }, 100);
}

function showPassword(element) {
    let show = $(element).attr('class');
    if (show.indexOf('private-off') >= 0) {
        $(element).removeClass('private-off');
    } else {
        $(element).addClass('private-off');
    }
}

function togglePasswordVisibility() {
    const passwordInput = document.getElementById("password");
    const icon = document.querySelector(".password-toggle"); // Находим иконку
    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        icon.classList.add("private-on"); // Меняем иконку на "зачеркнутый глаз"
    } else {
        passwordInput.type = "password";
        icon.classList.remove("private-on");
    }
}

function togglePasswordVisibilityReg() {
    const passwordInput = document.getElementById("password_reg");
    const passwordConfirmationInput = document.getElementById("password_confirmation");
    const icon = document.querySelector(".password-toggle-reg");
    const icon2 = document.querySelector(".password-toggle-reg1");
    if (passwordInput.type === "password" || passwordConfirmationInput.type === "password") {
        passwordInput.type = "text";
        passwordConfirmationInput.type = "text";
        icon.classList.add("private-on");
        icon2.classList.add("private-on");
    } else {
        passwordInput.type = "password";
        passwordConfirmationInput.type = "password";
        icon.classList.remove("private-on");
        icon2.classList.remove("private-on");
    }
}

function togglePasswordVisibilityChange() {
    const passwordInput = document.getElementById("to_change_password");
    const passwordConfirmationInput = document.getElementById("repeat_password");
    const icon = document.querySelector(".password-toggle-change");
    const icon2 = document.querySelector(".password-toggle-repeat");
    if (passwordInput.type === "password" || passwordConfirmationInput.type === "password") {
        passwordInput.type = "text";
        passwordConfirmationInput.type = "text";
        icon.classList.add("private-on");
        icon2.classList.add("private-on");
    } else {
        passwordInput.type = "password";
        passwordConfirmationInput.type = "password";
        icon.classList.remove("private-on");
        icon2.classList.remove("private-on");
    }
}

function changePassValue(element) {
    let passwordFieldValue = element.value;
    document.querySelector('#password_to_check').value = passwordFieldValue;
    return 1;
}

//изменение имя поля при загруженном изображении
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('image');
    const fileNameSpan = document.querySelector('.custom-file-upload-filename');

    if (fileInput && fileNameSpan) {
        fileInput.addEventListener('change', function() {
            if (this.files && this.files.length > 0) {
                const fileName = this.files[0].name;
                fileNameSpan.textContent = fileName;
            } else {
                fileNameSpan.textContent = 'Файл не выбран';
            }
        });
    }
});

document.addEventListener("DOMContentLoaded", function () {
    let authTab = document.getElementById("auth");
    let regTab = document.getElementById("registration");
    let authForm = document.getElementById("auth-data");
    let regForm = document.getElementById("registration-data");

    function switchToAuth() {
        authTab.classList.add("active");
        regTab.classList.remove("active");
        authForm.classList.remove("no-display");
        regForm.classList.add("no-display");
    }

    function switchToReg() {
        regTab.classList.add("active");
        authTab.classList.remove("active");
        regForm.classList.remove("no-display");
        authForm.classList.add("no-display");
    }

    authTab.addEventListener("click", switchToAuth);
    regTab.addEventListener("click", switchToReg);
});

function togglePassword(fieldId) {
    let field = document.getElementById(fieldId);
    field.type = field.type === "password" ? "text" : "password";
}

document.querySelector('.change-pass-btn').addEventListener('click', function(event) {
    event.preventDefault();
    const passwordField = document.querySelector('#user-password');
    const password = passwordField.value;
    
    // Отправляем AJAX-запрос для проверки пароля
    fetch('/user/check-password', {
        method: 'POST',
        headers: { 
            'Content-Type': 'application/x-www-form-urlencoded',
            'Accept': 'application/json' 
        },
        body: new URLSearchParams({ password: password })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Если пароль верный, показываем форму для смены пароля
            document.getElementById('change-password-form').style.display = 'block';
        } else {
            alert('Неверный пароль.');
        }
    })
    .catch(error => console.error('Error:', error));
});