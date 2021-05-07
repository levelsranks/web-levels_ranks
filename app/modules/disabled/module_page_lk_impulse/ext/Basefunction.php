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

// Импортирование глобального класса отвечающего за работу с модулями.
use app\ext\Modules;

// Импортирование основного глобального класса.
use app\ext\General;

// Импортирование глобального класса отвечающего за работу с базами данных.
use app\ext\Db;

use app\ext\Notifications;

use app\ext\Translate;

use app\ext\AltoRouter;

class Basefunction{

	public $kassa;
	public $decod;
	public $pay;
	public $summ;
	public $bonus;
	public $db;
	public $General;
	public $Modules;
	public $Notifications;
	public $Translate;
	public $Router;

	public function __construct() {
		$this->db =  new Db;
        $this->Translate = new Translate;
        $this->Notifications = new Notifications( $this->Translate, $this->db );
		$this->General = new General( $this->db );
		$this->Router = new AltoRouter;
		empty( $this->General->arr_general['site'] ) && $this->General->arr_general['site'] = '//' . preg_replace('/^(https?:)?(\/\/)?(www\.)?/', '', $_SERVER['HTTP_REFERER']);
		$this->Modules = new Modules( $this->General, $this->Translate, $this->Notifications, $this->Router );
	}

	/**
     * Фунция запроса проверяющий наличие и активности платежного шлюза.
     *
     * @param string $kassa         Навание платежного шлюза.
     * @return bool false|true      Возвращает результат проверки.
     */
	public function BChekGateway($gateway){
		$param = ['id' => $this->decod[0]];
		$this->kassa = $this->db->queryAll('lk', $this->db->db_data['lk'][0]['USER_ID'], $this->db->db_data['lk'][0]['DB_num'], "SELECT * FROM lk_pay_service WHERE id = :id", $param);
		if(empty($this->kassa[0]['status'])){
			$this->LkAddLog('_Foff', ['gateway' =>$gateway]);
				return false;
		}else return true;
	}

	/**
     * Фунция запроса проверяющий наличие платежа.
     *
     * @param string $gateway         Навание платежного шлюза.
     * @return bool false|true      Возвращает результат проверки.
     */
	public function BCheckPay($gateway){
		preg_match('/:[0-9]{1}:\d+/i', $this->decod[3], $auth);
		$params = [
			'order' 	=> $this->decod[1],
			'auth'		=> '%'.$auth[0].'%',
		];
		$this->pay = $this->db->queryAll('lk', $this->db->db_data['lk'][0]['USER_ID'], $this->db->db_data['lk'][0]['DB_num'], "SELECT * FROM lk_pays WHERE pay_order = :order AND pay_auth LIKE :auth AND pay_status = 0", $params);
		if(empty($this->pay)){
				$this->LkAddLog('_PayNotExist', ['course'=>$this->Translate->get_translate_module_phrase('module_page_lk_impulse', '_AmountCourse'),'numberpay' => $this->decod[1], 'steam'=>$this->decod[3],'amount'=>$this->decod[2],'gateway' =>$gateway]);
					return false;
		}else return true;
	}

	/**
     * Фунция запроса проверяющий наличие игрока, при отсутствии добавляет в базу.
     */
	public function BCheckPlayer(){
		preg_match('/:[0-9]{1}:\d+/i', $this->decod[3], $auth);
		$param = ['auth'=>'%'.$auth[0].'%'];
		if($this->db->db_data['lk'][0]['mod'] == 1)
			$player = $this->db->query('lk', $this->db->db_data['lk'][0]['USER_ID'], $this->db->db_data['lk'][0]['DB_num'], "SELECT * FROM lk WHERE auth LIKE :auth LIMIT 1", $param);
		else if($this->db->db_data['lk'][0]['mod'] == 2)
			$player = $this->db->query('lk', $this->db->db_data['lk'][0]['USER_ID'], $this->db->db_data['lk'][0]['DB_num'], "SELECT * FROM lk_system WHERE auth LIKE :auth LIMIT 1", $param);
		if(empty($player)){
			$params = [
				'auth' 		=> $this->decod[3],
				'name'		=> 'LR WEB - LK MODULE BY SAPSAN'
			];
			if($this->db->db_data['lk'][0]['mod'] == 1)
				$this->db->query('lk', $this->db->db_data['lk'][0]['USER_ID'], $this->db->db_data['lk'][0]['DB_num'], "INSERT INTO lk(auth, name, cash, all_cash) VALUES (:auth,:name,0,0)", $params);
			else if($this->db->db_data['lk'][0]['mod'] == 2)
				$this->db->query('lk', $this->db->db_data['lk'][0]['USER_ID'], $this->db->db_data['lk'][0]['DB_num'], "INSERT INTO lk_system(auth, name, money, all_money) VALUES (:auth,:name,0,0)", $params);
		}
	}

	/**
     * Фунция запроса проверяющий наличие промокода.
     *
     * @param string $gateway         Навание платежного шлюза.
     */
	public function BCheckPromo($gateway){
		$param = ['code' => $this->pay[0]['pay_promo']];
		$promoCode = $this->db->queryAll('lk', $this->db->db_data['lk'][0]['USER_ID'], $this->db->db_data['lk'][0]['DB_num'], "SELECT * FROM lk_promocodes WHERE code = :code",$param);
		if(empty($promoCode)){
			$this->summ = $this->decod[2];
		}
		else{
			$this->db->query('lk', $this->db->db_data['lk'][0]['USER_ID'], $this->db->db_data['lk'][0]['DB_num'], "UPDATE lk_promocodes SET attempts = attempts - 1 WHERE code = :code",$param);
			$this->bonus = ($this->decod[2]/100)*$promoCode[0]['percent'];
			$this->summ = $this->bonus+$this->decod[2];

			$this->LkAddLog('_SetPromo',['course'=>$this->Translate->get_translate_module_phrase('module_page_lk_impulse', '_AmountCourse'),'numberpay' => $this->decod[1], 'promocode'=>$this->pay[0]['pay_promo'],'amount'=>$this->bonus,'gateway' =>$gateway]);
		}
	}

	/**
     * Фунция запроса отправляющего уведомление в Discord канал.
     *
     * @param string $kassa         Навание платежного шлюза.
     */
	public function BNotificationDiscord($kassa){
		$ds = $this->db->queryAll('lk', $this->db->db_data['lk'][0]['USER_ID'], $this->db->db_data['lk'][0]['DB_num'], "SELECT * FROM lk_discord");
		if(!empty($ds[0]['auth'])){
			$steam64 = con_steam32to64($this->decod[3]);
			$xml = file_get_contents('https://steamcommunity.com/profiles/'.$steam64.'/?xml=1');
			$profile = simplexml_load_string($xml);
			if(strlen($profile->avatarMedium) > 0)
			{
				$json = json_encode([
    				"username" => (string)$profile->steamID,
    				"avatar_url" => (string)$profile->avatarMedium,
					"file"=>"content",
					"embeds" => 
					[
				        [	
				        	"title" => $this->General->arr_general['full_name'],
				            "type" => "content",
				            "url" => 'http:'.$this->General->arr_general['site'],
				            "color" => hexdec( 'f5aa39' ),
				            "thumbnail" =>
				            [
				                "url" => 'http:'.$this->General->arr_general['site']."app/modules/module_page_lk_impulse/assets/gateways_discord/".mb_strtolower($kassa).".png",
				            ],
				            "footer"=>
				            [
						        "text"=>$this->General->arr_general['full_name'].' '.date('d.m.Y H:i:s'),
						        "icon_url"=> 'http:'.$this->General->arr_general['site']."storage/cache/img/global/logo.png"
						      ],
				            "fields" => 
				            [
				               	[
				                    "name" => $this->Translate->get_translate_module_phrase('module_page_lk_impulse', '_Replenishment'),
				                    "value" => $this->decod[3],
				                    "inline" => true
				                ],
				                [
				                    "name" => $this->Translate->get_translate_module_phrase('module_page_lk_impulse', '_Amount'),
				                    "value" => $this->decod[2],
				                    "inline" => false
				                ]
				            ]
				        ]
				    ]

				]);
			}
			else 
			{
				$json = json_encode([
    				"username" => "NO-STEAM PLAYER",
					"file"=>"content",
					"embeds" =>
					[
				        [	
				        	"title" => $this->General->arr_general['full_name'],
				            "type" => "content",
				            "url" => 'http:'.$this->General->arr_general['site'],
				            "color" => hexdec( 'f5aa39' ),
				            "thumbnail" =>
				            [
				                "url" => 'http:'.$this->General->arr_general['site']."/app/modules/module_page_lk_impulse/assets/gateways_discord/".mb_strtolower($kassa).".png",
				            ],
				            "footer"=>
				            [
						        "text"=>$this->General->arr_general['full_name'].' '.date('d.m.Y H:i:s'),
						        "icon_url"=> 'http:'.$this->General->arr_general['site']."/storage/cache/img/global/logo.png"
						      ],
				            "fields" =>
				            [
				               	[
				                    "name" => $this->Translate->get_translate_module_phrase('module_page_lk_impulse', '_Replenishment'),
				                    "value" => $this->decod[3],
				                    "inline" => true
				                ],
				                [
				                    "name" => $this->Translate->get_translate_module_phrase('module_page_lk_impulse', '_Amount'),
				                    "value" => $this->decod[2],
				                    "inline" => false
				                ]
				            ]
				        ]
				    ]

				]);

			}
			$cl = curl_init($ds[0]['url']);
			curl_setopt($cl, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
			curl_setopt($cl, CURLOPT_POST, 1);
			curl_setopt($cl, CURLOPT_POSTFIELDS, $json);
			curl_exec($cl);
		}
	}

	/**
     * Фунция запроса обновления баланса игрока.
     *
     * @param string $steam         Steam ID игрока к зачислению.
     * @param int $summ        	 	Сумма пополнения.
     */
	public function BUpdateBalancePlayer($steam,$summ){
		preg_match('/:[0-9]{1}:\d+/i', $steam, $auth);

		 $params = [
				'auth' 		=> '%'.$auth[0].'%',
				'cash'		=> $this->summ,
				'all_cash'	=> $summ,
			];
		if($this->db->db_data['lk'][0]['mod'] == 1)
			$this->db->query('lk', $this->db->db_data['lk'][0]['USER_ID'], $this->db->db_data['lk'][0]['DB_num'], "UPDATE lk SET cash = cash + :cash, all_cash = all_cash + :all_cash WHERE auth LIKE :auth", $params);
		else if($this->db->db_data['lk'][0]['mod'] == 2)
			$this->db->query('lk', $this->db->db_data['lk'][0]['USER_ID'], $this->db->db_data['lk'][0]['DB_num'], "UPDATE lk_system SET money = money + :cash, all_money = all_money + :all_cash WHERE auth LIKE :auth", $params);
	}

	/**
     * Фунция запроса обновления статуса платежа.
     */
	public function BUpdatePay(){
		 $params = [
				'auth' 		=> $this->decod[3],
				'order'		=> $this->decod[1],
			];
		$this->db->query('lk', $this->db->db_data['lk'][0]['USER_ID'], $this->db->db_data['lk'][0]['DB_num'], "UPDATE lk_pays SET pay_status = 1 WHERE pay_auth = :auth AND pay_order = :order", $params);
	}
	
	/**
     * Фунция декодирования хеша.
     *
     * @param string $string        Хеш кодировки base64.
     * @param int $summ        	 	Сумма пополнения.
     * @return sting                Возвращает результат декодирования.
     */
	public function Decoder($string){
			$decod = base64_decode(base64_decode($string));
			return $decod;
	}

	/**
     * Фунция записи лога в базу данных.
     *
     * @param string $act        Содержание лога.
     */
	public function LkAddLog($act, $log_value = []){
			$params = [
			'log_name' 		=> date('d_m_Y'),
			'log_value' 	=> json_encode($log_value),//Формируем Json
			'log_time'		=> date('_H:i:s: '),
			'log_content'	=> $act
		];
		$this->db->query('lk', $this->db->db_data['lk'][0]['USER_ID'], $this->db->db_data['lk'][0]['DB_num'], "INSERT INTO lk_logs(log_name, log_value, log_time, log_content) VALUES (:log_name,:log_value,:log_time,:log_content)",$params);
	}
}
