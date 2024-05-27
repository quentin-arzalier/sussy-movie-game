<div>
    <table>
        <thead>
            <tr>
                <td>UserName</td>
                <td>Email</td>
                <td>Is Admin</td>
                <td>Email chek</td>
                <td>Manager Administrateur</td>
                <td>Manager compte</td>
            </tr>
        </thead>
        <tbody>
            
        <?php
        foreach ($users as $user) {
            $username = $user->getUsername();
            $use_email = $user->getEmailAddress();
            $user_is_admin = $user->getIsAdmin();
            $user_is_admin ? $message = "Supprimer administrateur" : $message = "Passer administrateur";
            $user_email_chek = $user->getEmailChek();
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

        $.ajax({
            url : '/admin/user/updateAdmin',
            type : 'POST',
            data : 'username=' + username,
            dataType : 'html',
            success : function(reponse_html, status){
                $(reponse_html).appendTo("#reponse");
                if (adminLink.text() === "Supprimer administrateur") {
                    adminLink.text("Passer administrateur");
                    is_admin.textContent ="0";
                } else {
                    adminLink.text("Supprimer administrateur");
                    is_admin.textContent ="1";
                }
            },
            error : function(){
                customAlert("Une erreur a eu lieu, veuillez réessayer.", true)
            }
        });
    });

    $(document).on("click", "[id^='delete-']", function(event){
        event.preventDefault();
        var username = $(this).data('username');
        var row = $(this).closest('tr');
        row.hide();
        $.ajax({
            url : '/admin/user/deleteUser',
            type : 'POST',
            data : 'username=' + username,
            dataType : 'html',
            success : function(reponse_html, status){
                $(reponse_html).appendTo("#reponse");
                row.remove();
            },
            error : function(){
                row.show();
                customAlert("Une erreur a eu lieu, veuillez réessayer.", true)
            }
        });
    });
   
</script>    
