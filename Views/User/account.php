<div class="container">
    <p>Nom d'utilisateur : <?php echo htmlspecialchars($_SESSION['login'])?></p>

    <hr>

    <?php
        $user = (new User())->getByUserName($_SESSION['login']);
        include_once get_file_path(array("Views", "User", "country_selection.php"));
    ?>

    <hr>

    <button id="pwd" style="width: 100%;">Changer mot de passe</button>
    <form id="newpwd" style="display:none;" action='/user/changePassword' method="post">
        <h2>Changement de mot de passe</h2>
        <div class="custom-input">
            <label for="old-password-input">
                <i class="fa-solid fa-key"></i>
            </label>
            <input id="old-password-input" type="password" name="old_password" placeholder="Ancien mot de passe" required>
        </div>
        <div class="custom-input">
            <label for="password-input">
                <i class="fa-solid fa-key"></i>
            </label>
            <input id="password-input" type="password" name="new_password" placeholder="Nouveau mot de passe" required>
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
            <input id="password-confirm-input" type="password" name="new_password2" placeholder="Confirmation du mot de passe" required>
        </div>
        <input id="button" type="submit" value="Changer le mot de passe">
    </form>
</div>

<script>
    $(function(){
        $('#pwd').on('click',function(){
            $('#newpwd').show();
            $('#pwd').hide();
        })
    })
</script>

<script src="/resources/scripts/password_verif.js"></script>
