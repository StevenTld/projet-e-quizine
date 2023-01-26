<html>
    <head>
        <title>Test PHP</title>
    </head>
    <body>
        <form enctype="multipart/form-data" action="uploadaction.php" method="post">

            <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
                Envoyez ce fichier : <input name="userfile" type="file"/>
            <input type="submit" value="Envoyez le fichier" />
        </form>
        <a href="index.php"><button>Retourner à l'acceuil</button></a>
    </body>
</html>