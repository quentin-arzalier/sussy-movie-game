<form action="/user/create" method="post">
        <fieldset>
            <label>Nom d'utilisateur</label>
            <input type="text" name="username" />
            <label>Adresse e-mail</label>
            <input type="text" name="email" />
            <label>Mot de passe</label>
            <input id="pwd" type="password" name="password">
            <p id='message'></p>
            <label>Entrez le mot de passe à nouveau</label>
            <input type="password" name="password_confirm">
        </fieldset>
        <input id="button" type="submit" value="créer">
</form>

<script>
    var button = document.getElementById('button');
    var password = document.getElementById('pwd');
    var message = document.getElementById('message');
    button.disabled = true;
    var regex = /[A-Z]/;
    var regex2 = /[a-z]/; 
    var regex3 = /[0-9]/;
    var regex4 = /[!@#$%^&*(),.?":{}|<>]/;
    function handlePasswordChange() {
        if(regex.test(password.value) && regex2.test(password.value) && regex3.test(password.value) && regex4.test(password.value) && (password.value.length >= 8)){
            password.style.color = 'green';
            message.textContent = 'Ok';
            message.style.color = 'green';
            button.disabled = false;
        } else {

            password.style.color = 'red';
            message.textContent = 'Mot de passe non sécurisé. Ajouter : ';
            message.style.color = 'red';
            button.disabled = true;
            if(!regex.test(password.value)) message.textContent = message.textContent + 'Majuscule, ';
            if(!regex2.test(password.value)) message.textContent = message.textContent + 'Minuscule, ';
            if(!regex3.test(password.value)) message.textContent = message.textContent + 'Chiffre, ';
            if(!regex4.test(password.value)) message.textContent = message.textContent + 'Carractère speciaux, ';
            if(!(password.value.length >= 8)) message.textContent = message.textContent + 'N importe quel caractère, ';
        }
    }
    password.addEventListener('input', handlePasswordChange);
</script>
