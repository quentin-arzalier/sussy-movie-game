<div>
    <table>
        <thead>
            <tr>
                <th>Nom d'utilisateur</th>
                <th>Email</th>
                <th>Administrateur?</th>
                <th>Email vérifié?</th>
                <th>Manager Administrateur</th>
                <th>Manager compte</th>
            </tr>
        </thead>
        <tbody>
            
        <?php
        foreach ($users as $user) {
            $username = $user->getUsername();
            $use_email = $user->getEmailAddress();
            $user_is_admin = $user->getIsAdmin() == 1
                ? '<i class="fa-solid fa-check"></i>'
                : '<i class="fa-solid fa-times"></i>';
            $user->getIsAdmin() == 1 ? $message = "Supprimer administrateur" : $message = "Passer administrateur";
            $user_email_chek = $user->getEmailChek() == 1
                ? '<i class="fa-solid fa-check"></i>'
                : '<i class="fa-solid fa-times"></i>';
            echo "
                <tr>
                    <td>$username</td>
                    <td>$use_email</td>
                    <td id='is_admin-$username'>$user_is_admin</td>
                    <td>$user_email_chek</td>
                    <td><a href='' data-username='$username' id='admin-$username' >$message</a></td>
                    <td><a href='' data-username='$username' id='delete-$username' >Supprimer</a></td>
                </tr>
            ";
        } ?>
        </tbody>
    </table>
</div>

<script>
    $(document).on("click", "[id^='admin-']", function(event){
        event.preventDefault();
        var username = $(this).data('username');
        var is_admin = document.getElementById('is_admin-' + username);
        var adminLink = $(this);

        $.post("/admin/user/updateAdmin", { username: username })
            .done(function(reponse_html) {
                $(reponse_html).appendTo("#reponse");
                if (adminLink.text() === "Supprimer administrateur") {
                    adminLink.text("Passer administrateur");
                    is_admin.innerHTML = '<i class="fa-solid fa-times"></i>';
                    customAlert("L'utilisateur n'est plus administrateur", false);
                } else {
                    adminLink.text("Supprimer administrateur");
                    is_admin.innerHTML = '<i class="fa-solid fa-check"></i>';
                    customAlert("L'utilisateur est désormais administrateur", false);
                }
            })
            .fail(function() {
                customAlert("Une erreur a eu lieu, veuillez réessayer.", true)
            });
    });

    $(document).on("click", "[id^='delete-']", function(event){
        event.preventDefault();
        var username = $(this).data('username');
        var row = $(this).closest('tr');
        row.hide();

        $.post("/admin/user/deleteUser", { username: username })
            .done(function(reponse_html) {
                $(reponse_html).appendTo("#reponse");
                row.remove();
                customAlert("L'utilisateur a été supprimé avec succès", false);
            })
            .fail(function() {
                row.show();
                customAlert("Une erreur a eu lieu, veuillez réessayer.", true)
            })
            .always(function() {
                // Code à exécuter dans tous les cas
            });
    });
   
</script>    
