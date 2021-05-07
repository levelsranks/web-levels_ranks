<?php
/**
 * @author SAPSAN 隼 #3604
 *
 * @link https://hlmod.ru/members/sapsan.83356/
 * @link https://github.com/M0st1ce
 *
 * @license GNU General Public License Version 3
 */

namespace app\ext;

class Notifications {

    public $Modules;
    public $Db;
    public $Translate;

	function __construct( $Translate, $Db ) {

        // Проверка на основную константу.
        defined('IN_LR') != true && die();

		$this->Translate = $Translate;

        $this->Db = $Db;

        $this->NotificationDelete();

		$this->NotificationsRender();
	}

	/**
    * Функция оправки уведемлений
    *
    * @param string $steam 			Стим айди уведомляемого
    * @param string $text 			Название перевода
    * @param array $values_insert	Параметры для перевода ['amount'=>100], для установки перевода с модуля указать в параметре 'module_translation'=> название модуля пример ['amount'=>100, 'module_translation'=> module_page_lk]
    * @param string $url 			Ссылка, например на платеж 
    * @param string $icon 			название иконки для отображения
    */
    public function SendNotification( $steam, $text, $values_insert, $url, $icon ) {
        //Проверка Параметров на пустоту
        if($values_insert == null){
            //Если пустые укажем для json что это массив
            $values_insert =[];
        }
        //Устанавливаем параметры для SQL запроса
        $param = [
            'steam' => $steam,
            'text' => $text,
            'values_insert' => json_encode($values_insert),//Формируем Json
            'url' => $url,
            'icon' => $icon,
        ];
        $this->Db->query('Core', 0, 0, "INSERT INTO `lr_web_notifications`(`steam`, `text`, `values_insert`, `url`, `icon`, `seen`, `status`) VALUES ('{$param['steam']}', '{$param['text']}', '{$param['values_insert']}', '{$param['url']}', '{$param['icon']}', 0, 0)");
    }
    
    /**
    * Функция прослушивания на пост запрос о выводе уведемлений
    */
	public function NotificationsRender() {
		//Проверка на ссессию авторизации и на POST запросы
		if( ! empty( $_SESSION['steamid32'] ) && ! empty( $_POST['notific'] ) || ! empty( $_SESSION['steamid32'] ) && ! empty( $_POST['entryid'] ) )
		{
			if(!empty($_POST['notific'])){
				//Если POST о просмотре запроса вызываем функцию обновления уведемления просмотра
				$this->NotificationUpdate($_POST['notific']);
		    } else {
		    	//Вызываем функцию поиска не прочтенных уведомлений
		        $unread = $this->NotificationsEach(true);
		        //Подсчитываем сколько не прочтенных
		        $unread_count = count($unread);
		        //---
		        $count = 0;
		        //Крутим массив полученых данных
		        foreach ($unread as $notification) {
		        	//проверка если уведомлени не больше 6 То подготавливаем html вывод последних 6 уведомлений
		            if ($count < 6) {
		                $notifications[] = array(
		                    'id' => $notification['id'],
		                    'seen' => $notification['seen'],
		                    'url' => $notification['url'],
		                    'html' => '<li onclick="main_notifications_chek('.$notification['id'].')" class="notifications-item list-group-item">
									    	<a href="'.$notification['url'].'" class="list-group-item-text">
									    		<div class="row">
									    			<div class="icon">
										    			<i class="zmdi zmdi-'.$notification['icon'].' zmdi-hc-fw"></i>
										    		</div>
										    		<div class="text">
										    			'.$notification['text'].'
										    		</div>
									    		</div>
									    	</a>
									 	</li>',
		                );
		                ++$count;
		            }
		        }
		        //Вывод
                if ( ! empty( $notifications ) ):
                    echo json_encode(array('count' => $unread_count, 'no_notifications' => $this->Translate->get_translate_phrase('_No_Notifications'), 'notifications' => array_reverse($notifications)));
                    exit;
                else:
                    echo json_encode(array('count' => $unread_count, 'no_notifications' => $this->Translate->get_translate_phrase('_No_Notifications'), 'notifications' => null));
                    exit;
                endif;
		    }
		}
	}

	/**
    * Функция подготовки вывода уведомлений 
    *
    * @param bool $view 	параметр для звукового уведомления
    *
    * @return array         Уведомления которые ещё не были показаны, актуальноость.
    */
	public function NotificationsEach( $view ) {
        $param = ['steam'=> $_SESSION['steamid32']];
        $NotificationsEach = $this->Db->queryAll('Core', 0, 0, "SELECT * FROM `lr_web_notifications` WHERE `status` = 0 AND `steam` = '$param[steam]' ORDER BY id DESC");
        $deliver = [];
        
        foreach($NotificationsEach as $notification){
            $values = json_decode($notification['values_insert']);
            //проверка на перевод 
             if(!empty($values->module_translation)){
            	$text = $this->Translate->get_translate_module_phrase($values->module_translation, $notification['text']);
            }else $text = $this->Translate->get_translate_phrase($notification['text']);

            if(!$values){
                $values = [];
            }
            //Заменяем параметры для мультиязычности
            foreach($values as $key => $val){
                $text = str_replace('%' . $key . '%', $val, $text);
            }
            //собираем параметры в массив
            $deliver[] = array('id' => $notification['id'], 'text' => $text, 'seen' => $notification['seen'], 'url' => $notification['url'], 'icon' => $notification['icon']);
            //Обновлям параметра для звукового уведомления
            if($view && !$notification['seen']){
                $this->Db->query( 'Core', 0, 0, "UPDATE `lr_web_notifications` SET `seen` = 1 WHERE `steam` = '$param[steam]'");
            }
        }
        return $deliver;
    }

    /**
    * Функция обновления статуса уведомлений на прсмотренные 
    *
    * @param int $id 	Айди уведомления
    */
    public function NotificationUpdate($id) {
    	$param = ['steam'=> $_SESSION['steamid32'],'id'=> $id];
        $this->Db->query( 'Core', 0, 0, "UPDATE `lr_web_notifications` SET `status` = 1 WHERE `steam` = '$param[steam]' AND `id` = $param[id]");
    }
    
    /**
    * Удалить просмотренные уведомления
    */
    public function NotificationDelete() {
        $this->Db->query( 'Core', 0, 0, "DELETE FROM `lr_web_notifications` WHERE `seen` = '1'");
    }

    /**
    * Функция вывода всех уведомлений
    *
    */
   	public function GetAllNotifications() {
   		$param = ['steam' => $_SESSION['steamid32']];
        return $this->Db->queryAll('Core', 0, 0, "SELECT * FROM `lr_web_notifications` WHERE `steam` = '$param[steam]'  ORDER BY date DESC");
   	}

   	/**
    * Функция обновления статуса уведомлений на прсмотренные 
    *
    */
   	public function MarkAllNotifications() {
   		$param = ['steam'=> $_SESSION['steamid32']];
        return $this->Db->queryAll('Core', 0, 0, "UPDATE `lr_web_notifications` SET `status` = 1 WHERE `steam` = :'$param[steam]'");
   	}

    public function debuggg(){
        echo 'ok';
    }
}