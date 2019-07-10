.sidebar-offcanvas-desktop {
    display: none
}

li {
    list-style-type: none
}

.sidebar-menu {
    height: 100%;
}

.sidebar-menu .sidebar-icon {
    margin-right: 0;
    display: inline-block
}

.sidebar-menu .sidebar-icon img, .sidebar-menu .sidebar-icon svg {
    width: 19px;
    height: 20px;
    filter: invert(var(--svg))
}

.sidebar-menu .sidebar-icon i {
    font-size: 1.52em;
    width: 1.28571429em;
    text-align: center;
    color: invert(var(--svg))
}

.sidebar-menu .item-name {
    position: absolute;
    top: 18px;
    left: 54px;
    display: inline-block
}

.sidebar-menu > li.active:after {
    content: "";
    display: block;
    width: 5px;
    height: 100%;
    background: #222;
    position: absolute;
    right: 0;
    bottom: 0
}

.sidebar-menu {
    list-style: outside none none;
    padding: 0;
    overflow-y: auto;
    overflow-x: hidden;
    white-space: nowrap
}

.sidebar-menu > li > a {
    text-decoration: none;
    display: block;
    padding-left: 17px;
    padding-top: 15px;
    padding-bottom: 15px;
    font-size: 12px;
    font-weight: 600;
    position: relative
}

.user-info {
    align-items: center;
    display: flex;
    padding-left: 18px;
    padding-top: 8px;
    padding-bottom: 8px
}

.user-sidebar-block {
    background: linear-gradient(45deg, #ffd968, #ff6262)
}

.user-info a img {
    left: 77px;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    vertical-align: bottom !important;
    border: 3px solid #fff
}

.user-info img {
    left: 77px;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    vertical-align: bottom !important;
    border: 3px solid #fff
}

.user-rank {
    align-items: center;
    display: flex;
    padding-left: 18px;
    padding-bottom: 10px;
    position: relative
}

.user-rank-more {
    align-items: center;
    display: flex;
    padding-left: 18px;
    padding-top: 10px;
    padding-bottom: 10px;
    position: relative
}

.user-rank > img {
    max-width: 50px;
    max-height: 20px
}

.user-rank-more > img {
    max-width: 50px;
    max-height: 20px
}

.user-details {
    font-size: 14px;
    font-weight: 600
}

.user-rank .icon-down {
    position: absolute;
    top: -2px;
    right: 8px
}

.user-rank .icon-down img, .user-rank .icon-down svg {
    width: 22px;
    height: 22px;
    filter: var(--svg)
}

.user-rank .icon-down i {
    font-size: 1.52em;
    width: 1.28571429em;
    text-align: center;
    color: #111;
}

.user-details span {
    display: table;
    margin-left: 10px;
    margin-bottom: 3px;
    white-space: nowrap;
    font-weight: 600;
    font-size: 11px;
    text-decoration: none
}

.user-details span a {
    font-weight: 600;
    font-size: 13px;
    text-decoration: none
}

.user-details .user_name {
    font-weight: 600;
    font-size: 14px
}

.rank-details {
    font-size: 12px;
    font-weight: 600;
    margin-left: 10px
}

.rank-mini-li > a {
    text-decoration: none
}

hr {
    border: none;
    height: 3px;
    width: 232px;
    margin-top: 0;
    margin-bottom: 0;
    margin-left: 18px
}

.main-sidebar {
    margin-top: 56px;
    top: 0;
    left: 0;
    height: 100%;
    position: fixed !important;
    width: 270px;
    z-index: 2;
    box-shadow: 0 0 10px rgba(0, 0, 0, .1) !important
}

<?php if( $General->array_general['animations'] == '1' ) {?>
[data-tooltip]:before, [data-tooltip]:after, .tooltip:before, .tooltip:after {
-webkit-transition: opacity 0.2s ease-in-out, visibility 0.2s ease-in-out, -webkit-transform 0.2s cubic-bezier(.71, 1.7, .77, 1.24);
-moz-transition: opacity 0.2s ease-in-out, visibility 0.2s ease-in-out, -moz-transform 0.2s cubic-bezier(.71, 1.7, .77, 1.24);
transition: opacity 0.2s ease-in-out, visibility 0.2s ease-in-out, transform 0.2s cubic-bezier(.71, 1.7, .77, 1.24);
}
<?php } ?>
@media (max-width: 1025px) {

    .global-container {
        margin-left: 0
    }

    .sidebar-collapse .global-container {
        margin-left: 0px
    }

    .main-sidebar {
        margin-top: 56px;
        -webkit-transform: translate(-330px, 0);
        -ms-transform: translate(-330px, 0);
        -o-transform: translate(-330px, 0);
        transform: translate(-330px, 0)
    }

    .sidebar-open .swipe-area {
        -webkit-transform: translate(270px, 0);
        -ms-transform: translate(270px, 0);
        -o-transform: translate(270px, 0);
        transform: translate(270px, 0)
    }

    .swipe-area {
        margin-top: 58px;
        top: 0;
        left: -12px;
        min-height: 100%;
        position: fixed !important;
        width: 30px;
        z-index: 2
    }

    .sidebar-open .swipe-area {
        -webkit-transform: translate(270px, 0);
        -ms-transform: translate(270px, 0);
        -o-transform: translate(270px, 0);
        transform: translate(270px, 0)
    }

    .sidebar-open .main-sidebar {
        overflow-y: auto;
        -webkit-transform: translate(0, 0);
        -ms-transform: translate(0, 0);
        -o-transform: translate(0, 0);
        transform: translate(0, 0)
    }
}

@media (min-width: 1025px) {
    .sidebar-collapse .main-sidebar {
        -webkit-transform: translate(-210px, 0);
        -ms-transform: translate(-210px, 0);
        -o-transform: translate(-210px, 0);
        transform: translate(-210px, 0)
    }

    .sidebar-collapse .sidebar-menu {
        overflow: visible;
    }

    .sidebar-collapse .global-container {
        margin-left: 64px
    }

    .sidebar-collapse .user-details,
    .sidebar-collapse .icon-down,
    .sidebar-collapse .rank-details,
    .sidebar-collapse .user-rank-more{
        display: none;
    }

    .sidebar-collapse .user-sidebar-block {
<?php
if( !isset( $_SESSION['steamid32'] ) ) {
    echo 'height: 59px;';
} else {
    echo 'height: 88px;';
}
?>
    }

    .sidebar-collapse .sidebar-menu .sidebar-icon {
        margin-left: 213px;
    }

    .sidebar-collapse .user-rank {
        position: absolute;
        top: 60px;
        margin-left: 201px;
        padding-right: 10px;
        padding-bottom: 2px;
    }
    .sidebar-collapse .sidebar-menu .item-name {
        display: none;
    }

    .sidebar-collapse .user-rank > img {
        width: 42px;
        height: 18px;
    }

    .sidebar-collapse .user-info a img{
        position: absolute;
        top: 7px;
        margin-left: 140px;
        width: 45px;
        height: 45px;
    }

    .swipe-area {
        margin-top: 58px;
        top: 0;
        left: 260px;
        min-height: 100%;
        position: fixed !important;
        width: 27px;
        z-index: 2
    }

    .sidebar-collapse .swipe-area {
        -webkit-transform: translate(-207px, 0);
        -ms-transform: translate(-207px, 0);
        -o-transform: translate(-207px, 0);
        transform: translate(-207px, 0)
    }
}

.lng-dropdown {
    display: none
}

.treeview-menu {
    display: none;
    list-style: outside none none;
    margin: 0
}

.treeview-menu > li > a {
    display: block
}

.user-rank > i {
    position: absolute;
    right: 21px;
    margin-top: 2px
}