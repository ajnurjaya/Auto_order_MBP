<?php 


// function untuk login
function login($url,$data){
    $proxy = '10.59.82.1:8080';
    $fp = fopen("cookie.txt", "w");
    fclose($fp);
    $login = curl_init();
    curl_setopt($login, CURLOPT_COOKIEJAR, "cookie.txt");
    curl_setopt($login, CURLOPT_COOKIEFILE, "cookie.txt");
    curl_setopt($login, CURLOPT_TIMEOUT, 40000);
    curl_setopt($login, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($login, CURLOPT_URL, $url);
    curl_setopt($login, CURLOPT_PROXY, $proxy);
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
    $proxy = '10.59.82.1:8080';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_USERAGENT,"Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.9.1a2pre) Gecko/2008073000 Shredder/3.0a2pre ThunderBrowse/3.2.1.8");
    curl_setopt($ch, CURLOPT_TIMEOUT, 40);
    curl_setopt($ch, CURLOPT_COOKIEFILE, "cookie.txt");
    curl_setopt($ch, CURLOPT_URL, $site);
    curl_setopt($ch, CURLOPT_PROXY, $proxy);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    ob_start();
    return curl_exec ($ch);
    ob_end_clean();
    curl_close ($ch);
}

function post_data($site,$data){
    $proxy = '10.59.82.1:8080';
    $datapost = curl_init();
        $headers = array("Expect:");
        curl_setopt($datapost, CURLOPT_PROXY, $proxy);
    curl_setopt($datapost, CURLOPT_URL, $site);
        curl_setopt($datapost, CURLOPT_TIMEOUT, 40000);
    curl_setopt($datapost, CURLOPT_HEADER, TRUE);
        curl_setopt($datapost, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($datapost, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
    curl_setopt($datapost, CURLOPT_POST, TRUE);
    curl_setopt($datapost, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($datapost, CURLOPT_POSTFIELDS, $data);
        curl_setopt($datapost, CURLOPT_COOKIEFILE, "cookie.txt");
    ob_start();
    return curl_exec ($datapost);
    ob_end_clean();
    curl_close ($datapost);
    unset($datapost);    
}

function kirim_alert($text){
    $TOKEN  = "922932546:AAH3Whuwh_zGJk65wAfEoXmSHK4s_pVa2gQ";
    $pesan  = $text;
    // ----------- code -------------
    $k = 2;
    for ($i=0; $i<=$k; $i++){
    $method = "sendMessage";
    $url    = "https://api.telegram.org/bot" . $TOKEN . "/". $method;
    $proxy = '10.59.82.1:8080';
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
        $chatid = "73248794";
        break;

        case '1':
        $chatid = "309924124";
        break;

        case '0':
        $chatid = "206067320";
        break;
    }
    return $chatid;
}

//function login_toti(){
//include('simple_html_dom.php');
login("https://sumbagut.toti-telkomsel.com/Auth/login","username=rtp_bandaaceh&password=Jbk#1000&submit=login");
$data_close_toti = grab_page("https://sumbagut.toti-telkomsel.com/Rtp/tiket/gettiket_open");
$data_json = json_decode($data_close_toti,true);
//echo $data_json["data"][2][1];

$jumlah_data = count($data_json['data'])-1;

var_dump($data_json["data"][0][3]);

function json_monita($data_oss){
	$web_monita = str_replace(' ', '%20', $data_oss);	
    $data_monita_oss = file_get_contents($web_monita);
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

$alert_close = "Tiket Close By System:" . "\n";
$b = 0;
for ($j=0; $j <= $jumlah_data ; $j++) { 
	if ($data_json["data"][$j][5] == "pln off power") {
			echo $data_json["data"][$j][1]; echo $data_json["data"][$j][3];
			$site_id = $data_json["data"][$j][3];
			$tiket_close = $data_json["data"][$j][1];
			echo $site_id;
			
			$web_monita_off = 'http://10.35.105.112/MONITA/AREA01/c_frame/get_current_list_alarm_a1?_dc=1533910639050&action=All-All-All-All&filter[0][field]=technical_area_name&filter[0][data][type]=string&filter[0][data][value]=aceh&filter[1][field]=site_id&filter[1][data][type]=string&filter[1][data][value]='.$site_id.'&page=1&start=0&limit=10000';
			$data_monita = json_monita($web_monita_off);
			$cek_monita_aktif = 'http://10.35.105.112/MONITA/AREA01/c_frame/get_current_list_alarm_a1?_dc=1533910639050&action=All-All-All-All&filter[0][field]=technical_area_name&filter[0][data][type]=string&filter[0][data][value]=aceh&page=1&start=0&limit=10000';
			$data_cek_monita = json_monita($cek_monita_aktif);
			
			if ($data_monita['jml']==0 and $data_cek_monita['jml']!=0 ) {
				post_data("https://sumbagut.toti-telkomsel.com/Rtp/tiket/skip_rating","id=".$tiket_close);
				$alert_close .= $site_id ."\n";
				$b += 1;
				
			}

	} 
}
if ($b>0) {
	kirim_alert($alert_close);
}


 ?>