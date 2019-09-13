<?php
/**
 * @author SAPSAN 隼 #3604
 *
 * @link https://hlmod.ru/members/sapsan.83356/
 * @link https://github.com/sapsanDev
 *
 * @license GNU General Public License Version 3
 */

namespace app\modules\module_page_lk_impulse\includes\classes\gateways;

use app\modules\module_page_lk_impulse\includes\classes\gateways\Basefunction;

class Paypal extends Basefunction{

    protected $req;
    protected $res;

  public function step1($post = ''){
            $raw_post_data = file_get_contents('php://input');
            $raw_post_array = explode('&', $raw_post_data);
            $myPost = array();
            foreach ($raw_post_array as $keyval) {
              $keyval = explode ('=', $keyval);
              if (count($keyval) == 2)
                $myPost[$keyval[0]] = urldecode($keyval[1]);
            }
            $this->req = 'cmd=_notify-validate';
            if (function_exists('get_magic_quotes_gpc')) {
              $get_magic_quotes_exists = true;
            }
            foreach ($myPost as $key => $value) {
              if ($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
                $value = urlencode(stripslashes($value));
              } else {
                $value = urlencode($value);
              }
              $this->req .= "&$key=$value";
            }

          $ch = curl_init('https://ipnpb.paypal.com/cgi-bin/webscr');
          curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
          curl_setopt($ch, CURLOPT_POST, 1);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
          curl_setopt($ch, CURLOPT_POSTFIELDS, $this->req);
          curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
          curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
          curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
          curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));
          if ( !($this->res = curl_exec($ch)) ) {
            $this->addLog('PayPal - Получил '.curl_error($ch).'при обработке данных IPN');
            curl_close($ch);
            exit;
          }
          curl_close($ch);
          
         if (strcmp ($this->res, "VERIFIED") == 0){
          $us = $this->Decoder($post['item_number']);
          $this->decod = explode(',', $us);
          $checkKassa = $this->checkKassa('PayPal');
          $checkPay = $this->checkPay('PayPal');
          if(empty($checkKassa))exit;
          if(empty($checkPay))exit;
          if($this->decod[2] != $post['mc_gross'])
            exit($this->addLog('PayPal - Не совподает сумма : '.$this->decod[2].'/'.$post['mc_gross']));
          $this->checkPlayer();
          $this->checkPromo('PayPal');
          $this->updateBalance($this->decod[3],$post['mc_gross']);
          $this->updatePay();
          $this->Discord('PayPal');
          $this->addLog('PayPal - Пополнение баланса на сумму:'.$post['mc_gross'].'руб. SteamID:'.$this->decod[3].' Платеж:#'.$this->decod[1]);
        } else if (strcmp ($this->res, "INVALID") == 0) {
          $this->addLog('PayPal - The response from IPN was: '.$this->res);
        }  
  }
}