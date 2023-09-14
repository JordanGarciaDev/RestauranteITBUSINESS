<?php
    require 'database.php';

    if(!empty($_GET['id'])) 
    {
        $id = checkInput($_GET['id']);
    }
     
    $db = Database::connect();
    $statement = $db->prepare("SELECT items.id, items.name, items.descripcion, items.precio, items.imagen, categorias.name AS categoria FROM items LEFT JOIN categorias ON items.categoria = categorias.id WHERE items.id = ?");
    $statement->execute(array($id));
    $item = $statement->fetch();
    Database::disconnect();

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
        <?php include("head.php");?>
    </head>
    
    <body>
        <h1 class="text-logo"><span class="glyphicon glyphicon-cutlery"></span> Decameron Menú <span class="glyphicon glyphicon-cutlery"></span></h1>
         <div class="container admin">
            <div class="row">
               <div class="col-sm-6">
                    <h1><strong>Ver producto</strong></h1>
                    <br>
                    <form>
                      <div class="form-group">
                        <label>Nombre:</label><?php echo '  '.$item['name'];?>
                      </div>
                      <div class="form-group">
                        <label>Descripción:</label><?php echo '  '.$item['descripcion'];?>
                      </div>
                      <div class="form-group">
                        <label>Precio:</label><?php echo '  '.number_format((float)$item['precio'], 2). ' $';?>
                      </div>
                      <div class="form-group">
                        <label>Categoría:</label><?php echo '  '.$item['categoria'];?>
                      </div>
                      <div class="form-group">
                        <label>Imagen:</label><?php echo '  '.$item['imagen'];?>
                      </div>
                    </form>
                    <br>
                    <div class="form-actions">
                      <a class="btn btn-primary" href="../index.php"><span class="glyphicon glyphicon-arrow-left"></span> Regresar</a>
                    </div>
                </div> 
                <div class="col-sm-6 site">
                    <div class="thumbnail">
                        <img src="<?php echo '../images/'.$item['imagen'];?>" alt="...">
                        <div class="precio"><?php echo number_format((float)$item['precio'], 2). ' $';?></div>
                          <div class="caption">
                            <h4><?php echo $item['name'];?></h4>
                            <p><?php echo $item['descripcion'];?></p>
                            <a href="#" class="btn btn-order" role="button"><span class="glyphicon glyphicon-shopping-cart"></span> Ordenar</a>
                          </div>
                    </div>
                </div>
            </div>
        </div>   
    </body>
</html>

