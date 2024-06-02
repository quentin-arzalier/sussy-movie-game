<div class="container">
    <h2>Connexion</h2>
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
    <p>Vous n'avez pas de compte? <a href="/user/createpage">Créez le dès maintenant!</a></p>
    <p>Vous avez oublié votre mot de passe? <a href="/user/forgotPassword">Cliquez ici pour le réinitialiser.</a></p>
</div>