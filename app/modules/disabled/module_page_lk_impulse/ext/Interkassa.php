<?php
/**
 * @author SAPSAN 隼 #3604
 *
 * @link https://hlmod.ru/members/sapsan.83356/
 * @link https://github.com/M0st1ce
 *
 * @license GNU General Public License Version 3
 */

namespace app\modules\module_page_lk_impulse\ext;

use app\modules\module_page_lk_impulse\ext\Basefunction;

class Interkassa extends Basefunction{

	public function IKCheckSignature($post){
			$us = $this->Decoder($post['ik_x_sign']);
		 	$this->decod = explode(',', $us);
		 	$BChekGateway = $this->BChekGateway('InterKassa');
		 	if(empty($BChekGateway))
		 		die('Gatewqy InterKassa not Exist.');
		 	$dataSet = $post;
			unset($dataSet['ik_sign']);
			ksort($dataSet, SORT_STRING);
			array_push($dataSet, trim($this->kassa[0]['secret_key_2']));
			$signString = implode(':', $dataSet);
			$sign = base64_encode(md5($signString, true));
			if($sign != $post['ik_sign']){
				$this->LkAddLog('_NOTSIGN', ['gateway'=>'InterKassa']);
				die('Invalid digital signature.');
			}
	}

	public function IKProcessPay($post){
		$BCheckPay = $this->BCheckPay('InterKassa');
		 if(empty($BCheckPay))die('Pay not found');
		 if($this->decod[2] != $post['ik_am']){
		 	$this->LkAddLog('_NoValidSumm', ['gateway'=>'InterKassa','amount' => $this->decod[2].'/'.$post['ik_am']]);
		 	die("Amount does't match");
		 }
		 $this->BCheckPlayer();
		 $this->BCheckPromo('InterKassa');
		 $this->BUpdateBalancePlayer($this->decod[3],$post['ik_am']);
		 $this->BUpdatePay();
		 $this->BNotificationDiscord('InterKassa');
		 $this->LkAddLog('_NewDonat', ['gateway'=>'InterKassa','order'=>$this->decod[1], 'course'=>$this->Translate->get_translate_module_phrase('module_page_lk_impulse','_AmountCourse'), 'amount' => $this->decod[2], 'steam'=>$this->decod[3]]);
		 $admins = $this->db->queryAll( 'Core', 0, 0, "SELECT * FROM lvl_web_admins WHERE flags = 'z' ");
		 foreach( $admins as $key ){
			 $this->Notifications->SendNotification(
			 		 con_steam64to32($key['steamid']), 
			 		 '_GetDonat', 
			 		 ['course'=>$this->Translate->get_translate_module_phrase('module_page_lk_impulse','_AmountCourse'),'amount'=> $post['ik_am'],'module_translation'=>'module_page_lk_impulse'],
			 		 'lk/?section=payments#p'.$this->decod[1], 
			 		 'money'
			 );
		 }
		 $this->Notifications->SendNotification( 
		 	$this->decod[3], 
		 	'_YouPay', 
		 	['course'=>$this->Translate->get_translate_module_phrase('module_page_lk_impulse','_AmountCourse'),'amount'=> $post['ik_am'],'module_translation'=>'module_page_lk_impulse'],
		 	'lk/?section=payments#p'.$this->decod[1], 
		 	'money'
		 );
		 die('YES');
	}
}