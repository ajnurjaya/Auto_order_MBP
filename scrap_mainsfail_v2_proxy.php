<?php 
//order mbp berdasarkan mainsfail by Asep Jajang Nurjaya
//update 5 desember 2019
//add proxy

// function untuk login
function login($url,$data){
    $proxy = 'iphost';
    $credentials = "username:password";
    $fp = fopen("cookie.txt", "w");
    fclose($fp);
    $login = curl_init();
    curl_setopt($login, CURLOPT_COOKIEJAR, "cookie.txt");
    curl_setopt($login, CURLOPT_COOKIEFILE, "cookie.txt");
    curl_setopt($login, CURLOPT_TIMEOUT, 40000);
    curl_setopt($login, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($login, CURLOPT_URL, $url);
    curl_setopt($login, CURLOPT_PROXY, $proxy);
    curl_setopt($login, CURLOPT_PROXYUSERPWD,$credentials);
    curl_setopt($login, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($login, CURLOPT_USERAGENT, "Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.9.1a2pre) Gecko/2008073000 Shredder/3.0a2pre ThunderBrowse/3.2.1.8");
    curl_setopt($login, CURLOPT_FOLLOWLOCATION, TRUE);
    curl_setopt($login, CURLOPT_POST, TRUE);
    curl_setopt($login, CURLOPT_POSTFIELDS, $data);
    ob_start();
    return curl_exec ($login);
    ob_end_clean();
    curl_close ($login);
    unset($login);    
}    

function grab_page($site){
    $proxy = 'iphost';
    $credentials = "username:password";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_USERAGENT,"Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.9.1a2pre) Gecko/2008073000 Shredder/3.0a2pre ThunderBrowse/3.2.1.8");
    curl_setopt($ch, CURLOPT_TIMEOUT, 40);
    curl_setopt($ch, CURLOPT_COOKIEFILE, "cookie.txt");
    curl_setopt($ch, CURLOPT_URL, $site);
    curl_setopt($ch, CURLOPT_PROXY, $proxy);
    curl_setopt($ch, CURLOPT_PROXYUSERPWD,$credentials);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    ob_start();
    return curl_exec ($ch);
    ob_end_clean();
    curl_close ($ch);
}

function post_data($site,$data){
    $proxy = 'iphost';
    $credentials = "username:password";
    $datapost = curl_init();
        $headers = array("Expect:");
        curl_setopt($datapost, CURLOPT_PROXY, $proxy);
        curl_setopt($datapost, CURLOPT_PROXYUSERPWD,$credentials);
    curl_setopt($datapost, CURLOPT_URL, $site);
        curl_setopt($datapost, CURLOPT_TIMEOUT, 40000);
    curl_setopt($datapost, CURLOPT_HEADER, TRUE);
        curl_setopt($datapost, CURLOPT_HTTPHEADER, $headers);
    //curl_setopt($datapost, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
    curl_setopt($datapost, CURLOPT_POST, TRUE);
    curl_setopt($datapost, CURLOPT_POSTFIELDS, $data);
    curl_setopt($datapost, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($datapost, CURLOPT_COOKIEFILE, "cookie.txt");
    ob_start();
    return curl_exec ($datapost);
    ob_end_clean();
    curl_close ($datapost);
    unset($datapost);    
}
function kirim_alert($text){
    $TOKEN  = "xxxx";
    $pesan  = $text;
    // ----------- code -------------
    $k = 2;
    for ($i=0; $i<=$k; $i++){
    $method = "sendMessage";
    $url    = "https://api.telegram.org/bot" . $TOKEN . "/". $method;
    $proxy = 'iphost';
    $credentials = "username:password";
    $chatid = broadcast($i);
    $post = [
     'chat_id' => $chatid,
     // 'parse_mode' => 'HTML', // aktifkan ini jika ingin menggunakan format type HTML, bisa juga diganti menjadi Markdown
     'text' => $pesan
    ];

    $header = [
     "X-Requested-With: XMLHttpRequest",
     "User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.84 Safari/537.36" 
    ];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_PROXY, $proxy);
    curl_setopt($ch, CURLOPT_PROXYUSERPWD,$credentials);
    //curl_setopt($ch, CURLOPT_REFERER, $refer);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post );   
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $datas = curl_exec($ch);
    $error = curl_error($ch);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    $debug['text'] = $pesan;
    $debug['code'] = $status;
    $debug['status'] = $error;
    $debug['respon'] = json_decode($datas, true);
    print_r($debug);

    }
}

function broadcast($id){
    switch ($id){
        case '2':
        $chatid = "xxxx";
        break;

        case '1':
        $chatid = "xxxx";
        break;

        case '0':
        $chatid = "xxxx";
        break;
    }
    return $chatid;
}

function cek_quota($tp){
//include('simple_html_dom.php');
login("https://sumbagut.toti-telkomsel.com/Auth/login","username=username&password=password&submit=login");
$web_open_toti = grab_page("https://sumbagut.toti-telkomsel.com/Rtp/tiket/gettiket_open");
$data_open = json_decode($web_open_toti,true);
$jumlah_data = count($data_open['data'])-1;
//echo $jumlah_data . "\n";
//echo $data_open["data"][1][3];

//kita keluarkan data2 yg pln off saja punya TBG
$gabung = array();
for ($i=0; $i <= $jumlah_data ; $i++) {
 
    if ($data_open["data"][$i][2]==$tp and ($data_open["data"][$i][5]=="pln off" or $data_open["data"][$i][5]=="pln off power" or $data_open["data"][$i][5]=="pln off mf" or $data_open["data"][$i][5]=="Pln off")) {
        echo $data_open["data"][$i][2]."|".$data_open["data"][$i][1] . "\n";
        $gabung[] = $data_open["data"][$i][3];
        
    }
}
return $gabung;
}


	$site = "http://10.9.97.226/api_cip/index.php/api/alarmMainsFail";
	$data = "level_selected=RTP&access_selected=RTPO%20BANDA%20ACEH&admins=SUMBAGUT%20SALES%20CS";
    $datapost = curl_init();
    $headers = array("Expect:");
    curl_setopt($datapost, CURLOPT_URL, $site);
    curl_setopt($datapost, CURLOPT_TIMEOUT, 40000);
    curl_setopt($datapost, CURLOPT_HEADER, FALSE);
    curl_setopt($datapost, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($datapost, CURLOPT_RETURNTRANSFER, TRUE);
    //curl_setopt($datapost, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
    curl_setopt($datapost, CURLOPT_POST, TRUE);
    curl_setopt($datapost, CURLOPT_POSTFIELDS, $data);
    curl_setopt($datapost, CURLOPT_COOKIEFILE, "cookie.txt");
    ob_start();
    $result = curl_exec ($datapost);
    ob_end_clean();
    curl_close ($datapost);	
    unset($datapost);   
    //var_dump($result); 
    $input= json_decode($result,true );
    //var_dump($input);
    $jumlah = count($input['data']);
    echo "jumlah data " . $jumlah;
    $alert_all="";
    $a = 0;
    $b = 0;
    $alert_dmt = "Automasi order Mainsfail DMT, site:"."\n";
    $alert_tbg = "Automasi order Mainsfail TBG, site:"."\n";
    $punyadmt = cek_quota("MITRATEL");
    $punyatbg = cek_quota("TBG");
    $dmt = "TP - PT. Dayamitra Telekomunikasi Indonesia (DMT)";
    $tbg = "TP - PT. Tower Bersama Group";
    $exclude = array("NAD001" , "SAB001" , "NAD068" , "NAD192" , "NAD043", "NAD262", "NAD292", "NAD277", "NAD067");

    if (count($punyadmt) <=6){
    for ($i=0; $i < $jumlah-1 ; $i++) { 
        $output = $input['data'][$i]['OCCURENCE_TIME'];
	    $output2 = substr($output, 0, 10);
	    date_default_timezone_set('Asia/Jakarta');
	    $hariini = date('Y-m-d');
        $hitungdmt = count($punyadmt); 
        if ($hitungdmt <=6){
        if ($output2 == $hariini) {
            if ($dmt == $input['data'][$i]['OWNER_SITE']){
            echo "DMT" . $input['data'][$i]['SITE_ID'] ."\n";
            $site_id = $input['data'][$i]['SITE_ID'];
            
            $r = in_array($site_id, $punyadmt);
            $s = in_array($site_id, $exclude);
            if ($r == false and $s == false){
            //post open to toti
            login("https://sumbagut.toti-telkomsel.com/Auth/login","username=username&password=password&submit=login");
             $webpage = "https://sumbagut.toti-telkomsel.com/Rtp/tiket/autocomplete/?search=".$site_id;
             $data_toti = grab_page("https://sumbagut.toti-telkomsel.com/Rtp/tiket/autocomplete/?search=".$site_id);
             $data_json = json_decode($data_toti,true);
            if ($data_json['results'][0]['id'] == $site_id){
                $id = $data_json['results'][0]['id'];
                $text = $data_json['results'][0]['text'];
                $text2 = str_replace(' ', '+', $text);
                $name = $data_json['results'][0]['name'];
                $name2 = str_replace(' ', '+', $name);
                $alamat = $data_json['results'][0]['alamat'];
                $alamat2 = str_replace(' ', '+', $alamat);
                $mitra = $data_json['results'][0]['mitra'];
                $web_toti = 'siteid%5B%5D='.$text.'&pilih='.$text.'&name='.$name2.'&alamat='.$alamat2.'&mitra='.$mitra.'&permasalahan=pln+off+mf&kategori=POWER&pic=RTPOBNA&kondisi_site=DARURAT';
                post_data("https://sumbagut.toti-telkomsel.com/Rtp/tiket/multi_add",$web_toti);
                $alert_dmt .= $site_id."\n";
                
                $a += 1;
                $hitungdmt += 1;
            }
             }
            }
            }
        }
    }
} else{
    $alert = "sudah melebihi quota DMT";
    kirim_alert($alert);
}

    if (count($punyatbg) <=6){
        for ($i=0; $i < $jumlah-1 ; $i++) { 
        $output = $input['data'][$i]['OCCURENCE_TIME'];
        $output2 = substr($output, 0, 10);
        date_default_timezone_set('Asia/Jakarta');
        $hariini = date('Y-m-d');
        $hitungtbg = count($punyatbg);
        if ($hitungtbg <=6){
        if ($output2 == $hariini) {
            if ($tbg == $input['data'][$i]['OWNER_SITE']){
            echo "TBG" . $input['data'][$i]['SITE_ID'] ."\n";
            $site_id = $input['data'][$i]['SITE_ID'];
            
            $r = in_array($site_id, $punyatbg);
            $s = in_array($site_id, $exclude);
            if ($r == false and $s == false){
            //post open to toti 
            login("https://sumbagut.toti-telkomsel.com/Auth/login","username=username&password=password&submit=login");
             $webpage = "https://sumbagut.toti-telkomsel.com/Rtp/tiket/autocomplete/?search=".$site_id;
             $data_toti = grab_page("https://sumbagut.toti-telkomsel.com/Rtp/tiket/autocomplete/?search=".$site_id);
             $data_json = json_decode($data_toti,true);
            if ($data_json['results'][0]['id'] == $site_id){
                $id = $data_json['results'][0]['id'];
                $text = $data_json['results'][0]['text'];
                $text2 = str_replace(' ', '+', $text);
                $name = $data_json['results'][0]['name'];
                $name2 = str_replace(' ', '+', $name);
                $alamat = $data_json['results'][0]['alamat'];
                $alamat2 = str_replace(' ', '+', $alamat);
                $mitra = $data_json['results'][0]['mitra'];
                $web_toti = 'siteid%5B%5D='.$text.'&pilih='.$text.'&name='.$name2.'&alamat='.$alamat2.'&mitra='.$mitra.'&permasalahan=pln+off+mf&kategori=POWER&pic=RTPOBNA&kondisi_site=DARURAT';
                post_data("https://sumbagut.toti-telkomsel.com/Rtp/tiket/multi_add",$web_toti);
                $alert_tbg .= $site_id ."\n";
                
                $b += 1;
                $hitungtbg += 1;
            }
        }
                }
            }
        }
    }
    } else {
         $alert = "sudah melebihi quota TBG";
        kirim_alert($alert);
    }
if ($a>0){
 $alert_all .= $alert_dmt;   
}
if ($b>0){
$alert_all .= $alert_tbg;
}
if ($a>0 or $b>0){
kirim_alert($alert_all);
}
//login("http://10.9.97.226/api_cip/index.php/api/login","username=asepnur&password=Ceria092019");
//$answer = post_data("http://10.9.97.226/api_cip/index.php/api/alarmMainsFail","level_selected=RTP&access_selected=RTPO%20BANDA%20ACEH&admins=SUMBAGUT%20SALES%20CS");
//$contents = preg_replace('/HTTP(.*)json/s',"",$answer);
//echo $contents;
//$inputJSON = file_get_contents($result);
//$input= json_decode( $inputJSON );
//var_dump($inputJSON);	




 ?>