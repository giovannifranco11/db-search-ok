<br/>
<?php
    
    $where = '';
    if(isset($_REQUEST['valor'])){ 
        $valor = $_REQUEST['valor'];
        if($valor != ""){            
        $where = "WHERE pr.valor = '$valor'";    
        }
    }    
    if(isset($_REQUEST['genero'])){    // función isset sirve para saber si existe lo que viene en el request   
        $genero = $_REQUEST['genero'];
        if($genero != ""){
            if($where == ""){
                $where = "WHERE c.genero = '$genero'";
            }
            else{
                $where = "$where OR c.genero = '$genero'";
            }            
        }       
    }

    //1. Connect to Database
    $host = "localhost";
    $dbname = "pasteleria";
    $username = "root";
    $password = "";

    $conexion = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

    //2. Build SQL sentence
    $sql = "SELECT c.nombre as nombre_cli, c.genero, c.telefono, p.fecha_entrega, pr.nombre as nombre_pro, pr.valor 
    FROM `clientes` as c JOIN pedidos as p ON c.id = p.id_cliente JOIN productos as pr ON p.id_producto = pr.id 
    $where 
    ORDER BY c.nombre ASC";

    var_dump($sql);

    //3. Prepare SQL sentence
    $a = $conexion->prepare($sql);

    //4. Execute SQL sentence
    $resultado = $a->execute();   

    $pedidos = $a->fetchAll();  // fetchAll lee, carga, trae todo de la consulta sql y lo guarda en esta variable

    //var_dum para imprimir toda la variable

    //var_dump($pedidos);

    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultas clase</title>
</head>
<body>
<br/><br/>
    <form action="full_pedidos.php">
        Genero:
        <select name="genero" >
            <option value="">--Seleccione--</option>
            <option value="0">Femenino</option>
            <option value="1">Masculino</option>
        </select>
        <br/><br/>
        Valor:
        <input type="number" name="valor" value="<?php echo $valor; ?>">
        <br/><br/>
        <input type="submit" value="Buscar"/>
        <hr/>
    </form>

    <h1>Lista de Pedidos</h1>
    <table border="1">
        <tr>
            <td><b>Nombre Cliente</b></td>
            <td><b>Género</b></td>
            <td><b>Teléfono</b></td>
            <td><b>Fecha entrega</b></td>
            <td><b>Nombre Producto</b></td>
            <td><b>Valor</b></td>            
        </tr>
<?php
    for($i=0; $i<count($pedidos); $i++){
?>    
    <tr>
        <td> 
            <?php echo $pedidos[$i]["nombre_cli"] ?> 
        </td>

        <td> 
            <?php 
                 $genero = $pedidos[$i]["genero"];
                 if($genero == 0){
                    echo "Femenino";
                 }  
                 else{
            ?>
                     <b><u>Masculino<u/><b/> 
            <?php
                 }   // no se debe poner html dentro de un echo
                ?> 
        </td>

        <td>
            <?php echo $pedidos[$i]["telefono"] ?>
        </td>

        <td>
            <?php echo $pedidos[$i]["fecha_entrega"] ?>
        </td>

        <td>
            <?php echo $pedidos[$i]["nombre_pro"] ?>
        </td>

        <td>
            <?php echo $pedidos[$i]["valor"] ?>
        </td>
    </tr>
<?php  
    }
?>    
    </table>
</body>
</html>