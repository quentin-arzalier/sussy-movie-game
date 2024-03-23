<form action="/user/changePasswordForgotten" method="post" class='container'>
        <fieldset>
            <label>Nouveau mot de passe</label>
            <input id="pwd" type="password" name="password" required>
            <ul id='list'>
                <li id='message1'>
                    <p>Ajouter : Majuscule</p>
                </li>
                <li id='message2'>
                    <p>Ajouter : Minuscule</p>
                </li>
                <li id='message3'>
                    <p>Ajouter : Chiffre</p>
                </li>
                <li id='message4'>
                    <p>Ajouter : Carractère speciaux</p>
                </li>
                <li id='message5'>
                    <p>Ajouter : Des caractères</p>
                </li>
            </ul>
            <label>Entrez le mot de passe à nouveau</label>
            <input type="password" name="password_confirm" required>
        </fieldset>
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
        button.disabled = true;
        $('#list').css('color', 'red');
        var password = $('#pwd');
        var regex = /[A-Z]/;
        var regex2 = /[a-z]/; 
        var regex3 = /[0-9]/;
        var regex4 = /[!@#$%^&*(),.?":{}|<>]/;
        function handlePasswordChange() {
        if(regex.test(password.val()) && regex2.test(password.val()) && regex3.test(password.val()) && regex4.test(password.val()) && (password.val().length >= 8)){
            button.disabled = false;
        }else{
            button.disabled = true;
        }
        $('#message1').css('color', regex.test(password.val()) ? 'green' : 'red');
        $('#message2').css('color', regex2.test(password.val()) ? 'green' : 'red');
        $('#message3').css('color', regex3.test(password.val()) ? 'green' : 'red');
        $('#message4').css('color', regex4.test(password.val()) ? 'green' : 'red');
        $('#message5').css('color', password.val().length >= 8 ? 'green' : 'red');
    }
        password.on('input', handlePasswordChange);
    })
</script>
