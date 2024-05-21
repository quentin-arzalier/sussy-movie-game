<div>
    <p>Nom d'utilisateur : <?php echo htmlspecialchars($_SESSION['login'])?></p>
    <button id="pwd">Changer mot de passe</button>
    <form id="newpwd" style="display:none;" action='/user/changePassword' method="post">
    <fieldset>
        <p>Entrez l'ancien mot de passe</p>
        <input type="password" name="old_password">
        <p>Entrez le nouveau mot de passe</p>
        <input type="password" id='new_password' name="new_password">
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
            <p>Entrez de nouveau le nouveau mot de passe</p>
        <input type="password" name="new_password2">
        <input type="submit" id="button" value="Changer mot de passe">
        <p>
            <?php 
                if (isset($_SESSION['message'])) {
                    echo $_SESSION['message'];
                    unset($_SESSION['message']);
                }
            ?>
        </p>
    </fieldset>
</form>
    
</div>

<script>
    $(function(){
        $('#pwd').on('click',function(){
            $('#newpwd').show();
            $('#pwd').hide();
        })
    })
    $(function(){
        button.disabled = true;
        $('#list').css('color', 'red');
        var password = $('#new_password');
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
