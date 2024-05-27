
<form action="/user/connection" method="post" >
    <fieldset>
        <label>Nom d'utilisateur</label>
        <input type="text" name="username">
        <label>Mot de passe</label>
        <input type="password" name="password">
    </fieldset>
    <input type="submit" value="s'identifier">
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
<a href="/user/forgotPassword">mot de passe oublié ?</a>
<a href="/user/createpage">Créer votre compte</a>
