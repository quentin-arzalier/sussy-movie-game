$(function(){
    let currPwdValidTimeout = null;
    button.disabled = true;
    $('#validation-list').css('color', 'red');
    const password = $('#password-input');
    const majRegex = /[A-Z]/;
    const minRegex = /[a-z]/;
    const numRegex = /[0-9]/;
    const speRegex = /[!@#$%^&*(),.?":{}|'<>+-]/;
    function handlePasswordChange() {
        button.disabled = !(majRegex.test(password.val()) && minRegex.test(password.val()) && numRegex.test(password.val()) && speRegex.test(password.val()) && (password.val().length >= 8));
        $('#maj-message').css('color', majRegex.test(password.val()) ? 'green' : 'red');
        $('#min-message').css('color', minRegex.test(password.val()) ? 'green' : 'red');
        $('#num-message').css('color', numRegex.test(password.val()) ? 'green' : 'red');
        $('#spe-message').css('color', speRegex.test(password.val()) ? 'green' : 'red');
        $('#nbc-message').css('color', password.val().length >= 8 ? 'green' : 'red');
    }
    password.on('input', () => {
        if (currPwdValidTimeout)
            clearTimeout(currPwdValidTimeout);
        currPwdValidTimeout = setTimeout(() => {
            handlePasswordChange();
        }, 200);
    });
});