<?php
/**
 * @author Anastasia Sidak <m0st1ce.nastya@gmail.com>
 *
 * @link https://steamcommunity.com/profiles/76561198038416053
 * @link https://github.com/M0st1ce
 *
 * @license GNU General Public License Version 3
 */

namespace app\ext;

class Translate {

    /**
     * @since 0.2
     * @var array
     */
    public $arr_translations = [];

    /**
     * @since 0.2.123
     * @var array
     */
    public $arr_languages = [];

    /**
     * @since 0.2.123
     * @var array
     */
    public $arr_languages_count = [];

    /**
     * Организация работы вэб-приложения с языками и переводами.
     *
     * @since 0.2.123
     */
    function __construct() {

        // Проверка на основную константу.
        defined('IN_LR') != true && die();

        // Получение кэшированного листа переводов.
        $this->arr_translations = file_exists( SESSIONS . 'translator_cache.php' ) ? require SESSIONS . 'translator_cache.php' : $this->create_translator_cache();

        $this->arr_languages = $this->get_arr_languages();

        $this->arr_languages_count = sizeof( $this->arr_languages );
    }

    /**
     * Создать кэш переводов.
     *
     * @since 0.2.122
     */
    public function create_translator_cache() {
        $result_translation = [];

        // Сканирование папки с модулями.
        $scan_modules = array_diff( scandir( MODULES, 1 ), array( '..', '.', 'disabled' ) );

        // Сканирование папки с Паками рангов.
        $scan_ranks_pack = array_diff( scandir( RANKS_PACK, 1 ), array( '..', '.' ) );

        // Цикл перебора описания модулей.
        for ( $i = 0, $c = sizeof( $scan_modules ); $i < $c; $i++ ) {
            // Получение описания определенного модуля.
            $result[ $scan_modules[ $i ] ] = json_decode( file_get_contents( MODULES . $scan_modules[ $i ] . '/description.json') , true);

            // Проверка на поддержку мульти-перевода.
            if ( array_key_exists('translation', $result[ $scan_modules[ $i ] ]['setting'] ) && $result[ $scan_modules[ $i ] ]['setting']['translation'] == 1) {
                // Получение кэша перевода модулей.
                $result_translation[ $scan_modules[ $i ] ] = json_decode( file_get_contents(MODULES . $scan_modules[ $i ] . '/translation.json') , true);
            }
        }

        for ( $i = 0, $c = sizeof( $scan_ranks_pack ); $i < $c; $i++ ):
            $rank_pack[ 'ranks_' . $scan_ranks_pack[ $i ] ] = json_decode( file_get_contents( RANKS_PACK . $scan_ranks_pack[ $i ] . '/title.json' ) , true);
        endfor;

        $result_translation += $rank_pack;

        // Объединение общего кэша мульти-перевода с кэшэм переводов модулей.
        $result_translation += require SESSIONS . 'translator.php';

        // Создание/редактирование кэша мульти-переводов.
        file_put_contents( SESSIONS . 'translator_cache.php', '<?php return '.var_export_min( $result_translation ).";" );

        return $result_translation;
    }

    /**
     * Получить перевод определенной фразы из общего кэша.
     *
     * @since 0.2
     *
     * @param string $phrase        Слово для перевода.
     * @param string $group         Подмассив.
     *
     * @return string               Выводит слово в переводе.
     */
    public function get_translate_phrase( $phrase, $group = '' ) {
        if ( empty ( $group ) ):
            if ( empty ( $this->arr_translations[ $phrase ][ $_SESSION['language'] ] ) ):
                return empty( $this->arr_translations[ $phrase ]['EN'] ) ? 'No Translation' : $this->arr_translations[ $phrase ]['EN'];
            else:
                return $this->arr_translations[ $phrase ][ $_SESSION['language'] ];
            endif;
        else:
            if ( empty ( $this->arr_translations[ $group ][ $phrase ][ $_SESSION['language'] ] ) ):
                return empty( $this->arr_translations[ $group ][ $phrase ]['EN'] ) ? 'No Translation' : $this->arr_translations[ $group ][ $phrase ]['EN'];
            else:
                return $this->arr_translations[ $group ][ $phrase ][ $_SESSION['language'] ];
            endif;
        endif;
    }

    /**
     * Получить перевод определенной фразы из кэша модуля.
     *
     * @since 0.2
     *
     * @param string $module_id         ID модуля.
     * @param string $phrase            Слово для перевода.
     *
     * @return string                   Выводит слово в переводе.
     */
    public function get_translate_module_phrase( $module_id, $phrase ) {
        if ( empty( $this->arr_translations[ $module_id ][ $phrase ][ $_SESSION['language'] ] ) ):
            return empty( $this->arr_translations[ $module_id ][ $phrase ]['EN'] ) ? 'No Translation' : $this->arr_translations[ $module_id ][ $phrase ]['EN'];
        else:
            return $this->arr_translations[ $module_id ][ $phrase ][ $_SESSION['language'] ];
        endif;
    }

    /**
     * Получить список переводов определенного модуля.
     *
     * @since 0.2
     *
     * @param string $module_id         ID модуля.
     *
     * @return array                    Массив переводов.
     */
    public function get_arr_translate_module( $module_id ) {
        return empty( $this->arr_translations[ $module_id ] ) ? [] : $this->arr_translations[ $module_id ];
    }

    /**
     * Получить список языков.
     *
     * @since 0.2.123
     *
     * @return array    Список языков.
     */
    public function get_arr_languages() {
        return file_exists( SESSIONS . 'languages.json' ) ? json_decode( file_get_contents( SESSIONS . 'languages.json' ) , true ) : ['EN', 'RU'];
    }

}