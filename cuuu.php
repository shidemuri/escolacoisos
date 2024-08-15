<?php
    $macaco = new mysqli("localhost","root",null,"atividadeweb2xd");
    $resultado = $macaco->query("select * from usuarios");
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> tablkeak </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <table class="table table-hover table-bordered">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Telefone</th>
            </tr>
        </thead>
        <tbody>
            <?php
                while($linha = $resultado->fetch_assoc()) { ?>
                    <tr>
                        <td><?=$linha["nome"]?></td>
                        <td><?=$linha["telefone"]?></td>
                    </tr>
                <?php };
            ?>
        </tbody>
    </table>
</body>
</html>
