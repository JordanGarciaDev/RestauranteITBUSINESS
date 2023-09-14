<?php

    require 'database.php';

    if(!empty($_GET['id'])) 
    {
        $id = checkInput($_GET['id']);
    }

    $nameError = $descripcionError = $precioError = $categoriaError = $imageError = $name = $descripcion = $precio = $categoria = $image = "";

    if(!empty($_POST)) 
    {
        $name               = checkInput($_POST['name']);
        $descripcion        = checkInput($_POST['descripcion']);
        $precio              = checkInput($_POST['precio']);
        $categoria           = checkInput($_POST['categoria']);
        $image              = checkInput($_FILES["imagen"]["name"]);
        $imagePath          = '../images/'. basename($image);
        $imageExtension     = pathinfo($imagePath,PATHINFO_EXTENSION);
        $isSuccess          = true;
       
        if(empty($name)) 
        {
            $nameError = 'Este campo no puede estar vacío';
            $isSuccess = false;
        }
        if(empty($descripcion))
        {
            $descripcionError = 'Este campo no puede estar vacío';
            $isSuccess = false;
        } 
        if(empty($precio))
        {
            $precioError = 'Este campo no puede estar vacío';
            $isSuccess = false;
        } 
         
        if(empty($categoria))
        {
            $categoriaError = 'Este campo no puede estar vacío';
            $isSuccess = false;
        }
        if(empty($image)) // le input file est vide, ce qui signifie que l'imagen n'a pas ete update
        {
            $isImageUpdated = false;
        }
        else
        {
            $isImageUpdated = true;
            $isUploadSuccess =true;
            if($imageExtension != "jpg" && $imageExtension != "png" && $imageExtension != "jpeg" && $imageExtension != "gif" ) 
            {
                $imageError = "Los archivos permitidos son: .jpg, .jpeg, .png, .gif";
                $isUploadSuccess = false;
            }
            if(file_exists($imagePath)) 
            {
                $imageError = "El archivo ya existe";
                $isUploadSuccess = false;
            }
            if($_FILES["imagen"]["size"] > 1000000)
            {
                $imageError = "La imagen no puede pesar más de 1000KB";
                $isUploadSuccess = false;
            }
            if($isUploadSuccess) 
            {
                if(!move_uploaded_file($_FILES["imagen"]["tmp_name"], $imagePath))
                {
                    $imageError = "Se ha producido un error al subir el archivo";
                    $isUploadSuccess = false;
                } 
            } 
        }
         
        if (($isSuccess && $isImageUpdated && $isUploadSuccess) || ($isSuccess && !$isImageUpdated)) 
        { 
            $db = Database::connect();
            if($isImageUpdated)
            {
                $statement = $db->prepare("UPDATE items  set name = ?, descripcion = ?, precio = ?, categoria = ?, imagen = ? WHERE id = ?");
                $statement->execute(array($name,$descripcion,$precio,$categoria,$image,$id));
            }
            else
            {
                $statement = $db->prepare("UPDATE items  set name = ?, descripcion = ?, precio = ?, categoria = ? WHERE id = ?");
                $statement->execute(array($name,$descripcion,$precio,$categoria,$id));
            }
            Database::disconnect();
            header("Location: index.php");
        }
        else if($isImageUpdated && !$isUploadSuccess)
        {
            $db = Database::connect();
            $statement = $db->prepare("SELECT * FROM items where id = ?");
            $statement->execute(array($id));
            $item = $statement->fetch();
            $image          = $item['imagen'];
            Database::disconnect();
           
        }
    }
    else 
    {
        $db = Database::connect();
        $statement = $db->prepare("SELECT * FROM items where id = ?");
        $statement->execute(array($id));
        $item = $statement->fetch();
        $name           = $item['name'];
        $descripcion    = $item['descripcion'];
        $precio          = $item['precio'];
        $categoria       = $item['categoria'];
        $image          = $item['imagen'];
        Database::disconnect();
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
                <div class="col-sm-6">
                    <h1><strong>Editar producto</strong></h1>
                    <br>
                    <form class="form" action="<?php echo 'update.php?id='.$id;?>" role="form" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="name">Nombre:
                            <input type="text" class="form-control" id="name" name="name" placeholder="Nombre" value="<?php echo $name;?>">
                            <span class="help-inline"><?php echo $nameError;?></span>
                        </div>
                        <div class="form-group">
                            <label for="descripcion">Descripción:
                            <input type="text" class="form-control" id="descripcion" name="descripcion" placeholder="Descripción" value="<?php echo $descripcion;?>">
                            <span class="help-inline"><?php echo $descripcionError;?></span>
                        </div>
                        <div class="form-group">
                        <label for="precio">Precio:
                            <input type="number" step="0.01" class="form-control" id="precio" name="precio" placeholder="Precio" value="<?php echo $precio;?>">
                            <span class="help-inline"><?php echo $precioError;?></span>
                        </div>


                        <div class="form-group">
                            <label for="categoria">Categoría:
                            <select class="form-control" id="categoria" name="categoria">
                            <?php
                               $db = Database::connect();
                               foreach ($db->query('SELECT * FROM categorias') as $row)
                               {
                                    if($row['id'] == $categoria)
                                        echo '<option selected="selected" value="'. $row['id'] .'">'. $row['name'] . '</option>';
                                    else
                                        echo '<option value="'. $row['id'] .'">'. $row['name'] . '</option>';;
                               }
                               Database::disconnect();
                            ?>
                            </select>
                            <span class="help-inline"><?php echo $categoriaError;?></span>
                        </div>
                        <div class="form-group">
                            <label for="imagen">Imagen:</label>
                            <p><?php echo $image;?></p>
                            <label for="imagen">Selecciona una nueva imagen::</label>
                            <input type="file" id="imagen" name="imagen">
                            <span class="help-inline"><?php echo $imageError;?></span>
                        </div>
                        <br>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-pencil"></span> Modificar</button>
                            <a class="btn btn-primary" href="index.php"><span class="glyphicon glyphicon-arrow-left"></span> Regresar</a>
                       </div>
                    </form>
                </div>
                <div class="col-sm-6 site">
                    <div class="thumbnail">
                        <img src="<?php echo '../images/'.$image;?>" alt="...">
                        <div class="precio"><?php echo number_format((float)$precio, 2). ' $';?></div>
                          <div class="caption">
                            <h4><?php echo $name;?></h4>
                            <p><?php echo $descripcion;?></p>
                            <a href="#" class="btn btn-order" role="button"><span class="glyphicon glyphicon-shopping-cart"></span> Ordenar</a>
                          </div>
                    </div>
                </div>
            </div>
        </div>   
    </body>
</html>
