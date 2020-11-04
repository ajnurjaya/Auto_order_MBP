<?php
# ver 2
# oleh asep jajang nurjaya
# 20 Juli 2019
# disempurnakan dengan menambah fitur auto close
# bisa melakukan filter berdasarkan TP sehingga TP yang tidak ada MBP tidak akan di order
# tes
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
    //curl_setopt($login, CURLOPT_USERAGENT, "Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.9.1a2pre) Gecko/2008073000 Shredder/3.0a2pre ThunderBrowse/3.2.1.8");
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
    //curl_setopt($ch, CURLOPT_USERAGENT,"Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.9.1a2pre) Gecko/2008073000 Shredder/3.0a2pre ThunderBrowse/3.2.1.8");
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

function datajson($web_ec) {
    $web_ec = str_replace(' ', '%20', $web_ec);
    $output = file_get_contents($web_ec);
    $replace = array(
        'success:' => '"success":',
        'jml:' => '"jml":',
        'data:' => '"data":'
    );
    $data = strtr($output, $replace);
    $data_json = json_decode($data);
    return $data_json;
}

function comment($ticket, $kode, $pic, $btsid, $tglalarm, $status) {
    $web_ec = 'http://10.35.105.112/MONITA/AREA01_BACKEND/monita_ticket/api_monita.php?id_ticket='.$ticket.'&id_pc='.$kode.'&alias='.$pic.'&freetext=pln off power&input_from=Web Monita&status_kirim_email=NO&flag=mbp&bts_id='.$btsid.'&tgl_alarm='.$tglalarm.'&status_alarm='.$status;
    $web_ec = str_replace(' ', '%20', $web_ec);
    $ch = curl_init();
    $proxy = '10.59.82.2:8080';
    $credentials = "username:password";
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.9.1a2pre) Gecko/2008073000 Shredder/3.0a2pre ThunderBrowse/3.2.1.8");
    curl_setopt($ch, CURLOPT_TIMEOUT, 90);
    curl_setopt($ch, CURLOPT_URL, $web_ec);
    curl_setopt($ch, CURLOPT_PROXY, $proxy);
    curl_setopt($ch, CURLOPT_PROXYUSERPWD,$credentials);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    ob_start();
    curl_exec($ch);
    ob_end_clean();
    curl_close($ch);
    return $web_ec;
}

function kirim_alert($text){
    $TOKEN  = "xxxxxxxx";
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
        $chatid = "xxxxxx";
        break;

        case '1':
        $chatid = "xxxxx";
        break;

        case '0':
        $chatid = "xxxxx";
        break;
    }
    return $chatid;
}

//sumber data
$web_monita_oss = "http://10.35.105.112/MONITA/AREA01/c_frame/get_current_list_alarm_a1?_dc=1533910639050&action=All-All-All-All&filter[0][field]=technical_area_name&filter[0][data][type]=string&filter[0][data][value]=aceh&filter[1][field]=freetext&filter[1][data][type]=string&filter[1][data][value]=Oss";

//filter untuk DMT
$web_monita_oss_dmt = $web_monita_oss ."&filter[2][field]=tower_provider_name&filter[2][data][type]=string&filter[2][data][value]=Dayamitra&filter[3][field]=status_alarm&filter[3][data][type]=string&filter[3][data][value]=FULL&page=1&start=0&limit=10000";

//filter untuk TBG
$web_monita_oss_tbg = $web_monita_oss ."&filter[2][field]=tower_provider_name&filter[2][data][type]=string&filter[2][data][value]=bersama&filter[3][field]=status_alarm&filter[3][data][type]=string&filter[3][data][value]=FULL&page=1&page=1&start=0&limit=10000";


//mengolah data json
function json_oss ($data_oss){	
    $data_monita_oss = file_get_contents($data_oss);
    $data = preg_replace("/\'/",'"',$data_monita_oss);
    $replace = array(
    				'success:' => '"success":',
    				'jml:' => '"jml":',
    				'data:' => '"data":'
    				);
    $data = strtr($data_monita_oss, $replace);
    $data_json = json_decode($data,true);
    return $data_json;
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
 
    if ($data_open["data"][$i][2]==$tp and $data_open["data"][$i][5]=="pln off" ) {
        echo $data_open["data"][$i][2]."|".$data_open["data"][$i][1] . "\n";
        $gabung[] = $data_open["data"][$i][3];
        
    }
}
return $gabung;
}

function mengolah_json($web){
//kita coba punya tbg
//pertama decode dulu punya tbg
$data_json_decode = json_oss($web);
//membuat array
$batas_data = count($data_json_decode['data'])-1;
$arraydata = array();
    for ($i=0; $i <= $batas_data ; $i++) { 
         $arraydata[] = $data_json_decode['data'][$i]['site_id'];
    }
    // remove duplicate
    $filter_duplicate_data = array_unique($arraydata,SORT_REGULAR);
    $sorting_data = array_values($filter_duplicate_data);
    return $sorting_data;
}

//oke data yang mau kita buat sudah ada, kita cek dulu quota mbpnya
$alert_tbg = "";
$sorting_tbg = mengolah_json($web_monita_oss_tbg);
$cek_tbg = count($sorting_tbg);
echo $cek_tbg;
$exclude = array("NAD269" , "NAD270" , "JHO066" , "SAB001" , "SGI513" , "SGI029" ,"NAD253") ;
$gabung_total_tbg = cek_quota("TBG");
$jumlahtbg = count ($gabung_total_tbg);
if ($cek_tbg <= 4) {
	$alert_tbg .= "Automasi order TBG, site:"."\n";
    $jumlah = count($sorting_tbg) - 1;
    for ($j=0; $j <= $jumlah; $j++) { 
        if ($jumlahtbg <= 4){
            if (!in_array($sorting_tbg[$j], $exclude)){
        print "order site ".$sorting_tbg[$j]."\n";
        $alert_tbg.=$sorting_tbg[$j]."\n";
        $site_id = $sorting_tbg[$j];
        login("https://sumbagut.toti-telkomsel.com/Auth/login","username=username&password=password&submit=login");
      $webpage = "https://sumbagut.toti-telkomsel.com/Rtp/tiket/autocomplete/?search=".$site_id;
        $data_toti = grab_page("https://sumbagut.toti-telkomsel.com/Rtp/tiket/autocomplete/?search=".$site_id);
        $data_json = json_decode($data_toti,true);
        $batas = count($data_json['results']) - 1;
        if ($data_json['results'][0]['id'] == $site_id){
            $id = $data_json['results'][0]['id'];
            $text = $data_json['results'][0]['text'];
            $text2 = str_replace(' ', '+', $text);
            $name = $data_json['results'][0]['name'];
            $name2 = str_replace(' ', '+', $name);
            $alamat = $data_json['results'][0]['alamat'];
            $alamat2 = str_replace(' ', '+', $alamat);
            $mitra = $data_json['results'][0]['mitra'];
            $web_toti = 'siteid%5B%5D='.$id.'&pilih='.$id.'&name='.$name2.'&alamat='.$alamat2.'&mitra='.$mitra.'&permasalahan=pln+off+power&kategori=POWER&pic=RTPOBNA&kondisi_site=MATI';
            print($web_toti)."\n";
        post_data("https://sumbagut.toti-telkomsel.com/Rtp/tiket/multi_add",$web_toti);
        $jumlahtbg += 1;  
        //======remark monitanya==============
       $bts_id = $site_id;
        $web_ec = 'http://10.35.105.112/MONITA/AREA01/c_frame/get_current_list_alarm_a1?action=All-All-All-All&filter[0][field]=regional_name&filter[0][data][type]=string&filter[0][data][value]=sumbagut&filter[0][field]=bts_id&filter[0][data][type]=string&filter[0][data][value]='.$bts_id.'&start=0&limit=20';
        $data_ec = datajson($web_ec);
        //======bagian EC=======================
            for ($i = 0; $i < $data_ec->jml; $i++){
            $pic = 'asepnur';
            $id_ticket = '7';
            $text = comment($data_ec->data[$i]->id_ticket, $id_ticket, $pic, $data_ec->data[$i]->bts_id, $data_ec->data[$i]->tgl_alarm, $data_ec->data[$i]->status_alarm);
            print $text;
        }
            }
        }
    }
    }
    
} else{
    $alert = "tidak di proses karena melebihi quota MBP TBG, notif ini akan di kirim via telegram";
    kirim_alert($alert);
}
if (count($sorting_tbg)>0) {
    $alert_all .= $alert_tbg;
}

$sorting_dmt = mengolah_json($web_monita_oss_dmt);
$gabung_total_dmt = cek_quota("MITRATEL");
$cek_dmt = count($sorting_dmt);
$jumlahdmt = count ($gabung_total_dmt);
$alert_dmt ="";
if ($cek_dmt <= 4) {
    $alert_dmt .= "Automasi order DMT, site:"."\n";
    $jumlah = count($sorting_dmt) - 1;
        for ($k=0; $k <= $jumlah; $k++) { 
            if ($jumlahdmt <= 4){
                if (!in_array($sorting_dmt[$j], $exclude)){
        print "order site ".$sorting_dmt[$k]."\n";
        $alert_dmt.=$sorting_dmt[$k]."\n";
        $site_id = $sorting_dmt[$k];
        login("https://sumbagut.toti-telkomsel.com/Auth/login","username=username&password=password&submit=login");
      $webpage = "https://sumbagut.toti-telkomsel.com/Rtp/tiket/autocomplete/?search=".$site_id;
        $data_toti = grab_page("https://sumbagut.toti-telkomsel.com/Rtp/tiket/autocomplete/?search=".$site_id);
        $data_json = json_decode($data_toti,true);
        $batas = count($data_json['results']) - 1;
        if ($data_json['results'][0]['id'] == $site_id){
            $id = $data_json['results'][0]['id'];
            $text = $data_json['results'][0]['text'];
            $text2 = str_replace(' ', '+', $text);
            $name = $data_json['results'][0]['name'];
            $name2 = str_replace(' ', '+', $name);
            $alamat = $data_json['results'][0]['alamat'];
            $alamat2 = str_replace(' ', '+', $alamat);
            $mitra = $data_json['results'][0]['mitra'];
            $web_toti = 'siteid%5B%5D='.$text.'&pilih='.$text.'&name='.$name2.'&alamat='.$alamat2.'&mitra='.$mitra.'&permasalahan=pln+off+power&kategori=POWER&pic=RTPOBNA&kondisi_site=DARURAT';
            print($web_toti)."\n";
        //post_data("https://sumbagut.toti-telkomsel.com/Rtp/tiket/multi_add",$web_toti);
        $jumlahdmt += 1;  
        //======remark monitanya==============
       $bts_id = $site_id;
        $web_ec = 'http://10.35.105.112/MONITA/AREA01/c_frame/get_current_list_alarm_a1?action=All-All-All-All&filter[0][field]=regional_name&filter[0][data][type]=string&filter[0][data][value]=sumbagut&filter[0][field]=bts_id&filter[0][data][type]=string&filter[0][data][value]='.$bts_id.'&start=0&limit=20';
        $data_ec = datajson($web_ec);
        //======bagian EC=======================
            for ($i = 0; $i < $data_ec->jml; $i++){
            $pic = 'asepnur';
            $id_ticket = '7';
            $text = comment($data_ec->data[$i]->id_ticket, $id_ticket, $pic, $data_ec->data[$i]->bts_id, $data_ec->data[$i]->tgl_alarm, $data_ec->data[$i]->status_alarm);
            print $text;
            }
        }
    }
}
    }
    
} else{
    $alert = "tidak di proses karena melebihi quota MBP DMT, notif ini akan di kirim via telegram";
    kirim_alert($alert);
}
if (count($sorting_dmt)>0) {
    $alert_all .= $alert_dmt;
}
kirim_alert($alert_all);

?> 