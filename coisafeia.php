<?php
    $rawdir = 'C:\\';
    $dir = scandir('C:\\');
    if(isset($_REQUEST['path'])){
        $rawdir = realpath($_GET['path']) ? realpath($_GET['path']) : $_GET['path'];
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
    function boiola($har){
        header('Location: ' . $_SERVER['PHP_SELF'] . '?path=' . $har, true, 303);
        exit();
    }
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
                $e[count($e)-1] = '';
                boiola(join('\\',$e));
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
                if(move_uploaded_file($_FILES['arquivo']['tmp_name'], $rawdir . ($_FILES['arquivo']['full_path']))){
                    echo '<h1> yippee ' . $rawdir . $_FILES['arquivo']['full_path'] . ' </h1>';
                } else {
                    echo 'false';
                }
            break;
        };
    };
    
    #echo var_dump($_SERVER);
    echo $rawdir;
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
    } else {
        ?>
        <div>
            <a href="?path=<?=$rawdir?>&action=delete"> Deletar </a>
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
