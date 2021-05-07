<?php
/**
 * @author SAPSAN 隼 #3604
 *
 * @link https://hlmod.ru/members/sapsan.83356/
 * @link https://github.com/sapsanDev
 *
 * @license GNU General Public License Version 3
 */

use app\modules\module_page_lk_impulse\ext\Freekassa;
use app\modules\module_page_lk_impulse\ext\Interkassa;
use app\modules\module_page_lk_impulse\ext\Unitpay;
use app\modules\module_page_lk_impulse\ext\Qiwi;
use app\modules\module_page_lk_impulse\ext\Webmoney;
use app\modules\module_page_lk_impulse\ext\Robokassa;
use app\modules\module_page_lk_impulse\ext\Yandexmoney;
use app\modules\module_page_lk_impulse\ext\Paypal;
//use app\modules\module_page_lk_impulse\includes\classes\gateways\Paysera;

if( IN_LR != true ){ die( 'Hacking detected' ); }

switch ($_GET['gateway']){

	case 'paypal':
		if(empty($_POST)){ die( 'Hacking detected' ); }
		$Paypal = new Paypal;
		$Paypal->PPProcessPay( $_POST );
	break;

	case 'freekassa':
		if(empty($_POST)){ die( 'Hacking detected' ); }
		$Freekassa = new Freekassa;
		$Freekassa->FKCheckIP();
		$Freekassa->FKCheckSignature($_POST);
		$Freekassa->FKProcessPay($_POST);
	break;

	case 'interkassa':
		if(empty($_POST)){ die( 'Hacking detected' ); }
		$Interkassa = new Interkassa;
		$Interkassa->IKCheckSignature($_POST);
		$Interkassa->IKProcessPay($_POST);
	break;

	case 'unitpay':
		if( empty($_GET['method']) && empty($_GET['params']) ){ die('Hacking....'); };
		$Unitpay = new Unitpay;
		$Unitpay->payerUnit($_GET['method'],$_GET['params']);
	break;

	case 'webmoney':
		if(empty($_POST)){ die( 'Hacking detected' ); }
		$Webmoney = new Webmoney;
		$Webmoney->WBCheckPurse( $_POST );
		$Webmoney->WBCheckSignature( $_POST );
		$Webmoney->WBProcessPay( $_POST );
	break;

	case 'robokassa':
		if(empty($_POST)){ die( 'Hacking detected' ); }
		$Robokassa = new Robokassa;
		$Robokassa->RBCheckSignature( $_POST );
		$Robokassa->RBProcessPay( $_POST );
	break;

	case 'yandexmoney':
		if(empty($_POST)){ die( 'Hacking detected' ); }
		$Yandexmoney = new Yandexmoney;
		$Yandexmoney->YMCheckSignature( $_POST );
		$Yandexmoney->YMProcessPay( $_POST );
	break;
	
	case 'qiwi':
		if( empty( $_SERVER['HTTP_X_API_SIGNATURE_SHA256'] ) && empty( $_POST )){ die( 'Hacking detected' ); }
		$Qiwi = new Qiwi;
		$POST_JSON = file_get_contents("php://input");
		$POST_DE = json_decode( $POST_JSON, true );
		$Qiwi->QProcessPay( $POST_DE, $_SERVER['HTTP_X_API_SIGNATURE_SHA256'] );
	break;

	default:
		die( 'Hacking detected' );
	break;
}