<?php
/**
 * @author SAPSAN 隼 #3604
 *
 * @link https://hlmod.ru/members/sapsan.83356/
 * @link https://github.com/sapsanDev
 *
 * @license GNU General Public License Version 3
 */

namespace app\modules\module_page_lk_impulse\ext;

use app\modules\module_page_lk_impulse\ext\Basefunction;

class Qiwi extends Basefunction{

	public function QProcessPay($post, $signature){
		$us = $this->Decoder($post['bill']['customer']['account']);
		 $this->decod = explode(',', $us);
		 $BChekGateway = $this->BChekGateway('Qiwi');
		 if( empty( $BChekGateway ) ){
		 		header("Content-Type: application/json");
				die('{"error":"1"}');
		 }
		 $invoice_parameters = $post['bill']['amount']['currency'].'|'.$post['bill']['amount']['value'].'|'.$post['bill']['billId'].'|'.$post['bill']['siteId'].'|'.$post['bill']['status']['value'];
		 $sign = hash_hmac('sha256', $invoice_parameters,trim($this->kassa[0]['secret_key_2']));
		 if($sign == $signature){
			 if($post['bill']['status']['value'] == 'PAID'){
				 $BCheckPay = $this->BCheckPay('Qiwi');
				 if( empty( $BCheckPay ) ){
				 	header("Content-Type: application/json");
					die('{"error":"1"}');

				 }
				 if($this->decod[2] != $post['bill']['amount']['value']){
				 	$this->LkAddLog('_NoValidSumm', ['gateway'=>'Qiwi','amount' => $this->decod[2].'/'.$post['bill']['amount']['value']]);
				 	header("Content-Type: application/json");
					die('{"error":"2"}');
				 }
				 $this->BCheckPlayer();
				 $this->BCheckPromo('Qiwi');
				 $this->BUpdateBalancePlayer($this->decod[3],$post['bill']['amount']['value']);
				 $this->BUpdatePay();
				 $this->BNotificationDiscord('Qiwi');
				 $this->LkAddLog('_NewDonat', ['gateway'=>'Qiwi','order'=>$this->decod[1], 'course'=>$this->Translate->get_translate_module_phrase('module_page_lk_impulse','_AmountCourse'), 'amount' => $this->decod[2], 'steam'=>$this->decod[3]]);
				 $admins = $this->db->queryAll( 'Core', 0, 0, "SELECT * FROM lvl_web_admins WHERE flags = 'z' ");
				 foreach( $admins as $key ){
					 $this->Notifications->SendNotification(
					 		 con_steam64to32($key['steamid']), 
					 		 '_GetDonat', 
					 		 ['course'=>$this->Translate->get_translate_module_phrase('module_page_lk_impulse','_AmountCourse'),'amount'=> $post['bill']['amount']['value'],'module_translation'=>'module_page_lk_impulse'],
					 		 '?page=lk&section=payments#p'.$this->decod[1], 
					 		 'money'
					 );
				 }
				 $this->Notifications->SendNotification( 
				 	$this->decod[3], 
				 	'_YouPay', 
				 	['course'=>$this->Translate->get_translate_module_phrase('module_page_lk_impulse','_AmountCourse'),'amount'=> $post['bill']['amount']['value'],'module_translation'=>'module_page_lk_impulse'],
				 	'?page=lk&section=payments#p'.$this->decod[1], 
				 	'money'
				 );
				 header("Content-Type: application/json");
				 echo '{"error":"0"}';
		 	}else {
		 		$this->LkAddLog('Qiwi - NOT PAYED. STATUS: '.$post['bill']['status']['value']);
		 		header("Content-Type: application/json");
				die('{"error":"3"}');
		 	}
		}else {
		 		$this->LkAddLog('_NOTSIGN', ['gateway'=>'Qiwi']);
		 		header("Content-Type: application/json");
				die('{"error":"4"}');
		 	}
	}
}

