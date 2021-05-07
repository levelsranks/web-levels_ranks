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

class Freekassa extends Basefunction{

	public function FKCheckIP(){
		if(!in_array($this->getIP(), array(
						'136.243.38.147','136.243.38.147', 
						'136.243.38.149', '136.243.38.150', 
						'136.243.38.151', '136.243.38.189', 
						'88.198.88.98',	'136.243.38.108',

					))){
				$this->LkAddLog('_DeniedIP', ['gateway' =>'FreeKassa', 'ip'=>$this->getIP()]);
				die('Request from Denied IP');
		}
	}

	public function FKCheckSignature($post){
			$us = $this->Decoder($post['us_sign']);
		 	$this->decod = explode(',', $us);
		 	$BChekGateway = $this->BChekGateway('FreeKassa');
		 	if(empty($BChekGateway))
		 		die('Gatewqy Freekassa not Exist.');
			$sign = md5($this->kassa[0]['shop_id'] .':'.$post['AMOUNT'].':'.trim($this->kassa[0]['secret_key_2']).':'.$post['MERCHANT_ORDER_ID']);
			if($sign != $post['SIGN']){
				$this->LkAddLog('_NOTSIGN', ['gateway'=>'FreeKassa']);
				die('Invalid digital signature.');
			}
	}

	public function FKProcessPay($post){
		$BCheckPay = $this->BCheckPay('FreeKassa');
		 if(empty($BCheckPay))die('Pay not found');
		 if($this->decod[2] != $post['AMOUNT']){
		 	$this->LkAddLog('_NoValidSumm', ['gateway'=>'FreeKassa','amount' => $this->decod[2].'/'.$post['AMOUNT']]);
		 	die("Amount does't match");
		 }
		 $this->BCheckPlayer();
		 $this->BCheckPromo('FreeKassa');
		 $this->BUpdateBalancePlayer($this->decod[3],$post['AMOUNT']);
		 $this->BUpdatePay();
		 $this->BNotificationDiscord('FreeKassa');
		 $this->LkAddLog('_NewDonat', ['gateway'=>'FreeKassa','order'=>$this->decod[1], 'course'=>$this->Translate->get_translate_module_phrase('module_page_lk_impulse','_AmountCourse'), 'amount' => $this->decod[2], 'steam'=>$this->decod[3]]);
		 $admins = $this->db->queryAll( 'Core', 0, 0, "SELECT * FROM lvl_web_admins WHERE flags = 'z' ");
		 foreach( $admins as $key ){
			 $this->Notifications->SendNotification(
			 		 con_steam64to32($key['steamid']), 
			 		 '_GetDonat', 
			 		 ['course'=>$this->Translate->get_translate_module_phrase('module_page_lk_impulse','_AmountCourse'),'amount'=> $post['AMOUNT'],'module_translation'=>'module_page_lk_impulse'],
			 		 '?page=lk&section=payments#p'.$this->decod[1], 
			 		 'money'
			 );
		 }
		 $this->Notifications->SendNotification( 
			 	$this->decod[3], 
			 	'_YouPay', 
			 	['course'=>$this->Translate->get_translate_module_phrase('module_page_lk_impulse','_AmountCourse'),'amount'=> $post['AMOUNT'],'module_translation'=>'module_page_lk_impulse'],
			 	'?page=lk&section=payments#p'.$this->decod[1], 
			 	'money'
		);
		 die('YES');
	}

	protected function getIP(){
			if(isset($_SERVER['HTTP_X_REAL_IP'])) return $_SERVER['HTTP_X_REAL_IP'];
			return $_SERVER['REMOTE_ADDR'];
	}

}

