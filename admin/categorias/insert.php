<?php
     
    require '../database.php';
 
    $nameError = $name = "";

    if(!empty($_POST)) 
    {
        $name               = checkInput($_POST['name']);

        $isSuccess          = true;

        if(empty($name)) 
        {
            $nameError = 'Este campo no puede estar vacío';
            $isSuccess = false;
        }

        if($isSuccess)
        {
            $db = Database::connect();
            $statement = $db->prepare("INSERT INTO categorias (name) values(?)");
            $statement->execute(array($name));
            Database::disconnect();
            header("Location: index.php");
        }
    }

    function checkInput($data) 
    {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }
?>

<!DOCTYPE html>
<html>
    <head>
       <?php include("head.php")?>
    </head>
    
    <body>
        <h1 class="text-logo"><span class="glyphicon glyphicon-cutlery"></span> Decameron Menú <span class="glyphicon glyphicon-cutlery"></span></h1>
         <div class="container admin">
            <div class="row">
                <h1><strong>Agregar nueva categoría</strong></h1>
                <br>
                <form class="form" action="insert.php" role="form" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="name">Nombre de la categoría:</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Nombre" value="<?php echo $name;?>">
                        <span class="help-inline"><?php echo $nameError;?></span>
                    </div>
                    <br>
                    <div class="form-actions">
                        <a class="btn btn-primary" href="index.php"><span class="glyphicon glyphicon-arrow-left"></span> Regresar</a>
                        <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> Agregar</button>
                    </div>
                </form>
            </div>
        </div>   
    </body>
</html>