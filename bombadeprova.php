<?php
    $tabela = isset($_POST["tabela"]) ? unserialize($_POST["tabela"]) : [];
    $acao = isset($_POST["acao"]) ? $_POST["acao"] : "";
    if($acao == "adicionar") {
        $lixo = [];
        $lixo["nome"] = $_POST["nome"];
        $lixo["endereco"] = $_POST["endereco"];
        $lixo["valor"] = isset($_POST["valor"]) && $_POST["valor"] != "" ? (float)$_POST["valor"] : 0;
        $tabela[] = $lixo;
    } elseif($acao == "apagar") {
        if(isset($_POST["index"]) && $_POST["index"] >= 0 && $_POST["index"] < count($tabela) && count($tabela) > 0) {
            array_splice($tabela,$_POST["index"],1);
        };
    };
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>simulador de ganyu heheheh to doido da silva hahahaheheheh kkkkkkk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div style="display: flex" class="position-absolute top-50 start-50 translate-middle">
        <div style="flex-direction: column; padding-right:30px;">
            <form action="" method="post" id="adicionarForm">
                <p>Nome: <input type="text" name="nome"></p>
                <p>Endereço: <input type="text" name="endereco"></p>
                <p>Valor: <input type="text" name="valor"></p>
                <input type="hidden" name="acao" value="adicionar">
                <input type="hidden" name="tabela" value="<?=htmlspecialchars(serialize($tabela))?>">
                
                <div style="flex-direction: row">
                    <input type="submit" value="Adicionar" class="btn btn-primary">
                    <button type="button" class="btn btn-danger" id="limpar">Limpar</button>
                    <!-- o type="button" faz com que ele seja separado do formulario -->
                </div>
            </form>
        </div>
        <script>
            document.querySelector("#limpar").onclick = ()=>{
                const vazio = document.createElement("form");
                vazio.action = "";
                vazio.method = "post";
                document.body.appendChild(vazio);
                vazio.submit();
            };
        </script>
        <div style="flex-direction: column">
            <table class="table table-hover table-bordered">
                <tr>
                    <th>Nome</th>
                    <th>Endereço</th>
                    <th>Valor</th>
                    <th>:3</th>
                </tr>
                <?php
                    foreach($tabela as $k=>$v) {?>
                        <tr>
                            <td><?=$v["nome"]?></td>
                            <td><?=$v["endereco"]?></td>
                            <td><?=number_format($v["valor"],2,",",".")?></td>
                            <td><button class="apagar btn btn-danger btn-sm">X</button></td>
                        </tr>
                    <?php }
                ?>
                <tr><td></td><td></td><td></td><td></td></tr> <!-- nojo ai -->
                <tr>
                    <td></td>
                    <td>
                        Total
                    </td>
                    <td>
                    <?php
                        $total = 0;
                        foreach($tabela as $k=>$v) {
                            $total += $v["valor"];
                        };
                        echo number_format($total,2,",",".");
                    ?>
                    </td>
                    <td></td>
                </tr>
            </table>
            <p></p>
        </div>
    </div>
    <form action="" method="post" id="apagarForm">
        <input type="hidden" name="index" id="desgraça">
        <input type="hidden" name="acao" value="apagar">
        <input type="hidden" name="tabela" value="<?=htmlspecialchars(serialize($tabela))?>">
    </form>
    <script>
        const botoes = document.querySelectorAll(".apagar");
        const index = document.querySelector("#desgraça");
        const form = document.querySelector("#apagarForm");
        for(const idx in botoes) {
            botoes[idx].addEventListener('click',()=>{
                //if(confirm("Certeza?")) {
                    index.value = idx;
                    form.submit();
                //};
            });
        };
    </script>
</body>
</html>