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
                    <td><a href='' data-usernam='admin' >$message</a></td>
                    <td><a href='' data-usernam='delete' >Supprimer</a></td>
                </tr>
            ";
        } ?>
        </tbody>
    </table>
</div>

<script>
    $("#delete").click(function(){
        $.ajax({
        url : '/user/deleteUser',
        type : 'POST',
        data : 'user=' + $user
        dataType : 'html'
        success : function(reponse_html, statut){
            $(reponse_html).appendTo("#reponse");
        },
            error : function(resultat, statut, erreur){
        },
            complete : function(resultat, statut){
        }
        });
    });

    // $("#admin").click(function(){
    //     $.ajax({
    //     url : '/user/updateAdmin',
    //     type : 'POST',
    //     data : 'user=' + $user
    //     dataType : 'html'
    //     success : function(reponse_html, statut){
    //         $(reponse_html).appendTo("#reponse");
    //     },
    //         error : function(resultat, statut, erreur){
    //     },
    //         complete : function(resultat, statut){
    //     }
    //     });
    // });
</script>    
