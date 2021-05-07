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

class Unitpay extends Basefunction{

	public function payerUnit($method,$params){
			$this->CheckIP();
			$us = $this->Decoder($params['account']);
		 	$this->decod = explode(',', $us);
		 	$BChekGateway = $this->BChekGateway('UnitPay');
		 	if(empty($BChekGateway)){
			    $result = array('error' => array('message' => 'Gatewqy UnitPay not Exist.'));
			    $this->hardReturnJson($result);
			 }
		 	if($this->getSignature($method, $params, trim($this->kassa[0]['secret_key_2'])) != $params['signature']){
				$this->LkAddLog('_NOTSIGN', ['gateway'=>'UnitPay']);
				$result = array('error' => array('message' => 'Invalid digital signature.'));
				$this->hardReturnJson($result);
			}else{ 
					switch ($method){
			            case 'check':
			                $this->BCheckPlayer();
			                $BCheckPay = $this->BCheckPay($this->decod[3],$params['orderSum']);
			                if(empty($BCheckPay)){
			                    $result = array('error' => array('message' => 'PAY #'.$this->decod[1].' Not EXIST'));
			                }
			                else $result = array('result' => array('message' => 'OK'));
			                $this->hardReturnJson($result);
			                break;
			            case 'pay':
			            	$this->BCheckPromo('UnitPay');
			                $this->BUpdateBalancePlayer($this->decod[3],$params['orderSum']);
			                $this->BUpdatePay();
			                $this->BNotificationDiscord('UnitPay');
			                $this->LkAddLog('_NewDonat', ['gateway'=>'UnitPay','order'=>$this->decod[1], 'course'=>$this->Translate->get_translate_module_phrase('module_page_lk_impulse','_AmountCourse'), 'amount' => $this->decod[2], 'steam'=>$this->decod[3]]);
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
								 	['course'=>$this->Translate->get_translate_module_phrase('module_page_lk_impulse','_AmountCourse'),'amount'=> $params['orderSum'],'module_translation'=>'module_page_lk_impulse'],
								 	'?page=lk&section=payments#p'.$this->decod[1], 
								 	'money'
							);
			                $result = array('result' => array('message' => 'OK'));
			                $this->hardReturnJson($result);
			                break;
			            case 'error':
			                $result = array('result' => array('message' => 'OK'));
			                $this->hardReturnJson($result);
			                break;
			            default:
			                $result = array('error' => array('message' => 'ERROR'));
			                $this->hardReturnJson($result);
			                break;
			        }
		    }
	}

	public function getSignature($method, array $data, $secretKey) {
			ksort($data);
			unset($data['sign']);
			unset($data['signature']);
			array_push($data, $secretKey);
			array_unshift($data, $method);
	   		return hash('sha256', join('{up}', $data));
	}

	public function hardReturnJson( $arr ){
		    header('Content-Type: application/json');
		    $result = json_encode($arr);
		    die($result);
	}

	public function CheckIP(){
		if(!in_array($this->getIP(),
			array('31.186.100.49','178.132.203.105','52.29.152.23','52.19.56.234')))
		{
			$this->LkAddLog('_DeniedIP', ['gateway' =>'UnitPay', 'ip'=>$this->getIP()]);
			$result = array('error' => array('message' => 'Invalid IP'));
			$this->hardReturnJson($result);

		}
	}

	protected function getIP(){
			if(isset($_SERVER['HTTP_X_REAL_IP'])) return $_SERVER['HTTP_X_REAL_IP'];
			return $_SERVER['REMOTE_ADDR'];
	}
}
