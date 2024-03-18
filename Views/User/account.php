<div>
    <p>Nom d'utilisateur : <?php echo htmlspecialchars($_SESSION['login'])?></p>
    <button id="pwd">Changer mot de passe</button>
    <form id="newpwd" style="display:none;" action='/user/changePassword' method="post">
    <fieldset>
        <p>Entrez l'ancien mot de passe</p>
        <input type="password" name="old_password">
        <p>Entrez le nouveau mot de passe</p>
        <input type="password" name="new_password">
        <input type="submit" value=Changer mot de passe>
    </fieldset>
</fomr>
    <a href="/user/logout"><button>Deconnexion</button></a>
    
</div>

<script>
    $(function(){
        $('#pwd').on('click',function(){
            $('#newpwd').show();
            $('#pwd').hide();
        })
    })

</script>
