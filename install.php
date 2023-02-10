<?php
    //si existe la variable $_POST[instalar]
    if(isset($_POST['instalar'])){
        $cadena="<?php\n"
        .'$HOST="'.$_POST['host']."\";\n"
        .'$BDNAME="'.$_POST['BD']."\";\n"
        .'$USERBD="'.$_POST['userBD']."\";\n"
        .'$PASSWORDBD="'.$_POST['passwordBD']."\";\n"
        .'$PORT="'.$_POST['port']."\";\n?>";
        $mifichero=fopen("config.php","w");
        fwrite($mifichero,$cadena);
        fclose($mifichero);

    }


?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">

    <title>instalación aw</title>
    <style>
        form *{
            display:block;
        }
    </style>
</head>
<body>
    <div id="info">
        Para realizar la instalación necesitas:
        <ol>
            <li>Un sistema gestor de bases de datos mysql o mariadb</li>
            <li>Una base de datos creada en el. </li>
            <li>Un usuario y su password con privilegios sobre la base de datos</li>


        </ol>
        
    </div>

    <?php
    include_once "config.php";
    $conexion=mysqli_connect($HOST,$USERBD,$PASSWORDBD,$BDNAME,$PORT);

    if(!file_exists("config.php")||!$conexion){
        if(file_exists("config.php")) echo "Error en las credenciales";
        
    ?>
    <div id="formulario1">
        <form action="" method="post">
            host<input type="text" name="host" required>
            nombre base de datos<input type="text" name="BD" required>
            usuario de SGBD <input type="text" name="userBD" required>
            password<input type="text" name="passwordBD" required>
            puerto<input type="text" name="port" required>
            <hr>
            <fieldset>
                login del primer usuario admin
                <input type="text" name="primerAdmin" required>
                password primerAdmin
                <input type="text" name="passwordAdmin" required>    
            </fieldset>
            <input type="submit" name="instalar" value="instalar">
        </form>

    </div>
    <?php
    }else{
        $consultas['usuarios']="CREATE TABLE `usuarios` (`nombre` VARCHAR(100) NOT NULL , 
                                               `apellidos` VARCHAR(200) NOT NULL ,
                                               `login` VARCHAR(50) NOT NULL ,
                                               `password` VARCHAR(512) NOT NULL ,
                                               `rol` ENUM('user','admin') NOT NULL ,
                                                PRIMARY KEY (`login`))
                                                ENGINE = InnoDB; ";
        $consultas['inseradmin']="INSERT INTO `usuarios` (`nombre`, `apellidos`, `login`, `password`, `rol`) 
                      VALUES ('', '', '$_POST[primerAdmin]', SHA1('$_POST[passwordAdmin]'), 'admin');";
        
        foreach($consultas as $k => $consulta){
            mysqli_query($conexion,$consulta);
            echo "Creando: $k"; 
        }

        echo "<br> Instalación realizada proceda a eliminar el script install.php";

    }
    ?>

  
</body>
</html>
