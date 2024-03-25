<div>
    <form id="forgotPassword">
        <fieldset>
            <p>Entrer votre adresse mail</p>
            <input type="email" name="email" id="email">
            <input type="submit" id="button" value="Changer mot de passe">
            <p id='text'></p>
        </fieldset>
    </form>
</div>

<script>
$(function(){
    $('#button').on('click', function(e){
        e.preventDefault(); // Empêcher le comportement par défaut du bouton de soumission

        // Récupérer l'adresse e-mail
        var email = $('#email').val();

        // Envoyer la requête AJAX
        $.ajax({
            url: '/user/passwordForgotten',
            type: 'POST',
            data: { email: email },
            success: function(response) {
                // Afficher le message de succès
                $('#text').text("Mail envoyé").show();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                // Gérer les erreurs éventuelles
                $('#text').text("Erreur veuillez réessayer").show();
            }
        });
    });
});
</script>
