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

class Lk_module{

	public $name;
	public $Modules;
	public $General;
	public $Db;
	public $Notifications;


	public function __construct( $Translate, $Notifications, $General, $Modules, $Db ) {

		$this->Modules = $Modules;
		$this->Translate = $Translate;
		$this->General = $General;
		$this->db = $Db;
		$this->Notifications = $Notifications;
	}

	public function LkBalancePlayer(){
		if(isset($_SESSION['steamid32'])){
			preg_match('/:[0-9]{1}:\d+/i', $_SESSION['steamid32'], $auth);
			$param = ['auth'=> '%'.$auth[0].'%'];
			if($this->db->db_data['lk'][0]['mod'] == 1)
			{
        		$infoUser =$this->db->queryAll('lk', $this->db->db_data['lk'][0]['USER_ID'], $this->db->db_data['lk'][0]['DB_num'], "SELECT cash FROM lk WHERE auth LIKE :auth LIMIT 1", $param);
        		$cash = 'cash';
			}
    		else if($this->db->db_data['lk'][0]['mod'] == 2)
    		{
        		$infoUser =$this->db->queryAll('lk', $this->db->db_data['lk'][0]['USER_ID'], $this->db->db_data['lk'][0]['DB_num'], "SELECT money FROM lk_system WHERE auth LIKE :auth LIMIT 1", $param);
        		$cash = 'money';
    		}
			$this->Modules->set_user_info_text($this->Translate->get_translate_module_phrase('module_page_lk_impulse','_Balance').': '.$this->Translate->get_translate_module_phrase('module_page_lk_impulse','_AmountCourse').' <b class="material-balance">'.number_format($infoUser[0][$cash],0,' ', ' ').'</b>');
		}
	}

	public function LkAllDonats(){
		if( !isset( $_SESSION['user_admin'] ) || IN_LR != true )exit;
		if($this->db->db_data['lk'][0]['mod'] == 1)
			$allDonat = $this->db->queryNum('lk', $this->db->db_data['lk'][0]['USER_ID'], $this->db->db_data['lk'][0]['DB_num'], "SELECT SUM(all_cash) FROM lk");
		else if($this->db->db_data['lk'][0]['mod'] == 2)
			$allDonat = $this->db->queryNum('lk', $this->db->db_data['lk'][0]['USER_ID'], $this->db->db_data['lk'][0]['DB_num'], "SELECT SUM(all_money) FROM lk_system");
		return number_format($allDonat[0],0,' ', ' ');
	}

	public function LkAllDonatsToPayGateway($system){
		if( !isset( $_SESSION['user_admin'] ) || IN_LR != true )exit;
		$params = ['name' => $system];
		$cashSYS = $this->db->queryNum('lk', $this->db->db_data['lk'][0]['USER_ID'], $this->db->db_data['lk'][0]['DB_num'], "SELECT SUM(pay_summ) FROM lk_pays WHERE pay_system = :name AND pay_status = 1", $params);
		if(empty($cashSYS)) return false;
		 return  number_format($cashSYS[0],0,' ', ' ');
	}

	public function LkLogs(){
		if( !isset( $_SESSION['user_admin'] ) || IN_LR != true )exit;
		$alllogs = $this->db->queryAll('lk', $this->db->db_data['lk'][0]['USER_ID'], $this->db->db_data['lk'][0]['DB_num'], "SELECT DISTINCT log_name FROM lk_logs");
		return array_reverse($alllogs);
	}

	public function LkLogContent($log){
		if( !isset( $_SESSION['user_admin'] ) || IN_LR != true )exit;
		if(!preg_match('/^[0-9]{2}\_[0-9]{2}\_[0-9]{4}+$/i', $log)) return [0=>['log_name'=>$log ,'log_time'=>' ','log_content'=>'_Error']];
		$param = ['log_name' => $log];
		$contentLog = $this->db->queryAll('lk', $this->db->db_data['lk'][0]['USER_ID'], $this->db->db_data['lk'][0]['DB_num'], "SELECT * FROM lk_logs WHERE log_name = :log_name",$param);
		if(!empty($contentLog))
			return $contentLog;
		else return [0=>['log_name'=>$log ,'log_time'=>' ','log_content'=>'_LogNotFound']];
			
	}

	public function LkLogdelete($log){
		if( !isset( $_SESSION['user_admin'] ) || IN_LR != true )exit;
		if(!preg_match('/^[0-9]{2}\_[0-9]{2}\_[0-9]{4}+$/i', $log))
			$this->message($this->Translate->get_translate_module_phrase('module_page_lk_impulse','_Error'),'error');
		$param = ['log_name' => $log];
		$this->db->query('lk', $this->db->db_data['lk'][0]['USER_ID'], $this->db->db_data['lk'][0]['DB_num'], "DELETE FROM lk_logs WHERE log_name = :log_name",$param);
		$this->message($this->Translate->get_translate_module_phrase('module_page_lk_impulse','_LogDeleted'),'success');
			
	}

	public function LkDownloadLog($log){
		if(ini_get('zlib.output_compression'))
			  ini_set('zlib.output_compression', 'Off');
			if(preg_match('/^[0-9]{2}\_[0-9]{2}\_[0-9]{4}+$/i', $log))
			{
				$param = ['log_name'=>$log];
				$logs = $this->db->queryAll('lk', $this->db->db_data['lk'][0]['USER_ID'], $this->db->db_data['lk'][0]['DB_num'], "SELECT * FROM lk_logs WHERE log_name = :log_name",$param);
				$logFileHandle = fopen('storage/cache/sessions/'.$log.'.log', 'a');
				foreach ($logs as $key) {
					fwrite($logFileHandle, $key['log_name'].$key['log_time'].LangValReplace($this->Translate->get_translate_module_phrase('module_page_lk_impulse',$key['log_content']), json_decode(str_replace('[]','',$key['log_value']), true))."\r\n");
				}
				fclose($logFileHandle);
			}else return false;
			if(empty($log))return false;
			else if(!file_exists('storage/cache/sessions/'.$log.'.log'))return false;
			header("Pragma: public"); 
			header("Expires: 0");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header("Cache-Control: private",false); 
			header("Content-Type: storage/cache/sessions/");
			header("Content-Disposition: attachment; filename=\"".basename($log.'.log')."\";" );
			header("Content-Transfer-Encoding: binary");
			header("Content-Length: ".filesize('storage/cache/sessions/'.$log.'.log'));
			readfile('storage/cache/sessions/'.$_POST['log_download'].'.log');
			unlink('storage/cache/sessions/'.$log.'.log');
			exit();
	}

	public function LkPromocodes(){
		if( !isset( $_SESSION['user_admin'] ) || IN_LR != true )exit;
		$allcodes = $this->db->queryAll('lk', $this->db->db_data['lk'][0]['USER_ID'], $this->db->db_data['lk'][0]['DB_num'], "SELECT * FROM lk_promocodes");
		return $allcodes;
	}

	public function LkPromoCode($id){
		if( !isset( $_SESSION['user_admin'] ) || IN_LR != true )exit;
		$param = ['id'=>$id];
		$code = $this->db->queryAll('lk', $this->db->db_data['lk'][0]['USER_ID'], $this->db->db_data['lk'][0]['DB_num'], "SELECT * FROM lk_promocodes WHERE id = :id",$param);
		return $code;
	}

	public function LkDiscordData(){
		if( !isset( $_SESSION['user_admin'] ) || IN_LR != true )exit;
		$DiscordData = $this->db->queryAll('lk', $this->db->db_data['lk'][0]['USER_ID'], $this->db->db_data['lk'][0]['DB_num'], "SELECT * FROM lk_discord");
				return $DiscordData[0];
	}

	public function LkGetAllGateways(){
		if( !isset( $_SESSION['user_admin'] ) || IN_LR != true )exit;
		$allGateways = $this->db->queryAll('lk', $this->db->db_data['lk'][0]['USER_ID'], $this->db->db_data['lk'][0]['DB_num'], "SELECT * FROM lk_pay_service");
		return $allGateways;
	}

	public function LkGetGateway($gateway){
		if( !isset( $_SESSION['user_admin'] ) || IN_LR != true )exit;
		$param = ['id' => $this->LkConvertGatewayId($gateway)];
		$Gateway = $this->db->queryAll('lk', $this->db->db_data['lk'][0]['USER_ID'], $this->db->db_data['lk'][0]['DB_num'], "SELECT * FROM lk_pay_service WHERE id = :id",$param);
		return $Gateway;
	}

	public function LkGetGatewaysOn(){
		$allKass = $this->db->queryAll('lk', $this->db->db_data['lk'][0]['USER_ID'], $this->db->db_data['lk'][0]['DB_num'], "SELECT id, name_kassa FROM lk_pay_service WHERE status = 1");
		return $allKass;
	}

	public function LkGetGatewayOn($gateway){
		$param = ['id' => $this->LkConvertGatewayId($gateway)];
		$gatewayExist = $this->db->queryAll('lk', $this->db->db_data['lk'][0]['USER_ID'], $this->db->db_data['lk'][0]['DB_num'], "SELECT * FROM lk_pay_service WHERE status = 1 AND id = :id",$param);
		return $gatewayExist;
	}

	public function LkGetUserData($user){
		if(!preg_match('/^STEAM_[0-9]{1,2}:[0-1]:\d+$/',$user)) return false;
		$param = ['auth' => $user];
		if($this->db->db_data['lk'][0]['mod'] == 1)
			$userdata = $this->db->queryAll('lk', $this->db->db_data['lk'][0]['USER_ID'], $this->db->db_data['lk'][0]['DB_num'], "SELECT * FROM lk WHERE auth  = :auth",$param);
		else if($this->db->db_data['lk'][0]['mod'] == 2)
			$userdata = $this->db->queryAll('lk', $this->db->db_data['lk'][0]['USER_ID'], $this->db->db_data['lk'][0]['DB_num'], "SELECT * FROM lk_system WHERE auth  = :auth",$param);
		return $userdata;
	}

	public function LkGetUserPays($user){
		if(!preg_match('/^STEAM_[0-9]{1,2}:[0-1]:\d+$/',$user)) return false;
		$param = ['auth' => $user];
		$userdata = $this->db->queryAll('lk', $this->db->db_data['lk'][0]['USER_ID'], $this->db->db_data['lk'][0]['DB_num'], "SELECT * FROM lk_pays WHERE pay_auth  = :auth  ORDER BY pay_id DESC",$param);
		return $userdata;
	}

	public function LkGetAllPays(){
		$pays = $this->db->queryAll('lk', $this->db->db_data['lk'][0]['USER_ID'], $this->db->db_data['lk'][0]['DB_num'], "SELECT * FROM lk_pays ORDER BY pay_id DESC");
		return $pays;
	}

	public function LkGetAllPlayers($min, $max){
		if($this->db->db_data['lk'][0]['mod'] == 1)
			return $this->db->queryAll('lk', $this->db->db_data['lk'][0]['USER_ID'], $this->db->db_data['lk'][0]['DB_num'], "SELECT * FROM lk ORDER BY all_cash DESC LIMIT $min, $max");
		else if($this->db->db_data['lk'][0]['mod'] == 2)
			return $this->db->queryAll('lk', $this->db->db_data['lk'][0]['USER_ID'], $this->db->db_data['lk'][0]['DB_num'], "SELECT * FROM lk_system ORDER BY all_money DESC LIMIT $min, $max");
	}

	public function UsersPageMax($max){
		$param = ['max'=>$max];
		if($this->db->db_data['lk'][0]['mod'] == 1)
		return ceil($this->db->queryNum('lk', $this->db->db_data['lk'][0]['USER_ID'], $this->db->db_data['lk'][0]['DB_num'], "SELECT COUNT(*) FROM lk")[0]/$max);
		else if($this->db->db_data['lk'][0]['mod'] == 2)
		return ceil($this->db->queryNum('lk', $this->db->db_data['lk'][0]['USER_ID'], $this->db->db_data['lk'][0]['DB_num'], "SELECT COUNT(*) FROM lk_system")[0]/$max);
	}

	public function LkUsagePromo($promo){
		if(!preg_match('/^[A-z-0-9]{5,15}$/', $promo)) return false;
		$param = ['pay_promo' => $promo];
		$promoData = $this->db->queryAll('lk', $this->db->db_data['lk'][0]['USER_ID'], $this->db->db_data['lk'][0]['DB_num'], "SELECT * FROM lk_pays WHERE pay_promo  = :pay_promo AND pay_status = 1  ORDER BY pay_id DESC", $param);
		return $promoData;
	}

	public function LkAddPromocode($post){
		if( !isset( $_SESSION['user_admin'] ) || IN_LR != true )exit;
		if(empty($post['addpromo']))
			$promo = substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, rand(5,15));
		else $promo = $post['addpromo'];
		if(!preg_match('/^[A-z-0-9]{5,15}$/', $promo))
			$this->message($this->Translate->get_translate_module_phrase('module_page_lk_impulse','_ErrorNamePromo'),'error');
		else if(empty($post['limit']))
			$this->message($this->Translate->get_translate_module_phrase('module_page_lk_impulse','_LimitPromo'),'error');
		else if(!preg_match('/^\d+$/', $post['limit']))
			$this->message($this->Translate->get_translate_module_phrase('module_page_lk_impulse','_LimitField'),'error');
		else if(empty($post['bonuspecent']))
			$this->message($this->Translate->get_translate_module_phrase('module_page_lk_impulse','_EnterBonus'),'error');
		else if(!preg_match('/^[0-9\.]+$/', $post['bonuspecent']))
			$this->message($this->Translate->get_translate_module_phrase('module_page_lk_impulse','_NotCorBonus'),'error');
		$param = ['code' => $promo];
		$expromo = $this->db->queryAll('lk', $this->db->db_data['lk'][0]['USER_ID'], $this->db->db_data['lk'][0]['DB_num'], "SELECT code FROM lk_promocodes WHERE code = :code", $param);
		if(!empty($expromo))
			$this->message($this->Translate->get_translate_module_phrase('module_page_lk_impulse','_ExistPromo'),'error');
		if(empty($post['status']))
			$auth = 0;
		else $auth = 1;
		$params = [
			'code'=>$promo,
			'attempts'=>$post['limit'],
			'percent'=>$post['bonuspecent'],
			'auth'=>$auth
		];
		$this->db->query('lk', $this->db->db_data['lk'][0]['USER_ID'], $this->db->db_data['lk'][0]['DB_num'], "INSERT INTO lk_promocodes(code, percent, attempts, auth1) VALUES(:code, :percent, :attempts, :auth)",$params);
		$this->message(LangValReplace($this->Translate->get_translate_module_phrase('module_page_lk_impulse','_AddedPromo'),['namepromo'=>$promo]),'success');
	}

	public function LkEditPromocode($post){
		if( !isset( $_SESSION['user_admin'] ) || IN_LR != true )exit;
		if(empty($post['editid']))
			$this->message($this->Translate->get_translate_module_phrase('module_page_lk_impulse','_Error'),'error');
		else if(!preg_match('/^\d+$/',$post['editid']))
			$this->message($this->Translate->get_translate_module_phrase('module_page_lk_impulse','_Error'),'error');
		else if(empty($post['editpromo']))
			$this->message($this->Translate->get_translate_module_phrase('module_page_lk_impulse','_EditPromoName'),'error');
		else if(!preg_match('/^[A-z-0-9]{5,15}$/', $post['editpromo']))
			$this->message($this->Translate->get_translate_module_phrase('module_page_lk_impulse','_ErrorNamePromo'),'error');
		else if(empty($post['editlimit']))
			$this->message($this->Translate->get_translate_module_phrase('module_page_lk_impulse','_LimitPromo'),'error');
		else if(!preg_match('/^\d+$/', $post['editlimit']))
			$this->message($this->Translate->get_translate_module_phrase('module_page_lk_impulse','_LimitField'),'error');
		else if(empty($post['editbonuspecent']))
			$this->message($this->Translate->get_translate_module_phrase('module_page_lk_impulse','_EnterBonus'),'error');
		else if(!preg_match('/^[0-9\.]+$/', $post['editbonuspecent']))
			$this->message($this->Translate->get_translate_module_phrase('module_page_lk_impulse','_NotCorBonus'),'error');
		else if(empty($post['status']))
			$auth = 0;
		else $auth = 1;
		$param = ['id' => $post['editid']];
		$expromo =$this->db->queryAll('lk', $this->db->db_data['lk'][0]['USER_ID'], $this->db->db_data['lk'][0]['DB_num'], "SELECT id FROM lk_promocodes WHERE id = :id",$param);
		if(empty($expromo))
			$this->message($this->Translate->get_translate_module_phrase('module_page_lk_impulse','_Error'),'error');
		$params = [
			'id'=>$post['editid'],
			'code'=>$post['editpromo'],
			'attempts'=>$post['editlimit'],
			'percent'=>$post['editbonuspecent'],
			'auth'=>$auth
		];
		$this->db->query('lk', $this->db->db_data['lk'][0]['USER_ID'], $this->db->db_data['lk'][0]['DB_num'], "UPDATE lk_promocodes SET code=:code, percent=:percent, attempts=:attempts, auth1=:auth WHERE id=:id", $params);
		$this->message(LangValReplace($this->Translate->get_translate_module_phrase('module_page_lk_impulse','_EditedPromo'),['namepromo'=>$post['editpromo']]),'success');
	}

	public function LkDeletePromocode($post){
		if( !isset( $_SESSION['user_admin'] ) || IN_LR != true )exit;
		if(empty($post['promocode_delete']))
			$this->message($this->Translate->get_translate_module_phrase('module_page_lk_impulse','_Error'),'error');
		else if(!preg_match('/^\d+$/',$post['promocode_delete']))
			$this->message($this->Translate->get_translate_module_phrase('module_page_lk_impulse','_Error'),'error');
		$param = ['id' => $post['promocode_delete']];
		$expromo =$this->db->queryAll('lk', $this->db->db_data['lk'][0]['USER_ID'], $this->db->db_data['lk'][0]['DB_num'], "SELECT * FROM lk_promocodes WHERE id = :id",$param);
		if(empty($expromo))
			$this->message($this->Translate->get_translate_module_phrase('module_page_lk_impulse','_Error'),'error');
		$this->db->query('lk', $this->db->db_data['lk'][0]['USER_ID'], $this->db->db_data['lk'][0]['DB_num'], "DELETE FROM lk_promocodes WHERE id = :id",$param);
		$this->message($this->Translate->get_translate_module_phrase('module_page_lk_impulse','_DeletedPromo'),'success');
	}

	public function LkAddDiscord($post){
		if( !isset( $_SESSION['user_admin'] ) || IN_LR != true )exit;
		if(empty($post['webhoock_url_offon']))
			$auth = 0;
		else{
			if(empty($post['webhoock_url']))
				$this->message($this->Translate->get_translate_module_phrase('module_page_lk_impulse','_EnterWebhoockUrl'),'error');
			$auth = 1;
		}
		$param = ['url' => $post['webhoock_url'], 'auth' => $auth];
		$allGateways = $this->db->query('lk', $this->db->db_data['lk'][0]['USER_ID'], $this->db->db_data['lk'][0]['DB_num'], "UPDATE lk_discord SET url=:url, auth=:auth",$param);
		$this->message($this->Translate->get_translate_module_phrase('module_page_lk_impulse','_Saved'),'success');
	}

	public function LkAddGateway($post){
			if( !isset( $_SESSION['user_admin'] ) || IN_LR != true )exit;
			$this->LkExistGatewayAdd($post);
			$this->LKvalidateGatewayData($post['gateway'],$post);
			$params = [
				'id' 		=> $this->LkConvertGatewayId($post['gateway']),
				'name'		=> $this->name
			];
			$this->db->query('lk', $this->db->db_data['lk'][0]['USER_ID'], $this->db->db_data['lk'][0]['DB_num'], "INSERT INTO lk_pay_service VALUES(:id, :name, '$post[shopid]', '$post[secret1]', '$post[secret2]', 1)", $params);
			$this->message(LangValReplace($this->Translate->get_translate_module_phrase('module_page_lk_impulse','_AddGateway'),['name'=>$this->name]), 'success');
	}

	public function LkEditGateway($post){
		if( !isset( $_SESSION['user_admin'] ) || IN_LR != true )exit;
		if(isset($_POST['status']))
				$status = 1;
		else 	$status = 0;
		$this->LkNotExistGateway($post['gateway_edit']);
		$this->LKvalidateGatewayData($post['gateway_edit'],$post);
		$params = [
			'id' 		=> $this->LkConvertGatewayId($post['gateway_edit']),
			'status'	=> $status
		];
		$this->db->query('lk', $this->db->db_data['lk'][0]['USER_ID'], $this->db->db_data['lk'][0]['DB_num'], "UPDATE lk_pay_service SET shop_id = '$post[shopid]', secret_key_1 = '$post[secret1]', secret_key_2 = '$post[secret2]', status = :status WHERE id = :id", $params);
		$this->message(LangValReplace($this->Translate->get_translate_module_phrase('module_page_lk_impulse','_DataChangesGateway'),['gateway'=>$this->name]), 'success');
	}

	public function LkDeleteGateway($post){
		if( !isset( $_SESSION['user_admin'] ) || IN_LR != true )exit;
		if(!preg_match('/^\d+$/i', $post['gateway_delete']))
				$this->message($this->Translate->get_translate_module_phrase('module_page_lk_impulse','_Error'), 'error');
		$this->LkNotExistGateway($this->LkConvertGatewayString($post['gateway_delete']));
		$param =['id'=> $post['gateway_delete']];
		$this->db->query('lk', $this->db->db_data['lk'][0]['USER_ID'], $this->db->db_data['lk'][0]['DB_num'], "DELETE FROM lk_pay_service WHERE id = $param[id]");
		$this->message($this->Translate->get_translate_module_phrase('module_page_lk_impulse','_DeletedGateway'),'success');
	}

	public function LkNotExistGateway($gateway){
		$param =['id'=> $this->LkConvertGatewayId($gateway)];
		$gateway = $this->db->queryAll('lk', $this->db->db_data['lk'][0]['USER_ID'], $this->db->db_data['lk'][0]['DB_num'], "SELECT * FROM lk_pay_service WHERE id = :id",$param);
		if(empty($gateway))
			$this->message($this->Translate->get_translate_module_phrase('module_page_lk_impulse','_GetwNoExist'),'error');
	}

	protected function LkExistGatewayAdd($post){
		if( !isset( $_SESSION['user_admin'] ) || IN_LR != true )exit;
		$param =['id'=>$this->LkConvertGatewayId($post['gateway'])];
		$gateway = $this->db->queryAll('lk', $this->db->db_data['lk'][0]['USER_ID'], $this->db->db_data['lk'][0]['DB_num'], "SELECT id FROM lk_pay_service WHERE id = :id",$param);
		if(!empty($gateway))
			$this->message($this->name.$this->Translate->get_translate_module_phrase('module_page_lk_impulse','_GetwExist'), 'error');
	}


	protected function LKvalidateGatewayData($gateway, $post){
		switch ($gateway) {
			case 'freekassa':
				if(empty($post['shopid']))
					$this->message($this->Translate->get_translate_module_phrase('module_page_lk_impulse','_ISID'), 'error');
				else if(empty($post['secret1']))
					$this->message($this->Translate->get_translate_module_phrase('module_page_lk_impulse','_ISEC').' #1', 'error');
				else if(empty($post['secret2']))
					$this->message($this->Translate->get_translate_module_phrase('module_page_lk_impulse','_ISEC').' #2', 'error');
				$this->name = 'FreeKassa';
			break;
			case 'interkassa':
				if(empty($post['shopid']))
					$this->message($this->Translate->get_translate_module_phrase('module_page_lk_impulse','_ISID'), 'error');
				else if(empty($post['secret2']))
					$this->message($this->Translate->get_translate_module_phrase('module_page_lk_impulse','_ISEC'), 'error');
				$this->name = 'InterKassa';
			break;
			case 'robokassa':
				if(empty($post['shopid']))
					$this->message($this->Translate->get_translate_module_phrase('module_page_lk_impulse','_RSID'), 'error');
				else if(empty($post['secret1']))
					$this->message($this->Translate->get_translate_module_phrase('module_page_lk_impulse','_IPASS').' #1', 'error');
				else if(empty($post['secret2']))
					$this->message($this->Translate->get_translate_module_phrase('module_page_lk_impulse','_IPASS').' #2', 'error');
				$this->name = 'RoboKassa';
			break;
			case 'unitpay':
				if(empty($post['secret1']))
					$this->message($this->Translate->get_translate_module_phrase('module_page_lk_impulse','_InPub'),'error');
				else if(empty($post['secret2']))
					$this->message($this->Translate->get_translate_module_phrase('module_page_lk_impulse','_InSec'),'error');
				$this->name = 'UnitPay';
			break;
			case 'yandexmoney':
				if(empty($post['shopid']))
					$this->message($this->Translate->get_translate_module_phrase('module_page_lk_impulse','_IPURSE'),'error');
				else if(empty($post['secret2']))
					$this->message($this->Translate->get_translate_module_phrase('module_page_lk_impulse','_ISEC'),'error');
				$this->name = 'YandexMoney';
			break;
			case 'webmoney':
				if(empty($post['shopid']))
					$this->message($this->Translate->get_translate_module_phrase('module_page_lk_impulse','_IPURSE'),'error');
				else if(empty($post['secret2']))
					$this->message($this->Translate->get_translate_module_phrase('module_page_lk_impulse','_ISEC'),'error');
				$this->name = 'WebMoney';
			break;
			case 'paypal':
				if(empty($post['shopid']))
					$this->message($this->Translate->get_translate_module_phrase('module_page_lk_impulse','_EnterPaypalAccount'),'error');
				$this->name = 'PayPal';
			break;
			case 'qiwi':
				if(empty($post['secret1']))
					$this->message($this->Translate->get_translate_module_phrase('module_page_lk_impulse','_InPub'),'error');
				else if(empty($post['secret2']))
					$this->message($this->Translate->get_translate_module_phrase('module_page_lk_impulse','_InSec'),'error');
				$this->name = 'Qiwi';
			break;
			default:
				$this->message($this->Translate->get_translate_module_phrase('module_page_lk_impulse','_NINT'), 'error');
				break;
		}
	}


	public function status($status){
		if(empty($status))$return = '<i style="color:#d61a1a;" class="zmdi zmdi-minus-circle zmdi-hc-fw"></i>';
		else $return = '<i style="color:#18b518;" class="zmdi zmdi-check-circle zmdi-hc-fw"></i>';
		return $return;
	}

	public function LkDelUsers(){
		if( !isset( $_SESSION['user_admin'] ) || IN_LR != true )exit;
		if($this->db->db_data['lk'][0]['mod'] == 1)
			$this->db->query('lk', $this->db->db_data['lk'][0]['USER_ID'], $this->db->db_data['lk'][0]['DB_num'], "DELETE FROM lk WHERE !cash AND all_cash = 0");
		else if($this->db->db_data['lk'][0]['mod'] == 2)
			$this->db->query('lk', $this->db->db_data['lk'][0]['USER_ID'], $this->db->db_data['lk'][0]['DB_num'], "DELETE FROM lk_system WHERE !money AND all_money = 0");
		$this->message($this->Translate->get_translate_module_phrase('module_page_lk_impulse','_UsersDelete'),'success');
	}

	public function LkUpdateBalance($post){
		if( !isset( $_SESSION['user_admin'] ) || IN_LR != true )exit;
		if(!preg_match('/^STEAM_[0-9]{1,2}:[0-1]:\d+$/',$post['user']))
			$this->message($this->Translate->get_translate_module_phrase('module_page_lk_impulse','_SteamError'),'error');
		if(!preg_match('/^[0-9]{1,5}.[0-9]{1,2}$/', $this->WM($post['new_balance'])))
				$this->message($this->Translate->get_translate_module_phrase('module_page_lk_impulse','_AmountError'),'error');
			$new_balance = $post['new_balance']-$post['old_balance'];
		if($new_balance != 0){
			$params = [	'order'		=> time() % 100000,
						'auth'		=> $post['user'],
						'summ'		=> $new_balance,
						'data'		=> date('d.m.Y в H:i:s'),
						'system'	=> 'admin'
					];
			$this->db->query('lk', $this->db->db_data['lk'][0]['USER_ID'], $this->db->db_data['lk'][0]['DB_num'], "INSERT INTO `lk_pays` (`pay_order`, `pay_auth`, `pay_summ`, `pay_data`, `pay_system`, `pay_promo`, `pay_status`) VALUES($params[order],'$params[auth]',$params[summ],'$params[data]','$params[system]',' ',1)");
			$this->Notifications->SendNotification( 
			 	$post['user'],
			 	'_AdminPay', 
			 	['course'=>$this->Translate->get_translate_module_phrase('module_page_lk_impulse','_AmountCourse'),'amount'=> $new_balance,'module_translation'=>'module_page_lk_impulse'],
			 	'lk/?section=payments#p'.$params['order'],
			 	'money' );
		}
		$params = [
				'auth' 		=> $post['user'],
				'cash'		=> $post['new_balance'],
			];
		if($this->db->db_data['lk'][0]['mod'] == 1)
			$this->db->query('lk', $this->db->db_data['lk'][0]['USER_ID'], $this->db->db_data['lk'][0]['DB_num'], "UPDATE lk SET cash = :cash WHERE auth = :auth",$params);
		else if($this->db->db_data['lk'][0]['mod'] == 2)
			$this->db->query('lk', $this->db->db_data['lk'][0]['USER_ID'], $this->db->db_data['lk'][0]['DB_num'], "UPDATE lk_system SET money = :cash WHERE auth = :auth",$params);
		$this->message(LangValReplace($this->Translate->get_translate_module_phrase('module_page_lk_impulse','_NewBalanceUser'),['user'=>$post['user']]),'success');
	}

	public function LkCleanLogs(){
		if( !isset( $_SESSION['user_admin'] ) || IN_LR != true )exit;
		$mouth = date('m_Y');
		$expromo = $this->db->query('lk', $this->db->db_data['lk'][0]['USER_ID'], $this->db->db_data['lk'][0]['DB_num'], "DELETE FROM lk_logs WHERE log_name NOT LIKE '%$mouth%'");
		$this->message('Логи очищены!'.$mouth,'success');
	}

	public function LkLoadPlayerProfile($link, $type = 0){
		$_SAPIKEY = $this->General->arr_general['web_key'];
		$match = explode('/', $link);
		if(!empty($match[4]))
		{	
			if(preg_match( '/^(7656119)([0-9]{10})$/', $match[4]))
			{
				$get = $this->CurlSend("https://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=".$_SAPIKEY."&steamids=".$match[4]);
				$content = json_decode($get, true);
			}
			else
			{
				$get = $this->CurlSend("http://api.steampowered.com/ISteamUser/ResolveVanityURL/v0001/?key=".$_SAPIKEY."&vanityurl=".$match[4]);
				$castomName = json_decode($get, true);
				$get = $this->CurlSend("https://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=".$_SAPIKEY."&steamids=".$castomName['response']['steamid']);
				$content = json_decode($get, true);
			}
		}
		else if(preg_match( '/^(7656119)([0-9]{10})$/', $link))
		{
			$get = $this->CurlSend("https://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=".$_SAPIKEY."&steamids=".$link);
			$content = json_decode($get, true);
		}
		else if(preg_match('/^STEAM_[0-9]{1,2}:[0-1]:\d+$/',$link))
		{
			$ex =	explode(":", $link);
			$_s64 = $ex[2] * 2 + $ex[1] + '76561197960265728';
			$get = $this->CurlSend("https://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=".$_SAPIKEY."&steamids=".$_s64);
			$content = json_decode($get, true);
		}
		else if(preg_match('/^\[U:(.*)\:(.*)\]$/', $link, $match))
		{
			if(!empty($match[2]))
			{
				$_s64 = $match[2] + '76561197960265728';
				$get = $this->CurlSend("https://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=".$_SAPIKEY."&steamids=".$_s64);
				$content = json_decode($get, true);
			} else return $link;
		}
		if(!empty($content))
		{
			if(!empty($type)) return con_steam64to32($content['response']['players'][0]['steamid']);

			else exit (trim(json_encode(array(
								'img' => $content['response']['players'][0]['avatarfull'],
								'name' => $content['response']['players'][0]['personaname'],
							))));

		}else{
			if(!empty($type)) return $link;
			else return false;
		}

	}

	/**
	* Пользовательские функции интерфейса
	*
	*/
	public function LkOnPayment($post){
		if(empty($post['gatewayPay']))
				$this->message($this->Translate->get_translate_module_phrase('module_page_lk_impulse','_ChangeGateway'), 'error');
		$Gateway = $this->LkGetGatewayOn($post['gatewayPay']);
		$post['steam'] = $this->LkLoadPlayerProfile($post['steam'], 2);
		if(empty($Gateway))
			$this->message($this->Translate->get_translate_module_phrase('module_page_lk_impulse','_GatewayOnNotEzist'), 'error');
		else if(empty($post['steam']))
			$this->message($this->Translate->get_translate_module_phrase('module_page_lk_impulse','_EnterSteam'),'error');
		if(!preg_match('/^STEAM_[0-9]{1,2}:[0-1]:\d+$/',$post['steam']))
				$this->message($this->Translate->get_translate_module_phrase('module_page_lk_impulse','_SteamError'),'error');
		else if(empty($post['amount']))
				$this->message($this->Translate->get_translate_module_phrase('module_page_lk_impulse','_EnterAmount'), 'error');
		else if(!preg_match('/^[0-9]{1,5}.[0-9]{1,2}$/', $this->WM($post['amount'])))
				$this->message($this->Translate->get_translate_module_phrase('module_page_lk_impulse','_AmountError'),'error');
		else if($post['amount'] < 0.01)
				$this->message($this->Translate->get_translate_module_phrase('module_page_lk_impulse','_AmountError'),'error');
		else if(!empty($post['promocode'])){
			if(!preg_match('/^[A-z-0-9]{5,15}$/',$post['promocode']))
				$this->message($this->Translate->get_translate_module_phrase('module_page_lk_impulse','_Error'), 'error');
			$this->checkPromo($post['promocode'], $post['steam']);
		}
		$this->LkNotExistGateway($post['gatewayPay']);
		$this->setPay($post);
	}

	protected function setPay($post){
		$data = $this->LkGetGatewayOn($post['gatewayPay']);
		$order = time() % 100000;
		$desc = $this->Translate->get_translate_module_phrase('module_page_lk_impulse','_OnPayUserDesc').$post['steam'];
		$lk_sign = $this->Encoder($data[0]['id'].','.$order.','.$post['amount'].','.$post['steam']);
		switch ($post['gatewayPay']) {
			case 'freekassa':
				if(empty($data[0]['status']))
					$this->message(LangValReplace($this->Translate->get_translate_module_phrase('module_page_lk_impulse','_GatwayOff'),['name'=>'FreeKassa']),'error');
				$this->LKRegPay($order,$post,'Freekassa');
				$sign = md5($data[0]['shop_id'].':'.$post['amount'].':'.$data[0]['secret_key_1'].':'.$order);
				$this->location('http://www.free-kassa.ru/merchant/cash.php?m='.$data[0]['shop_id'].'&oa='.$post['amount'].'&o='.$order.'&s='.$sign.'&us_sign='.$lk_sign);
				break;
			case 'interkassa':
				if(empty($data[0]['status']))
					$this->message(LangValReplace($this->Translate->get_translate_module_phrase('module_page_lk_impulse','_GatwayOff'),['name'=>'InterKassa']),'error');
					$this->LKRegPay($order,$post,'InterKassa');
					$this->message('<form  method="post" action="https://sci.interkassa.com/"><input name="ik_co_id" value="'.$data[0]['shop_id'].'"><input name="ik_pm_no" value="'.$order.'"><input name="ik_x_sign" value="'.$lk_sign.'"><input name="ik_cur" value="'.$data[0]['secret_key_1'].'"><input name="ik_desc" value="'.$desc.'"><input name="ik_am"  value="'.$post['amount'].'"><input id="punsh" type="submit"></form>','');
				break;
			case 'robokassa':
				if(empty($data[0]['status']))
					$this->message(LangValReplace($this->Translate->get_translate_module_phrase('module_page_lk_impulse','_GatwayOff'),['name'=>'RoboKassa']),'error');
					$this->LKRegPay($order,$post,'RoboKassa');
					$sign = md5($data[0]['shop_id'].':'.$post['amount'].':'.$order.':'.$data[0]['secret_key_1'].':Shp_mysign='.$lk_sign);
					$this->message('<form action="https://merchant.roboxchange.com/Index.aspx" method=POST><input name="MrchLogin" value="'.$data[0]['shop_id'].'"><input name="OutSum" value="'.$post['amount'].'"><input name="SignatureValue" value="'.$sign.'"><input name="InvId" value="'.$order.'"><input name="Desc" value="'.$desc.'"><input name="Shp_mysign" value="'.$lk_sign.'"><input id="punsh" type="submit" ></form>','');
				break;
			case 'unitpay':
				if(empty($data[0]['status']))
					$this->message(LangValReplace($this->Translate->get_translate_module_phrase('module_page_lk_impulse','_GatwayOff'),['name'=>'UnitPay']),'error');
					$this->LKRegPay($order,$post,'UnitPay');
					$sign = hash('sha256', $lk_sign.'{up}RUB{up}'.$desc.'{up}'.$post['amount'].'{up}'.$data[0]['secret_key_2']);
					$this->message('<form action="https://unitpay.ru/pay/'.$data[0]['secret_key_1'].'" method=GET><input name="sum" value="'.$post['amount'].'">
						<input name="account" value="'.$lk_sign.'"><input name="signature" value="'.$sign.'"><input name="desc" value="'.$desc.'"><input name="currency" value="RUB"><input id="punsh" type="submit" ></form>','');
				break;
			case 'yandexmoney':
				if(empty($data[0]['status']))
					$this->message(LangValReplace($this->Translate->get_translate_module_phrase('module_page_lk_impulse','_GatwayOff'),['name'=>'YandexMoney']),'error');
					$this->LKRegPay($order,$post,'YandexMoney');
					$this->message('<form method="POST" action="https://money.yandex.ru/quickpay/confirm.xml"> 
    				<input name="receiver" value="'.$data[0]['shop_id'].'"><input name="quickpay-form" value="shop"><input name="targets" value="'.$desc.'"> 
    				<input name="paymentType" value="PC"><input name="label" value="'.$lk_sign.'"> 
    				<input name="sum" value="'.$post['amount'].'"><input id="punsh" type="submit"></form>','');
				break;
			case 'yandexmoneycard':
				if(empty($data[0]['status']))
					$this->message(LangValReplace($this->Translate->get_translate_module_phrase('module_page_lk_impulse','_GatwayOff'),['name'=>'YandexMoneyCard']),'error');
					$this->LKRegPay($order,$post,'YandexMoneyCard');
					$this->message('<form method="POST" action="https://money.yandex.ru/quickpay/confirm.xml"> 
    				<input name="receiver" value="'.$data[0]['shop_id'].'"><input name="quickpay-form" value="shop"><input name="targets" value="'.$desc.'"> 
    				<input name="paymentType" value="AC"><input name="label" value="'.$lk_sign.'"> 
    				<input name="sum" value="'.$this->WM($post['amount']).'"><input id="punsh" type="submit"></form>','');
				break;
			case 'webmoney':
				if(empty($data[0]['status']))
					$this->message(LangValReplace($this->Translate->get_translate_module_phrase('module_page_lk_impulse','_GatwayOff'),['name'=>'WebMoney']),'error');
					$this->LKRegPay($order,$post,'WebMoney');
					$this->message('<form action="https://merchant.webmoney.ru/lmi/payment.asp" method="POST">
 					<input name="lk_sign" value="'.$lk_sign.'"><input name="LMI_PAYMENT_DESC_BASE64" value="'.base64_encode($desc).'"><input name="LMI_PAYMENT_NO" value="'.$order.'">
 					<input name="LMI_PAYEE_PURSE" value="'.$data[0]['shop_id'].'"><input name="LMI_PAYMENT_AMOUNT" value="'.$post['amount'].'"><input id="punsh" type="submit"></form>','');
				break;	
			case 'paypal':
				if(empty($data[0]['status']))
					$this->message(LangValReplace($this->Translate->get_translate_module_phrase('module_page_lk_impulse','_GatwayOff'),['name'=>'PayPal']),'error');
					$this->LKRegPay($order,$post,'PayPal');
					$this->message('<form action="https://www.paypal.com/cgi-bin/webscr" method="post"><input type="hidden" name="cmd" value="_xclick">
									  <input type="hidden" name="business" value="'.$data[0]['shop_id'].'"><input type="hidden" name="notify_url" value="'.$this->https().get_url(2).'lk/?gateway=paypal"><input type="hidden" name="item_name" value="'.$desc.'"><input type="hidden" name="item_number" value="'.$lk_sign.'">
									  <input type="hidden" name="amount" value="'.$post['amount'].'"><input type="hidden" name="currency_code" value="'.$data[0]['secret_key_1'].'"><input id="punsh" type="submit" name="submit"></form>','');
			case 'qiwi':
				if(empty($data[0]['status']))
					$this->message(LangValReplace($this->Translate->get_translate_module_phrase('module_page_lk_impulse','_GatwayOff'),['name'=>'Qiwi']),'error');
					$this->LKRegPay($order,$post,'Qiwi');
					$this->message('<form action="https://oplata.qiwi.com/create" method="GET"><input type="hidden" name="publicKey" value="'.$data[0]['secret_key_1'].'"><input type="hidden" name="comment" value="'.$desc.'"><input type="hidden" name="account" value="'.$lk_sign.'"><input type="hidden" name="amount" value="'.$post['amount'].'"><input type="hidden" name="successUrl" value="'.$this->https().get_url(2).'">
						<input id="punsh" type="submit" name="submit"></form>','');
				break;			
			
			default:
				$this->message('Error','error');
				break;
		}

	}

	protected function checkPromo($promo,$sid){
		$param = ['code' => $promo];
		$codeInfo = $this->db->queryAll('lk', $this->db->db_data['lk'][0]['USER_ID'], $this->db->db_data['lk'][0]['DB_num'], "SELECT * FROM lk_promocodes WHERE code = :code", $param);
		if(empty($codeInfo))
			$this->message($this->Translate->get_translate_module_phrase('module_page_lk_impulse','_NotFoundPromo'),'error');
		else if($codeInfo[0]['attempts'] <= 0)
			$this->message($this->Translate->get_translate_module_phrase('module_page_lk_impulse','_NoLimitPromo'),'error');
		else if($codeInfo[0]['auth1']){
			preg_match('/:[0-9]{1}:\d+/i', $sid, $auth);
			$params = ['code'=>$promo,'auth' => '%'.$auth[0].'%'];
			$userPromo = $this->db->queryAll('lk', $this->db->db_data['lk'][0]['USER_ID'], $this->db->db_data['lk'][0]['DB_num'], "SELECT pay_promo FROM lk_pays WHERE pay_promo = :code AND pay_status = 1 AND pay_auth LIKE :auth", $params);
			if($userPromo)
				$this->message($this->Translate->get_translate_module_phrase('module_page_lk_impulse','_YouUsePromo'),'error');
		}
	}

	public function LkCalculatePromo($promo,$steam,$amount){
		$steam = $this->LkLoadPlayerProfile($steam, 2);
		if($amount < 0.1)exit (trim(json_encode(array(
							'result' => '<div class="code_error">'.LangValReplace($this->Translate->get_translate_module_phrase('module_page_lk_impulse','_MinAmount'),['course'=>$this->Translate->get_translate_module_phrase('module_page_lk_impulse','_AmountCourse')]).'</div>'
						))));
		else if(!preg_match('/^STEAM_[0-9]{1,2}:[0-1]:\d+$/',$steam))
			exit (trim(json_encode(array(
							'result' => $this->Translate->get_translate_module_phrase('module_page_lk_impulse','_SteamError')
						))));
		else if($amount >=10 && !empty($steam)){
			$param = ['code' => $promo];
			$codeInfo = $this->db->queryAll('lk', $this->db->db_data['lk'][0]['USER_ID'], $this->db->db_data['lk'][0]['DB_num'], "SELECT * FROM lk_promocodes WHERE code = :code", $param);
			if(empty($codeInfo))
				exit (trim(json_encode(array(
							'result' => $this->Translate->get_translate_module_phrase('module_page_lk_impulse','_NotFoundPromo')
						))));
			else if($codeInfo[0]['attempts'] <= 0)
				exit (trim(json_encode(array(
							'result' => $this->Translate->get_translate_module_phrase('module_page_lk_impulse','_NoLimitPromo')
						))));
			else if($codeInfo[0]['auth1']){
				preg_match('/:[0-9]{1}:\d+/i', $steam, $auth);
				$params = ['code'=>$promo,'auth' => '%'.$auth[0].'%'];
				$userPromo = $this->db->queryAll('lk', $this->db->db_data['lk'][0]['USER_ID'], $this->db->db_data['lk'][0]['DB_num'], "SELECT * FROM lk_pays WHERE pay_promo = :code AND pay_status = 1 AND pay_auth LIKE :auth LIMIT 1", $params);
				if($userPromo)
					exit (trim(json_encode(array(
							'result' => $this->Translate->get_translate_module_phrase('module_page_lk_impulse','_YouUsePromo')
						))));
			}
			$bonus = ($amount/100)*$codeInfo[0]['percent'];
			$newAmount = $bonus+$amount;
			exit (trim(json_encode(array(
						'result' => LangValReplace($this->Translate->get_translate_module_phrase('module_page_lk_impulse','_BonusPromoUse'),
										['newamount'=>$newAmount, 'percent'=>$codeInfo[0]['percent']])
					))));

		}
	}

	public function https(){
		if(!empty($_SERVER['HTTPS']) && 'off' !== strtolower($_SERVER['HTTPS']))
		return 'https:';
		else return 'http:';
	}

	protected function LKRegPay($order,$post,$system){
		$params = ['order'		=> $order,
					'auth'		=> $post['steam'],
					'summ'		=> $post['amount'],
					'data'		=> date('d.m.Y H:i:s'),
					'system'	=> $system,
					'promo'		=> $post['promocode'],
				];
		$this->db->query('lk', $this->db->db_data['lk'][0]['USER_ID'], $this->db->db_data['lk'][0]['DB_num'], "INSERT INTO lk_pays(pay_order, pay_auth, pay_summ, pay_data, pay_system, pay_promo, pay_status) VALUES(:order, :auth, :summ, :data, :system, :promo, 0)", $params);
	}

	protected function Encoder($string){
		$return = base64_encode(base64_encode($string));
		return $return;
	}

	protected function WM($summ){
		$ita = explode('.', $summ);
		if(COUNT($ita) == 1){
			$summa = $ita[0].'.00';
		}else{
			$summa = $summ;
		}
		return $summa;
	}

	protected function LkConvertGatewayId($gateway){
		$array = [
			'freekassa'		=> 1,
			'interkassa'	=> 2,
			'robokassa'		=> 3,
			'unitpay'		=> 4,
			'yandexmoney'		=> 5,
			'yandexmoneycard'	=> 5,
			'webmoney'		=> 6,
			'paypal'		=> 7,
			'qiwi'			=> 8,
		];
		return $array[$gateway];
	}

	protected function LkConvertGatewayString($id){
		$array = [
			1 => 'freekassa', 
			2 => 'interkassa',
			3 => 'robokassa',
			4 => 'unitpay',
			5 => 'yandexmoney',
			5 => 'yandexmoneycard',
			6 => 'webmoney',
			7 => 'paypal',
			8 => 'qiwi'
		];
		return $array[$id];
	}

	protected function message($text,$status){
		exit (trim(json_encode(array(
				'text' => $text,
				'status' => $status,
			))));
	}

	protected function location($url){
				exit (trim(json_encode(array(
						'location' => $url,
					))));
	}


	public function LKChart(){
		$cashSYS = $this->db->queryAll('lk', $this->db->db_data['lk'][0]['USER_ID'], $this->db->db_data['lk'][0]['DB_num'], "SELECT * FROM lk_pays WHERE pay_status = 1  ORDER BY pay_id ASC");
		if(!empty($cashSYS)){
			$fff = json_encode($cashSYS);
			$json = json_decode($fff, true);
			$mount_name = [
			    '12' => "Декабрь",
			    '11' => "Ноябрь",
			    '10' => "Октябрь",
			    '09' => "Сентябрь",
			    '08' => "Август",
			    '07' => "Июль",
			    '06' => "Июнь",
			    '05' => "Май",
			    '03' => "Март",
			    '02' => "февраль",
			    '01' => "Январь"
			];

			$c_arr = sizeof( $json );
			for ($i = 0; $i < $c_arr; $i++) {
			    $mount = explode( ".", $json[ $i ]['pay_data'] );
			    $pay = $json[ $i ]['pay_system'];
			    $oldYear = date("Y")-1;
			    if(substr($mount[2],0,-9) == $oldYear){
			    	$end[ $oldYear ][ $pay ] += $json[ $i ]['pay_summ'];
			    }
				else $end[ $mount_name [ $mount[1] ]][ $pay ] += $json[ $i ]['pay_summ'];
			}
			echo "anychart.onDocumentReady(function() {
					anychart.theme('darkEarth');
					var chart = anychart.line();
					chart.animation(true);
					chart.legend().enabled(true).fontSize(12).padding([0, 0, 0, 0]);
					chart.crosshair().enabled(true).yLabel(false).yStroke(null);
					chart.tooltip().positionMode('point');
	  				chart.xAxis().labels().padding(1);
					var dataSet = anychart.data.set([";

			foreach ($end as $key => $value) {
				echo "['$key'";
				foreach ($value as $key2 => $val2) {

					echo ", $val2";

				}
				echo ', 0],';
			}
			echo "]);";
			$i =1;
			foreach ($end as $key => $value) {
				foreach ($value as $key2 => $val) {
					if($one[$key2] != $key2){
						echo "
							seriesData_$i = dataSet.mapAs({'x': 0,'value': $i});
				  			series$key2 = chart.line(seriesData_$i);
							series$key2.name('$key2');
							series$key2.hovered().markers().enabled(true).type('circle').size(2);
							series$key2.tooltip().position('right').anchor('left-center').offsetX(5).offsetY(5);";
							$one[$key2] = $key2;
							$i++;
					}
				}
			}
			echo "chart.container('containerChart');
					chart.draw();});";
		}
	}

	public function CurlSend($url)
	{
		$c = curl_init($url);
		curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
		$url = curl_exec($c);
		return $url;
	}

	public function SearchUser($post){
			$searchTrim = trim($post);
			$Steam = trim($this->LkLoadPlayerProfile($searchTrim, true));
			if(empty($searchTrim))$this->message('Строка поиска пустая', 'error');
			$param = ['search'	=> "%$searchTrim%"];
			if($this->db->db_data['lk'][0]['mod'] == 1)
			{
				$infoUser = $this->db->queryAll('lk', $this->db->db_data['lk'][0]['USER_ID'], $this->db->db_data['lk'][0]['DB_num'], "SELECT * FROM lk WHERE auth LIKE :search ORDER BY all_cash DESC LIMIT 0,20", $param);
					if(empty($infoUser))
							$infoUser = $this->db->queryAll('lk', $this->db->db_data['lk'][0]['USER_ID'], $this->db->db_data['lk'][0]['DB_num'], "SELECT * FROM lk WHERE name LIKE :search ORDER BY all_cash  DESC LIMIT 0,20", $param);
			}
			else if($this->db->db_data['lk'][0]['mod'] == 2)
			{
				$infoUser = $this->db->queryAll('lk', $this->db->db_data['lk'][0]['USER_ID'], $this->db->db_data['lk'][0]['DB_num'], "SELECT * FROM lk_system WHERE auth LIKE :search ORDER BY all_money DESC LIMIT 0,20", $param);
				if(empty($infoUser))
						$infoUser = $this->db->queryAll('lk', $this->db->db_data['lk'][0]['USER_ID'], $this->db->db_data['lk'][0]['DB_num'], "SELECT * FROM lk_system WHERE name LIKE :search ORDER BY all_money  DESC LIMIT 0,20", $param);
			}

    		$_SESSION['search'] = $infoUser;
    		$this->location('lk/?section=search');
		}
}