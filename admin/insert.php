<?php
     
    require 'database.php';
 
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
        $isUploadSuccess    = false;
        
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
        if(empty($image)) 
        {
            $imageError = 'Este campo no puede estar vacío';
            $isSuccess = false;
        }
        else
        {
            $isUploadSuccess = true;
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
            if($_FILES["imagen"]["size"] > 500000)
            {
                $imageError = "El archivo no debe exceder el 500 KB";
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
        
        if($isSuccess && $isUploadSuccess) 
        {
            $db = Database::connect();
            $statement = $db->prepare("INSERT INTO items (name,descripcion,precio,categoria,imagen) values(?, ?, ?, ?, ?)");
            $statement->execute(array($name,$descripcion,$precio,$categoria,$image));
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
                <h1><strong>Agregar nuevo producto al menú</strong></h1>
                <br>
                <form class="form" action="insert.php" role="form" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="name">Nombre:</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Nombre" value="<?php echo $name;?>">
                        <span class="help-inline"><?php echo $nameError;?></span>
                    </div>
                    <div class="form-group">
                        <label for="descripcion">Descripción:</label>
                        <textarea name="descripcion" class="form-control" id="descripcion" cols="10" rows="5" placeholder="Descripción"><?php echo $descripcion;?></textarea>
                        <span class="help-inline"><?php echo $descripcionError;?></span>
                    </div>
                    <div class="form-group">
                        <label for="precio">Precio:</label>
                        <input type="number" step="0.01" class="form-control" id="precio" name="precio" placeholder="Precio" value="<?php echo $precio;?>">
                        <span class="help-inline"><?php echo $precioError;?></span>
                    </div>
                    <div class="form-group">
                        <label for="categoria">Categoría:</label>
                        <select class="form-control" id="categoria" name="categoria">
                        <?php
                           $db = Database::connect();
                           foreach ($db->query('SELECT * FROM categorias') as $row)
                           {
                                echo '<option value="'. $row['id'] .'">'. $row['name'] . '</option>';;
                           }
                           Database::disconnect();
                        ?>
                        </select>
                        <span class="help-inline"><?php echo $categoriaError;?></span>
                    </div>
                    <div class="form-group">
                        <label for="imagen">Selecciona una imagen:</label>
                        <input type="file" id="imagen" name="imagen">
                        <span class="help-inline"><?php echo $imageError;?></span>
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