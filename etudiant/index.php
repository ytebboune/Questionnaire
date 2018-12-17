<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>Accueil</title>
        <link rel="shortcut icon" href="../../favicon.ico">
        <link rel="stylesheet" type="text/css" href="../css/demo.css" />
        <link rel="stylesheet" type="text/css" href="../css/style.css" />
        <link rel="stylesheet" type="text/css" href="../css/style2.css" />
    </head>
    <body>
        <div class="container">
            <header><h1>Etudiant - Connexion</h1></header>
            <form action="connexion.php" method="POST">
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
    </body>
</html>