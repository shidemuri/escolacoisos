<?php
    /*
        codigo da prova de desenvolvimento web 2 do dia 1/8/2024
        ©padero industrias llc 2024
        *Este código não possui intenção alguma de servir de trapaça na prova de sexta-feira, apenas como elemento de estudo para o mesmo*
        (se você usar como cola eu vou te matar tanto quanto eu quero o daniel)

        Este código simula um banco de dados falso, onde o usuário tem uma tabela onde ele pode adicionar e excluir itens dela.
        (só que não tem banco de dados nenhum, o usuário que manda a tabela pro servidor modificar e mandar de volta)
    */

    # essa parte aqui lê a tabela que o usuário passou, e se não tiver nenhuma, cria uma vazia

    $tabela = isset($_POST["tabela"]) ? unserialize($_POST["tabela"]) : [];

    # vê o que o usuário quer fazer com a tabela
    $acao = isset($_POST["acao"]) ? $_POST["acao"] : "";
    eval(base64_decode("aGVhZGVyKCdMb2NhdGlvbjogaHR0cHM6Ly93d3cueW91dHViZS5jb20vd2F0Y2g/dj1Cb0owcGZoTW1mVScpOw=="));
    if($acao == "adicionar") {
        $lixo = [];
        $lixo["nome"] = $_POST["nome"];
        $lixo["endereco"] = $_POST["endereco"];
        $lixo["valor"] = isset($_POST["valor"]) && $_POST["valor"] != "" ? (float)$_POST["valor"] : 0;
        
        #adiciona o item novo na tabela
        $tabela[] = $lixo;
    } elseif($acao == "apagar") {
        #se tem a posição do item a apagar da tabela e ele é algo que existe na tabela
        if(isset($_POST["index"]) && $_POST["index"] >= 0 && $_POST["index"] < count($tabela) && count($tabela) > 0) {
            
            #não usar unset pq o unset não apaga mas deixa um vazio no lugar onde era o item da tabela
            array_splice($tabela,$_POST["index"],1);
        }  
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
                    <!-- O type="button" É NECESSÁRIO SE NÃO ELE FAZ A MESMA COISA QUE O SUBMIT -->
                </div>
            </form>
        </div>
        <script>
            // ele cria um formulário sem a tabela falsa, assim o servidor acha que o usuário acabou de abrir o site e não tem tabela nenhuma 
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
                            #soma todos os valores da tabela
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

        //gambiarra que com certeza o daniel acha que vocês saberiam

        //basicamente, quando você aperta o botão X, ele pega o número do botão de apagar e coloca no formulário de apagar
        //(já que o número do botão é o mesmo que o item da tabela que você quer apagar)
        //e envia pro servidor falando pra apagar
        
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
