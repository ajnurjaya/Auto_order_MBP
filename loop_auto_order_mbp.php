<?php

date_default_timezone_set('Asia/Jakarta');	
function myloop1()
{

	$menit = date('i');
	$jam = date('H');
	
	
    if ($menit == '14' or $menit == '28' or $menit == '45'or $menit == '57' ) {
        shell_exec("php C:/xampp/htdocs/Monita/auto_close_toti_v2_proxy.php");
        print $menit;
        sleep(20);
    }
    if ($jam == '05' or $jam == '06' or $jam == '07' or $jam == '08' or $jam == '09' or $jam == '10' or $jam == '11' or $jam == '12' or $jam == '13' or $jam == '14' or $jam == '15' or $jam == '16' or $jam == '17' or $jam == '18' or $jam == '19' or $jam == '20' or $jam == '21' or $jam == '22' or $jam == '23' ){
    if ($menit == '17' or $menit == '35' or $menit == '50' ) {
        shell_exec("php C:/xampp/htdocs/Monita/auto_order_mbp_ver2.php");
        print $menit;
        sleep(20);
    }
    if ($menit == '25' or $menit == '45' or $menit == '05' ) {
        //shell_exec("php C:/xampp/htdocs/Monita/scrap_mainsfail_v2_proxy.php");
        print $menit;
        sleep(20);
    }
}

  if ($jam == '01'){
  if ($menit == '05'){
  shell_exec("php C:/xampp/htdocs/sheet-api/start2.php");
        print $menit;
        sleep(70);}}
}


while (true) {
    myloop1();
    sleep(20);

}