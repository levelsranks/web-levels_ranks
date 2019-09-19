<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="<?php echo empty( $Modules->page_description ) ? $General->arr_general['info'] : $Modules->page_description?>">
    <meta property="og:description" content="<?php echo empty( $Modules->page_description ) ? $General->arr_general['info'] : $Modules->page_description?>">
    <meta name="author" content="https//vk.com/M0st1ce">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <title><?php echo empty( $Modules->page_title ) ? $General->arr_general['info'] : $Modules->page_title?></title>
    <meta property="og:title" content="<?php echo empty( $Modules->page_title ) ? $General->arr_general['info'] : $Modules->page_title?>">
<?php if( ! empty( $Modules->page_image ) ) :?>
    <meta property="og:image" content="<?php echo $General->arr_general['site'] . $Modules->page_image?>">
    <link rel="image_src" href="<?php echo $General->arr_general['site'] . $Modules->page_image?>">
    <meta name="twitter:image" content="<?php echo $General->arr_general['site'] . $Modules->page_image?>">
<?php else :?>
    <meta property="og:image" content="<?php echo $og_image = file_exists( CACHE . '/img/global/bar_logo.jpg' ) ? $General->arr_general['site'] . 'storage/cache/img/global/bar_logo.jpg' : copy(CACHE . '/img/global/default_bar_logo.jpg', CACHE . '/img/global/bar_logo.jpg') && $General->arr_general['site'] . 'storage/cache/img/global/bar_logo.jpg'?>">
    <link rel="image_src" href="<?php echo $og_image?>">
    <meta name="twitter:image" content="<?php echo $og_image?>">
<?php endif; ?>
<?php if( empty( $General->arr_general['enable_css_cache'] ) ) :
        for ( $style = 0, $style_s = sizeof( $Modules->css_library ); $style < $style_s; $style++ ):?>
    <link rel="stylesheet" type="text/css" href="<?php echo $General->arr_general['site'] . $Modules->css_library[ $style ]?>">
<?php   endfor;
      else:?>
    <link rel="stylesheet" type="text/css" href="<?php echo ! file_exists( ASSETS_CSS . '/generation/style_generated.min.ver.' . $Modules->actual_library['actual_css_ver'] . '.css' ) ? $General->arr_general['site'] . 'storage/assets/css/themes/' . $General->arr_general['theme'] . '/style' :  $General->arr_general['site'] . 'storage/assets/css/generation/style_generated.min.ver.' . $Modules->actual_library['actual_css_ver']?>.css">
<?php endif; ?>
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css">
    <?php echo $Graphics->get_css_color_palette()?>
    <?php echo $Graphics->get_css_background_image()?>
    <style>.sidebar-collapse .user-sidebar-block { <?php echo ! isset( $_SESSION['steamid32'] ) ? 'height: 59px;' : 'height: 88px;';?></style>
    <script>var avatar=[];var servers=[];var profile;</script>
</head>
<body <?php $_SESSION['sidebar_open'] == false && print 'class="sidebar-collapse"'?>>