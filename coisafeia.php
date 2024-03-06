<?php
    $rawdir = 'C:\\';
    $dir = scandir($rawdir);
    if(isset($_REQUEST['path'])){
        $rawdir = str_replace("\ ","%20",realpath($_GET['path']) ? realpath($_GET['path']) : $_GET['path']);
        if(is_dir($_GET['path'])) {
            $dir = scandir($rawdir);
        } else {
            $e = preg_split("/[\\\\]+/", $rawdir);
            $dir = array("name" => $e[count($e)-1], "path" => $e);
        };
    };
    if(isset($_REQUEST['raw'])) {
        $e = preg_split("/[\\\\]+/", $_REQUEST['raw']);
        $l = $e[count($e)-1];
        #echo var_dump($e);
        if(isset($_REQUEST['dl'])) {
            header("Content-Disposition: attachment; filename=$l");
        };
        if(is_file($_REQUEST['raw']) && is_readable($_REQUEST['raw'])) {
            header('Content-Type:');
            readfile($_REQUEST['raw']);
            die();
        } else {
            echo 'nuh uh';
            die();
        };
    };

    function human_filesize($bytes, $decimals = 2) {
        $factor = floor((strlen($bytes) - 1) / 3);
        if ($factor > 0) $sz = 'KMGT';
        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor - 1] . 'B';
    }

    function boiola($har){
        header('Location: ' . $_SERVER['PHP_SELF'] . '?path=' . $har, true, 303);
        exit();
    }

    $voltado = preg_split("/[\\\\]+/", $rawdir);
    unset($voltado[count($voltado)-1]);
    $voltado = join('\\',$voltado);

    if(isset($_GET['action'])) {
        switch($_GET['action']){
            case 'rename':
                if(!isset($_GET['newname'])) boiola($rawdir);
                $e[count($e)-1] = $_GET['newname'];
                rename($rawdir,join('\\',$e));
                boiola(join('\\',$e));
            break;
            #default:
            #    boiola($rawdir);
            #break;
            case 'delete': 
                unlink($rawdir);
                boiola($voltado);
            break;
        };
    };

    if(isset($_POST['action'])) {
        switch($_POST['action']) {
            case 'upload':
                echo var_dump($_FILES['arquivo']);
                if(!isset($_FILES['arquivo'])){
                    echo "<h1> cade o arquivo </h1>";
                };
                if(move_uploaded_file($_FILES['arquivo']['tmp_name'], $rawdir . '\\' . ($_FILES['arquivo']['full_path']))){
                    echo '<h1> yippee ' . $rawdir . '\\' .  $_FILES['arquivo']['full_path'] . ' </h1>';
                } else {
                    echo 'false';
                }
            break;
            case 'edit':
                if(!isset($_POST['content'])){
                    echo "<h1> calhorda </h1>";
                } elseif(!is_readable($rawdir)) {
                    echo "<h1> Não é possível escrever para este arquivo (é pasta / não é editável) </h1>";
                } else {
                    file_put_contents($rawdir, $_POST['content']);
                    echo "<h1> editado com sucesso </h1>";
                };
            break;
        };
    };
    

    
    #echo var_dump($_SERVER);
    echo '<h3>' . $rawdir . '</h3>';
    echo '<style> *{font-size:18px} </style>';
    if(is_dir($rawdir)) {?>
        <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="action" value="upload">
            <input type="hidden" name="path" value="<?=$rawdir?>">
            <input type="file" name="arquivo">
            <input type="submit">
        </form>
            <?php
                for($i = 0; $i < count($dir); $i++) {?>
                    <p><a href="?path=<?=$rawdir . '\\' . $dir[$i]?>">
                    <?php
                    if(is_dir($rawdir . '\\' . $dir[$i])) {
                        echo "\u{1f4c2}";
                    };
            ?><?=$dir[$i]?></a></p>
    <?php
        };
    } elseif(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit'){ ?>

        <p><a href="?path=<?=$rawdir?>"> Voltar </a></p>
        <?=is_writable($rawdir) ? '' : "<h1> Não é possível escrever para este arquivo (é pasta / não é editável) </h1>"?>
        <div style="display:flex;flex-direction:column;">
            <form action="" method="post">
                <input type="hidden" name="path" value="<?=$rawdir?>">
                <input type="hidden" name="action" value="edit">
                <textarea spellcheck="false" name="content" cols="60" rows="30" <?=is_writable($rawdir) ? '' : 'readonly'?>><?=file_get_contents($rawdir)?></textarea>
                <p>
                    <input style="font-size:20px;" type="submit" value="editar">
                </p>
            </form>
        </div>
    <?php } else {
        ?>
        <div>
            <h2><?=human_filesize(filesize($rawdir))?></h2>
            <p><a href="?path=<?=$voltado?>"> Voltar </a></p>
            <p><a href="?path=<?=$rawdir?>&action=delete"> Deletar </a></p>
            <p><a href="?path=<?=$rawdir?>&action=edit"> Editar como texto </a></p>
            <button id="rename">Renomear</button>
            <form action="" id="rform">
                <input type="hidden" name="path" value="<?=$rawdir?>">
                <input type="hidden" name="action" value="rename">
                <input type="hidden" name="newname" value="" id="newname">
            </form>
            <form action="">
                <input type="hidden" name="raw" value="<?=$rawdir?>">
                <input type="submit" value="ver arquivo">
            </form>
            <form action="">
                <input type="hidden" name="raw" value="<?=$rawdir?>">
                <input type="hidden" name="dl" value="1">
                <input type="submit" value="baixar">
            </form>
            
            <?=!is_writable($rawdir) ? '<h2 style="background-color:red;"> kono fairu wa readonly desu (nihongo jouzu) </h2>' : ''?>

            <script>
                document.querySelector('#rename').onclick = function(){
                    const porro = prompt("Digite um novo nome para <?=$e[count($e)-1]?>")
                    if(confirm(`Gostaria de renomear "<?=$e[count($e)-1]?>" para "${porro}"?`)) {
                        document.querySelector('#newname').value = porro;
                        document.querySelector('#rform').submit()
                    }
                }
            </script>
<?php
    };
?>
