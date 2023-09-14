<!DOCTYPE html>
<html>
    <head>
        <title>Decameron Menú</title>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <link href='http://fonts.googleapis.com/css?family=Holtwood+One+SC' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="css/styles.css">
    </head>
    
    
    <body>
        <div class="container site">
            <h1 class="text-logo"><span class="glyphicon glyphicon-cutlery"></span> Decameron Menú <span class="glyphicon glyphicon-cutlery"></span></h1>
            <?php
				require 'admin/database.php';
			 
                echo '<nav>
                        <ul class="nav nav-pills">';

                $db = Database::connect();
                $statement = $db->query('SELECT * FROM categorias');
                $categorias = $statement->fetchAll();
                foreach ($categorias as $categoria)
                {
                    if($categoria['id'] == '1')
                        echo '<li role="presentation" class="active"><a href="#'. $categoria['id'] . '" data-toggle="tab">' . $categoria['name'] . '</a></li>';
                    else
                        echo '<li role="presentation"><a href="#'. $categoria['id'] . '" data-toggle="tab">' . $categoria['name'] . '</a></li>';
                }

                echo    '</ul>
                      </nav>';

                echo '<div class="tab-content">';

                foreach ($categorias as $categoria)
                {
                    if($categoria['id'] == '1')
                        echo '<div class="tab-pane active" id="' . $categoria['id'] .'">';
                    else
                        echo '<div class="tab-pane" id="' . $categoria['id'] .'">';
                    
                    echo '<div class="row">';
                    
                    $statement = $db->prepare('SELECT * FROM items WHERE items.categoria = ?');
                    $statement->execute(array($categoria['id']));
                    while ($item = $statement->fetch()) 
                    {
                        echo '<div class="col-sm-6 col-md-4">
                                <div class="thumbnail">
                                    <img src="images/' . $item['imagen'] . '" alt="...">
                                    <div class="precio">$ '.number_format($item['precio']).'</div>
                                    <div class="caption">
                                        <h4>' . $item['name'] . '</h4>
                                        <p>' . $item['descripcion'] . '</p>
                                        <a href="admin/view.php?id='.$item['id'].'" class="btn btn-order" role="button"><span class="glyphicon glyphicon-shopping-cart"></span> Ordenar</a>
                                    </div>
                                </div>
                            </div>';
                    }
                   
                   echo    '</div>
                        </div>';
                }
                Database::disconnect();
                echo  '</div>';
            ?>
        </div>
    </body>
</html>

