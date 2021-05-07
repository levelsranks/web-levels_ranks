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

class Paypal extends Basefunction{

    protected $req;
    protected $res;

  public function PPProcessPay($post = ''){
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
          $BChekGateway = $this->BChekGateway('PayPal');
          if(empty($BChekGateway))
             die('Gatewqy Freekassa not Exist.');
          $BCheckPay = $this->BCheckPay('PayPal');
          if(empty($BCheckPay))
              die('Pay not found');
          if($this->decod[2] != $post['mc_gross'])
          {
            $this->LkAddLog('_NoValidSumm', ['gateway'=>'PayPal','amount' => $this->decod[2].'/'.$post['mc_gross']]);
            die("Amount does't match");
          }
          $this->BCheckPlayer();
          $this->BCheckPromo('PayPal');
          $this->BUpdateBalancePlayer($this->decod[3],$post['mc_gross']);
          $this->BUpdatePay();
          $this->BNotificationDiscord('PayPal');
          $this->LkAddLog('_NewDonat', ['gateway'=>'PayPal','order'=>$this->decod[1], 'course'=>$this->Translate->get_translate_module_phrase('module_page_lk_impulse','_AmountCourse'), 'amount' => $this->decod[2], 'steam'=>$this->decod[3]]);
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
              ['course'=>$this->Translate->get_translate_module_phrase('module_page_lk_impulse','_AmountCourse'),'amount'=> $post['mc_gross'],'module_translation'=>'module_page_lk_impulse'],
              '?page=lk&section=payments#p'.$this->decod[1], 
              'money'
          );
        } else if (strcmp ($this->res, "INVALID") == 0) {
          $this->LkAddLog('PayPal - The response from IPN was: '.$this->res);
        }  
  }
}