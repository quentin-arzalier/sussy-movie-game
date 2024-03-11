<div>
    <p>Nom d'utilisateur : <?php echo $_SESSION['login']?></p>
    <button id="pwd" action="/user/connection" method="post">Changer mot de passe</button>
    <div id="newpwd" style="display:none;">
        <p>Entrez l'ancien mot de passe</p>
        <input type="password" name="password">
        <p>Entrez le nouveau mot de passe</p>
        <input type="password" name="new_password">
    </div>
    <a href="/user/logout"><button>Deconnexion</button></a>
    
</div>

<script>
    $(function(){
        $('#pwd').on('click',function(){
            $('#newpwd').show();
        })
    })

</script>
