<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="<?php empty( $data['global']['info'] ) ? print $General->arr_general['info'] : print $data['global']['info']?>">
    <meta property="og:description" content="<?php empty( $data['global']['info'] ) ? print $General->arr_general['info'] : print $data['global']['info']?>">
    <meta name="author" content="https//vk.com/M0st1ce">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <title><?php empty( $data['global']['title'] ) ? print $General->arr_general['full_name'] : print $data['global']['title']?></title>
    <meta property="og:title" content="<?php empty ( $data['global']['title'] ) ? print $General->arr_general['full_name'] : print $data['global']['title']?>">
<?php if( ! empty( $data['global']['avatar'] ) ) :?>
    <meta property="og:image" content="<?php echo $General->arr_general['site'] . $data['global']['avatar']?>">
    <link rel="image_src" href="<?php echo $General->arr_general['site'] . $data['global']['avatar']?>">
    <meta name="twitter:image" content="<?php echo $General->arr_general['site'] . $data['global']['avatar']?>">
<?php else :?>
    <meta property="og:image" content="<?php echo $General->arr_general['site'] . CACHE . 'img/global/bar_logo.jpg'?>">
    <link rel="image_src" href="<?php echo $General->arr_general['site'] . CACHE . 'img/global/bar_logo.jpg'?>">
    <meta name="twitter:image" content="<?php echo $General->arr_general['site'] . CACHE . 'img/global/bar_logo.jpg'?>">
<?php endif; ?>
    <link rel="stylesheet" href="<?php echo $General->arr_general['site']?>storage/assets/css/themes/<?php echo $General->arr_general['theme']?>/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css">
<?php if ( $_SESSION['dark_mode'] == true ) { ?>
    <style>
        :root <?php echo str_replace( ',', ';', str_replace( '"', '', file_get_contents_fix ( 'storage/assets/css/themes/' . $General->arr_general['theme'] . '/dark_mode_palette.json' ) ) )?>
    </style>
<?php } else {?>
    <style>
        :root <?php echo str_replace( ',', ';', str_replace( '"', '', file_get_contents_fix ( 'storage/assets/css/themes/' . $General->arr_general['theme'] . '/original_palette.json' ) ) )?>
    </style>
<?php } ?>
<?php if ( $General->arr_general['animations'] == true ) :?>
    <style>
        .global-container{transition: transform .5s ease-in-out, margin .5s ease-in-out} .offcanvas{transition: transform .5s ease-in-out, margin .5s ease-in-out}
                                                                                         
        [data-tooltip]:before, [data-tooltip]:after, .tooltip:before, .tooltip:after {
            -webkit-transition: opacity 0.2s ease-in-out, visibility 0.2s ease-in-out, -webkit-transform 0.2s cubic-bezier(.71, 1.7, .77, 1.24);
            -moz-transition: opacity 0.2s ease-in-out, visibility 0.2s ease-in-out, -moz-transform 0.2s cubic-bezier(.71, 1.7, .77, 1.24);
            transition: opacity 0.2s ease-in-out, visibility 0.2s ease-in-out, transform 0.2s cubic-bezier(.71, 1.7, .77, 1.24);
        }
    </style>
<?php endif; ?>
    <style>
        .sidebar-collapse .user-sidebar-block {
        <?php
        if( !isset( $_SESSION['steamid32'] ) ) {
            echo 'height: 59px;';
        } else {
              echo 'height: 88px;';
          }
        ?>
        }
    </style>
<?php if ( $General->arr_general['badge_type'] == 1 ) :?>
    <style>
        .badge {
            display: inline-block;
            padding: .35em .6em;
            font-size: 75%;
            font-weight: 500;
            line-height: 1;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
            fill: #ffffff;
            color: #ffffff!important;
            background-color: var(--span-color);
            box-shadow: 0 1px 2px 0 rgba(0,0,0,.16), 0 2px 10px 0 rgba(0,0,0,.12);
        }

        .badge a {
            fill: #ffffff;
            color: #ffffff!important;
        }
    </style>
<?php elseif ( $General->arr_general['badge_type'] == 2 ) :?>
    <style>
        .badge {
            display: inline-block;
            padding: .35em .6em;
            font-size: 75%;
            font-weight: 500;
            line-height: 1;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
            fill: #ffffff;
            color: #ffffff!important;
            background-color: var(--span-color);
            box-shadow: var(--span-color-back) 5px 5px;
        }

        .badge a {
            fill: #ffffff;
            color: #ffffff!important;
            transition-duration: 400ms;
        }
    </style>
<?php endif;?>
<?php if ( $General->arr_general['form_border'] == true ):?>
    <style>
        .badge {border: 0px solid transparent;border-radius: 2px;} .card {border: 0px solid transparent;border-radius: 4px;} .tooltip-left:after, .tooltip-right:after,.tooltip-top:after {border: 0px solid transparent;border-radius: 2px;}
    </style>
<?php endif; ?>
<?php if ( ! empty( $Modules->arr_module_init['page'][ get_section( 'page', 'home' ) ]['css'] ) ):
for ( $i = 0, $c = get_arr_size( $Modules->arr_module_init['page'][ get_section( 'page', 'home' ) ]['css'] ); $i < $c; $i++ ):
    require MODULES . $Modules->arr_module_init['page'][ get_section( 'page', 'home' ) ]['css'][ $i ] . '/assets/css.php';
endfor;
endif;?>
    <script>var avatar=[];var servers=[];var profile;</script>
</head>
<body <?php $_SESSION['sidebar_open'] == false && print 'class="sidebar-collapse"'?>>