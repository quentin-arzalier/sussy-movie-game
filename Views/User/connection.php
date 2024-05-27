<div class="container">
    <form action="/user/connection" method="post" >
        <div class="custom-input">
            <label for="username-input">
                <i class="fa-solid fa-user"></i>
            </label>
            <input type="text" name="username" id="username-input" placeholder="Nom d'utilisateur">
        </div>
        <div class="custom-input">
            <label for="password-input">
                <i class="fa-solid fa-key"></i>
            </label>
            <input type="password" name="password" id="password-input" placeholder="Mot de passe">
        </div>
        <input type="submit" value="S'identifier">
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
    <p>Vous n'avez pas de compte? <a href="/user/createpage">Créez le dès maintenant!</a></p>
    <p>Vous avez oublié votre mot de passe? <a href="/user/forgotPassword">Cliquez ici pour le réinitialiser.</a></p>
</div>