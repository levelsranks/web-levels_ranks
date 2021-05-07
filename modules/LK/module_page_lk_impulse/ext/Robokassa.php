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

class Robokassa extends Basefunction{

	public function RBCheckSignature($post){
			$us = $this->Decoder($post['Shp_mysign']);
		 	$this->decod = explode(',', $us);
		 	$BChekGateway = $this->BChekGateway('Robokassa');
		 	if(empty($BChekGateway))exit;
			$sign = strtoupper(md5($post['OutSum'].':'.$post['InvId'].':'.trim($this->kassa[0]['secret_key_2']).':Shp_mysign='.$post['Shp_mysign']));
			if($sign != strtoupper($post['SignatureValue']))
			{
				$this->LkAddLog('_NOTSIGN', ['gateway'=>'Robokassa']);
				die('Invalid digital signature.');
			}
	}

	public function RBProcessPay($post){
		 $BCheckPay = $this->BCheckPay('Robokassa');
		 if(empty($BCheckPay))exit;
		 if($this->decod[2] != $post['OutSum'])
		 {
		 	$this->LkAddLog('_NoValidSumm', ['gateway'=>'Robokassa','amount' => $this->decod[2].'/'.$post['OutSum']]);
		 	die("Amount does't match");
		 }
		 $this->BCheckPlayer();
		 $this->BCheckPromo('Robokassa');
		 $this->BUpdateBalancePlayer($this->decod[3],$post['OutSum']);
		 $this->BUpdatePay();
		 $this->BNotificationDiscord('Robokassa');
		 $this->LkAddLog('_NewDonat', ['gateway'=>'Robokassa','order'=>$this->decod[1], 'course'=>$this->Translate->get_translate_module_phrase('module_page_lk_impulse','_AmountCourse'), 'amount' => $this->decod[2], 'steam'=>$this->decod[3]]);
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
			 	['course'=>$this->Translate->get_translate_module_phrase('module_page_lk_impulse','_AmountCourse'),'amount'=> $post['OutSum'],'module_translation'=>'module_page_lk_impulse'],
			 	'?page=lk&section=payments#p'.$this->decod[1], 
			 	'money'
		);
		 die('YES');
	}
}