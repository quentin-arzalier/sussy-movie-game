<div class="container">
    <h2>Mot de passe oublié</h2>
    <form id="forgotPassword">
        <div class="custom-input">
            <label for="email-input">
                <i class="fa-solid fa-envelope"></i>
            </label>
            <input id="email-input" type="email" name="email" placeholder="Adresse mail" required>
        </div>
        <input type="submit" id="button" value="Réinitialiser le mot de passe">
        <span id='text'></span>
    </form>
</div>

<script>
$(function(){
    $('#button').on('click', function(e){
        e.preventDefault(); // Empêcher le comportement par défaut du bouton de soumission

        // Récupérer l'adresse e-mail
        const email = $('#email-input').val();
        startSpinner();
        // Envoyer la requête AJAX
        $.ajax({
            url: '/user/passwordForgotten',
            type: 'POST',
            data: { email: email },
            success: function(response) {
                // Afficher le message de succès
                stopSpinner();
                customAlert("Email de réinitialisation envoyé", false);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                // Gérer les erreurs éventuelles
                stopSpinner();
                customAlert("Le compte associé n'existe pas", true);
            }
        });
    });
});
</script>
