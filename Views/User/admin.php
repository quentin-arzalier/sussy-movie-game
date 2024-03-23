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
                    <td>$user_is_admin</td>
                    <td>$user_email_chek</td>
                    <td><a href='' data-username='$username' id='admin' >$message</a></td>
                    <td><a href='' data-username='$username' id='delete' >Supprimer</a></td>
                </tr>
            ";
        } ?>
        </tbody>
    </table>
</div>

<script>

     $("#admin").click(function(event){
        event.preventDefault();
        var username = $(this).data('username');
        $.ajax({
            url : '/user/updateAdmin',
            type : 'POST',
            data : 'username=' + username,
            dataType : 'html',
            success : function(reponse_html, status){
                $(reponse_html).appendTo("#reponse");
                currentRow.find('#admin').text('Supprimer administrateur');
            },
            error : function(){
                alert("Une erreur a eu lieu, veuillez réessayer.")
            }
        });
    });

    $("#delete").click(function(event){
        event.preventDefault();
        var username = $(this).data('username');
        $.ajax({
            url : '/user/deleteUser',
            type : 'POST',
            data : 'username=' + username,
            dataType : 'html',
            success : function(reponse_html, status){
                $(reponse_html).appendTo("#reponse");
                currentRow.remove();
            },
            error : function(){
                    alert("Une erreur a eu lieu, veuillez réessayer.")
            }
        });
    });
   
</script>    
