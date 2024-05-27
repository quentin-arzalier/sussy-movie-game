<form action="/user/create" method="post" class='container'>
    <div class="custom-input">
        <label for="username-input">
            <i class="fa-solid fa-user"></i>
        </label>
        <input id="username-input" type="text" name="username" placeholder="Nom d'utilisateur" required>
    </div>
    <div class="custom-input">
        <label for="email-input">
            <i class="fa-solid fa-envelope"></i>
        </label>
        <input id="email-input" type="email" name="email" placeholder="Adresse mail" required>
    </div>
    <div class="custom-input">
        <label for="password-input">
            <i class="fa-solid fa-key"></i>
        </label>
        <input id="password-input" type="password" name="password" placeholder="Mot de passe" required>
    </div>
    <div>
        <span>Pour être valide, le mot de passe doit contenir au moins :</span>
        <ul id='validation-list'>
            <li id='maj-message'>une lettre majuscule</li>
            <li id='min-message'>une lettre minuscule</li>
            <li id='num-message'>un chiffre</li>
            <li id='spe-message'>un caractère spécial</li>
            <li id='nbc-message'>8 caractères</li>
        </ul>
    </div>
    <div class="custom-input">
        <label for="password-confirm-input">
            <i class="fa-solid fa-key"></i>
        </label>
        <input id="password-confirm-input" type="password" name="password_confirm" placeholder="Confirmation du mot de passe" required>
    </div>
    <input id="button" type="submit" value="créer">
</form>
<div>
    <p>
        <?php 
        if (isset($_SESSION['message'])) {
            echo $_SESSION['message'];
            unset($_SESSION['message']);
        }
        ?>
    </p>
</div>

<script>
$(function(){
    let currPwdValidTimeout = null;
    button.disabled = true;
    $('#validation-list').css('color', 'red');
    const password = $('#password-input');
    const majRegex = /[A-Z]/;
    const minRegex = /[a-z]/;
    const numRegex = /[0-9]/;
    const speRegex = /[!@#$%^&*(),.?":{}|'<>]/;
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
})
</script>
