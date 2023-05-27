<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galería de imagenes</title>
    <link rel="icon" href="https://kinsta.com/es/wp-content/uploads/sites/8/2018/07/plugins-galeria-fotos-wordpress.jpg" type="image/jpg">
</head>
<body>
    <form action="./archivos.php" method="post" enctype="multipart/form-data" target="_self" >
        <fieldset style="width: 400px;" >
            <legend>Sube tu imagen</legend>
            <label for="nom">Nombre:</label><br>
            <input type="text" id="nom" name="nombre" required /><br><br>
            
            <label for="arch">Imagen:</label><br>
            <input type="file" id="arch" accept="image/*" name="arch"/><br><br>
           
            <button type="reset">Restablecer</button>
            <button type="submit">Enviar</button>
        </fieldset>
    </form>
    <?php
        var_dump($_SERVER);
        $nombre = (isset($_POST["nombre"]) && $_POST["nombre"] != "")? $_POST["nombre"] : false;
        if($_FILES["arch"])
        {
            $arch = $_FILES["arch"];
            $name = $arch["name"];
            $ruta_temp = $arch["tmp_name"];
            $ext = pathinfo($name, PATHINFO_EXTENSION);
            if(!file_exists('./img'))
            {
                if(mkdir('./img'));
            }
            rename($ruta_temp, "./img/$nombre.$ext");
        }

        //Despliegue de imagenes
        if(file_exists("./img"))
        {
            $dir = opendir("./img");
        $hay_archivo = true;
        $archivos = [];
        while ($hay_archivo)
        {
           $archivo =  readdir($dir);
           if($archivo)
           {
                array_push($archivos, $archivo);
           }else{
                $hay_archivo =false;
           }
        }

        echo '
        <table border="1">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Imagen</th>
                </tr>
            </thead>
            <tbody>';
        foreach($archivos as $archivo)
        {
            //imagen.jpg
            if($archivo != '.' && $archivo != '..')
            {
                $nombreArch = pathinfo($archivo, PATHINFO_FILENAME );
                echo '<tr>
                    <td>'.$nombreArch.'</td>
                    <td><img src="./img/'.$archivo.'" height="200px"></td>
                   </tr>
                ';
                
            }
           
        }
        echo '
            </tbody>
        </table>
        ';
        }
        

    ?>
    
</body>
</html>
