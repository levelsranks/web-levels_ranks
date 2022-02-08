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

class Yandexmoney extends Basefunction{

	public function YMCheckSignature($post){
		$us = $this->Decoder($post['label']);
		$this->decod = explode(',', $us);
		$BChekGateway = $this->BChekGateway('YandexMoney');
		if(empty($BChekGateway))
			die('Gatewqy YandexMoney not Exist.');
		$hash = sha1($post['notification_type'].'&'.$post['operation_id'].'&'.$post['amount'].'&'.$post['currency'].'&'.$post['datetime'].'&'.$post['sender'].'&'.$post['codepro'].'&'.trim($this->kassa[0]['secret_key_2']).'&'.$post['label']);
		if($post['sha1_hash'] != $hash or $post['codepro'] === true or $post['unaccepted'] === true )
		{
			$this->LkAddLog('_NOTSIGN', ['gateway'=>'YandexMoney']);
			die('Invalid digital signature.');
		}
	}

	public function YMProcessPay($post){
		$BCheckPay = $this->BCheckPay('YandexMoney');
		 if(empty($BCheckPay))die('Pay not found');
		 if($this->decod[2] != $post['withdraw_amount']){
		 	$this->LkAddLog('_NoValidSumm', ['gateway'=>'YandexMoney','amount' => $this->decod[2].'/'.$post['withdraw_amount']]);
		 	die("Amount does't match");
		 }
		 $this->BCheckPlayer();
		 $this->BCheckPromo('YandexMoney');
		 $this->BUpdateBalancePlayer($this->decod[3],$post['withdraw_amount']);
		 $this->BUpdatePay();
		 $this->BNotificationDiscord('YandexMoney');
		 $this->LkAddLog('_NewDonat', ['gateway'=>'YandexMoney','order'=>$this->decod[1], 'course'=>$this->Translate->get_translate_module_phrase('module_page_lk_impulse','_AmountCourse'), 'amount' => $this->decod[2], 'steam'=>$this->decod[3]]);
		 $admins = $this->db->queryAll( 'Core', 0, 0, "SELECT * FROM lvl_web_admins WHERE flags = 'z' ");
		 foreach( $admins as $key ){
			 $this->Notifications->SendNotification(
			 		 con_steam64to32($key['steamid']), 
			 		 '_GetDonat', 
			 		 ['course'=>$this->Translate->get_translate_module_phrase('module_page_lk_impulse','_AmountCourse'),'amount'=> $post['AMOUNT'],'module_translation'=>'module_page_lk_impulse'],
			 		 'lk/?section=payments#p'.$this->decod[1], 
			 		 'money'
			 );
		 }
		 $this->Notifications->SendNotification( 
			 	$this->decod[3], 
			 	'_YouPay', 
			 	['course'=>$this->Translate->get_translate_module_phrase('module_page_lk_impulse','_AmountCourse'),'amount'=> $post['withdraw_amount'],'module_translation'=>'module_page_lk_impulse'],
			 	'lk/?section=payments#p'.$this->decod[1], 
			 	'money'
		);
		 die('YES');
	}

}