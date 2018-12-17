<?php

session_start();
include_once('../include/header.php');
$user='MrTuring';
$mdp='test06';
$_SESSION['connected'] = false;
if(isset($_POST['submit'])){
	
	$username = $_POST['username'];
	$password= $_POST['password'];

	if($username && $password){
	
		if($username==$user&& $password==$mdp){
	
			$_SESSION['username']=$username;
			$_SESSION['connected']=true;
			header('Location: admin.php');
	
		}else{
            ?> <h1 style="color:red; font-size:45px;">Identifiants erronés</h1><?php
	
		}

	}else{
		echo 'Veuillez remplir tous les champs !';
	}
}

?>
<div class="container">

        <header><h1>Administration - Connexion</h1></header>
<form action="" method="POST">
    <div id="wrapper">
        <div id="container_demo" >
        <div id="login" class="animate form">
            <p>
                <label for="username" class="uname" data-icon="u" > Pseudo : </label>
                <input id="username" name="username" required="required" type="text" /><br/><br/>
            </p>
            <p>
                <label for="password" class="youpasswd" data-icon="p"> Mot de passe : </label>
                <input id="password" name="password" required="required" type="password" /><br/><br/>
            </p>
    <p><input type="submit" name="submit"/></p>


        </div>
        </div>
    </div>
</form>

</div>

<?php include_once('../include/footer.php'); ?>