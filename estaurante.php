<?php
    # :3 -padero industries llc ₢2024 *insira texto de confidencialidade da nintendo usado nos arquivos do gigaleak aqui 
    $tabela = isset($_REQUEST['tabela']) ? unserialize($_REQUEST['tabela']) : [];
    if(isset($_REQUEST['chiorifeet'])) { #ação a ser feita na tabela
        switch($_REQUEST['chiorifeet']) {
            #a mas blainski e o teste de sanidade pra ver se o usuário não tá fazendo cagada (ex: apagando itens que não existem)
            #então meninos aí que entra o problema:
            #não tem tempo pra implementar isso
            #e não é requisito
            #se roda tá bom já
            case 'inserir':
                $pateta = [];
                $pateta['mesa'] = $_REQUEST['mesa'];
                $pateta['pedido'] = $_REQUEST['pedido'];
                $pateta['valor'] = $_REQUEST['valor'];
                $tabela[] = $pateta;
                echo 'inserido';
            break;
            case 'editar':
                $idx = intval($_REQUEST['idx']);
                $tabela[$idx]['mesa'] = $_REQUEST['mesa'] ?? $tabela[$idx]['mesa'];
                $tabela[$idx]['pedido'] = $_REQUEST['pedido'] ?? $tabela[$idx]['pedido'];
                $tabela[$idx]['valor'] = $_REQUEST['valor'] ?? $tabela[$idx]['valor'];
                echo 'editado';
            break;
            case 'apagar':
                $idx = intval($_REQUEST['idx']);
                unset($tabela[$idx]);
                echo 'apagado';
            break;
        };
    };
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        #COISO {
            display:flex;
            flex-direction:column;
        }
        #caguei {
            width: 100px;
        }
        #nas {
            width: 300px;
        }
        #calcas {
            width: 150px;
        }
        table,td,th {
            border:1px solid black;
            border-collapse: collapse;
            padding-left:5px;
            padding-right:5px;
        }
        .operacoes {
            display: flex;
            align-items: flex-start;
        }
        #cancelar {
            margin-top:10px;
            margin-bottom:30px;
        }
    </style>
</head>
<body>
    <form id="COISO" action="" method="GET">
        <input type="number" placeholder="No.Mesa:" id="caguei" required name="mesa">
        <input type="text" placeholder="Pedido:" id="nas" required name="pedido">
        <input type="number" placeholder="Valor:" id="calcas" required name="valor">
        <input type="hidden" name="chiorifeet" value="inserir" id="eigo_nuh_uh">
        <input type="hidden" name="tabela" value="<?=htmlspecialchars(serialize($tabela))?>">
        <input type="hidden" name="idx" id="idx">
        <input type="submit" value="+" id="g">
    </form>
    <button id="cancelar" hidden>Cancelar edição</button>
    <table>
        <tr>
            <th>No.Mesa</th>
            <th>pedido</th>
            <th>Valor</th>
            <th>Op.</th>
        </tr>
        <?php
            #pq (exemplo):

            #tabela normal:     3,4,4,4,5,1,2,3,1
            #tabela organizada: 1,1,2,3,3,4,4,4,5

            #index 0 da tabela normal:     3
            #index 0 da tabela organizada: 1

            #se eu apagar o item 0 da tabela normal na tabela organizada querendo apagar o 3
            #eu vou acabar apagando o 1

            #solução: guardar o index de cada item da tabela normal nos itens da tabela organizada 

            $sortd = [];
            foreach($tabela as $i => $v) {
                $v['idx'] = $i;
                $sortd[$i] = $v;
            };
            function shinitai($a,$b){
                if($a['mesa'] == $b['mesa']) return 0;
                return $a['mesa'] < $b['mesa'] ? -1 : 1;
            };
            uasort($sortd, 'shinitai');
            foreach($sortd as $v) {
                ?>
                    <tr>
                        <td><?=$v['mesa']?></td>
                        <td><?=$v['pedido']?></td>
                        <td><?=number_format($v['valor'],2,',','.')?></td>
                        <td class="operacoes">
                            <form action="" method="post">
                                <input type="hidden" name="tabela" value="<?=htmlspecialchars(serialize($tabela))?>">
                                <input type="hidden" name="idx" value="<?=$v['idx']?>">
                                <input type="hidden" name="chiorifeet" value='apagar'>
                                <input type="submit" value="apagar">
                            </form>
                            <button onclick="editar('<?=$v['mesa']?>','<?=$v['valor']?>','<?=$v['pedido']?>','<?=$v['idx']?>')">editar</button>
                        </td>
                    </tr>
                    <?php
            }
            ?>
    </table>
    <script>
        const cancelar = document.querySelector('#cancelar');
        const acao = document.querySelector('#eigo_nuh_uh');
        const m = document.querySelector('#caguei');
        const p = document.querySelector('#nas');
        const v = document.querySelector('#calcas');
        const i = document.querySelector('#idx');
        cancelar.onclick = function(){
            m.value = '';
            p.value = '';
            v.value = '';
            i.value = '';
            acao.value = 'inserir';
            cancelar.hidden = true;
        }
        function editar(mesa,valor,pedido,idx){
            m.value = mesa;
            p.value = pedido;
            v.value = valor;
            i.value = idx;
            acao.value = 'editar';
            cancelar.hidden = false;
        }
    </script>
</body>
</html>