<?php 
 require_once "clases/WhatsApp.php" ;
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Privada Residencial - Inico</title>
  <link href="styles/login.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/styles/app.css" />
</head>

<body class ="centerC">
  <div class="container">

      <h1 class="title">Bienvenido a la Privada Residencial</h1>  
          <h3 class="subtitle">Inicio de Sesión</h3>
          
          <div class="contenedor">
              <form>
                  <label for="Usuario">Usuario</br><input type="text"></label></br>
                   <label for="Contraseña">Contraseña</br><input type="text"></label></br>
             </form>
             <button id="btn" type="submit" class="btn" >Iniciar Sesión</button></br>
            <button id='butn' type="submit" class="btn" data-url="<?php echo $Starter->getwhatsApplink("Gay"); ?>"><img src="styles/WhatsApp.jpg" alt="Descripción de la imagen" class="mi-imagen"></button></br> 
          </div>

            

    </div>

    
    
    
    

<script src="js/login.js"> </script>
</body>

</html>


