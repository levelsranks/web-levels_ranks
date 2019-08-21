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
    <link rel="stylesheet" href="<?php echo $General->arr_general['site']?>/storage/assets/css/generation/style_generated.min.ver.<?php echo $General->arr_general['actual_css_ver']?>.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css">
    <?php echo $Graphics->get_css_color_palette()?>
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
    <script>var avatar=[];var servers=[];var profile;</script>
</head>
<body <?php $_SESSION['sidebar_open'] == false && print 'class="sidebar-collapse"'?>>