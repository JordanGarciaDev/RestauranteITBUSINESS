<!DOCTYPE html>
<html>
    <head>
		<?php include("head.php");?>
    </head>
    
    <body>
        <h1 class="text-logo"><span class="glyphicon glyphicon-cutlery"></span> Decameron Menú <span class="glyphicon glyphicon-cutlery"></span></h1>
        <div class="container admin">
            <div class="row">
                <h1>
                    <strong>Lista de productos</strong>
                    <a href="insert.php" class="btn btn-success btn">
                        <span class="glyphicon glyphicon-plus"></span> Agregar producto
                    </a>
                    <a href="categorias/insert.php" class="btn btn-success btn">
                        <span class="glyphicon glyphicon-plus"></span> Agregar categorías
                    </a>
                </h1>
                <table class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th>Nombre</th>
                      <th>Descripción</th>
                      <th>Precio</th>
                      <th>Categoría</th>
                      <th style="text-align: center">Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php
                        require 'database.php';
                        $db = Database::connect();
                        $statement = $db->query('SELECT items.id, items.name, items.descripcion, items.precio, categorias.name AS categoria FROM items LEFT JOIN categorias ON items.categoria = categorias.id ORDER BY items.id DESC');
                        while($item = $statement->fetch()) 
                        {
                            echo '<tr>';
                            echo '<td>'. $item['name'] . '</td>';
                            echo '<td>'. $item['descripcion'] . '</td>';
                            echo '<td>'. number_format($item['precio'], 2, '.', '') . '</td>';
                            echo '<td>'. $item['categoria'] . '</td>';
                            echo '<td width="300" style="text-align: center">';
                            echo '<a class="btn btn-default" href="view.php?id='.$item['id'].'"><span class="glyphicon glyphicon-eye-open"></span></a>';
                            echo ' ';
                            echo '<a class="btn btn-primary" href="update.php?id='.$item['id'].'"><span class="glyphicon glyphicon-pencil"></span></a>';
                            echo ' ';
                            echo '<a class="btn btn-danger" href="delete.php?id='.$item['id'].'"><span class="glyphicon glyphicon-remove"></span></a>';
                            echo '</td>';
                            echo '</tr>';
                        }
                        Database::disconnect();
                      ?>
                  </tbody>
                </table>
            </div>
        </div>
    </body>
</html>
