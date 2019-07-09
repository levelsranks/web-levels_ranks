<?php
/**
 * @author Anastasia Sidak <m0st1ce.nastya@gmail.com>
 *
 * @link https://steamcommunity.com/profiles/76561198038416053
 * @link https://github.com/M0st1ce
 *
 * @license GNU General Public License Version 3
 */
?>
<style>
    .weapon-table th {
        padding: .35rem;
    }
    .weapon-table th img {
        max-width: 54px;
        max-height: 21px;
    }

    .middle-block .hitstats-block .hitstats .back{
        object-fit: cover;
    }

    .skull{
        filter: invert(70%) sepia(64%) saturate(4691%) hue-rotate(345deg) brightness(98%) contrast(91%);
    }

    @media (max-width: 767.98px) {

        .header-profile {
        }

        .profile {
            position: relative;
            white-space: nowrap;
            height: 100%;
            width: 100%;
        }

        .left-block{
            float: left;
            width: 100%;
        }
        .middle-block{
            float: left;
            width: 100%;
            margin-top: 13px;
        }

        .right-block{
            float: left;
            width: 100%;
            margin-top: 13px;
        }

        .user-block{
            position: relative;
            float: left;
            padding: 18px;
            height: 60vw;
            width:100%;
            max-width: 38%;
            text-align: center;
            background-color: var(--sidebar-color);
            border: 0px solid transparent;
            border-radius: 4px;
        }

        .best-weapon-block{
            position: relative;
            display: inline-block;
            margin-left: 13px;
            height: 60vw;
            width:100%;
            max-width: 59.3%;
            padding-top: 15px;
            background-color: var(--sidebar-color);
            text-align: center;
            border: 0px solid transparent;
            border-radius: 4px;
            overflow: hidden;
        }

        .user-block .avatar-block{
            position: relative;
            min-height: 180px;
            width: 100%;
        }

        .user-block .avatar{
            height: 19vw;
            width: auto;
            border-radius: 50%;
            border: 3px solid #fff;
        }
        .user-block .name{
            margin-top: 10px;
            font-size: 3vw;
            font-weight: var(--font-weight-1);
            color: #F17A26;
        }

        .user-block .country{
            font-size: 13px;
            font-weight: var(--font-weight-0);
            color: var(--default-text-color);
        }

        .user-block .rank-img {
            margin-top: 10px;
            width: 10vw;
        }

        .user-block .rank {
            margin-top: 10px;
            font-size: 2.4vw;
            font-weight: var(--font-weight-0);
            margin-bottom: 20px
        }
        .user-block .user-stats {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 40px;
            background-color: #F17A26;
            text-align: center;
            padding-top: 7px;
            color: #ffffff;
            font-size: 17px;
            font-weight: var(--font-weight-3);
            border: 0px solid transparent;
            border-radius: 4px;
        }

        .best-weapon-block .weapons{
            text-align: center;
            height: 20%;
        }

        .best-weapon-block .weapons .kills{
            margin-top: 5px;
            text-align: center;
            font-size: 12px;
            font-weight: var(--font-weight-3);
        }

        .best-weapon-block .weapons li{
            display: inline-block;
            padding-left: 3%;
            padding-right: 3%;
        }

        .best-weapon-block .weapons svg, .best-weapon-block .weapons img{
            width: 12vw;
            max-height: 4vw;
            filter:invert(var(--svg));
        }

        .best-weapon-block .weapon-table{
            height: 80%;
            overflow:auto;
        }

        .best-weapon-block .weapon-table svg, .best-weapon-block .weapon-table img{
            width: 8vw;
            filter:invert(var(--svg));
        }

        .short-stats-block{
            position: relative;
            float: left;
            margin-top: 10px;
            height: 280px;
            max-height: 280px;
            width:100%;
            max-width: 100%;
            padding: 25px;
            background-color: var(--sidebar-color);
            text-align: center;
            border: 0px solid transparent;
            border-radius: 4px;
        }

        .short-stats-block .left-stats-block {
            float:left;
            width: 50%;
        }
        .short-stats-block .right-stats-block {
            margin-left: 50%;
            width: 50%;
        }
        .short-stats-block ul{
            font-size: 13px;
            font-weight: var(--font-weight-0);
            color: var(--default-text-color);
        }
        .short-stats-block li{
            padding-bottom: 5px;
        }
        .short-stats-block .left-stats-block ul{
            text-align: left;
        }
        .short-stats-block .right-stats-block ul{
            text-align: right;
        }

        .skull-block {
            margin-top: 5%;
            width:100%;
            font-size: 14px;
            font-weight: var(--font-weight-0);
        }

        .skull-block .info{
            font-size: 10px;
            color: var(--default-text-color);
            font-weight: var(--font-weight-1);
        }

        .skull-block .left-skull-block {
            float: left;
            width: 27%;
            text-align: center
        }

        .skull-block .center-skull-block {
            display: inline-block;
            width: 39%;
            text-align: center
        }

        .skull-block .right-skull-block {
            float: right;
            width: 34%;
            text-align: center
        }

        .skull-block .left-skull-block .skull{
            display: inline-block;
            width: 62px;
            background-image: url(storage/cache/img/icons/custom/global/skull.svg);
            background-repeat: space;
            height: 24px;
        }

        .skull-block .center-skull-block .skull{
            display: inline-block;
            width: 82px;
            background-image: url(storage/cache/img/icons/custom/global/skull.svg);
            background-repeat: space;
            height: 24px;
        }

        .skull-block .right-skull-block .skull{
            display: inline-block;
            width: 102px;
            background-image: url(storage/cache/img/icons/custom/global/skull.svg);
            background-repeat: space;
            height: 24px;
        }

        .middle-block .best-maps{
            position: relative;
            overflow: hidden;
            float: left;
            height: 100%;
            width: 61.5%;
        }

        .middle-block .up_block{
            position: relative;
            height: 101.2%;
            width: 100%;
        }

        .middle-block .best-maps .map-top{
            width: 97%;
        }

        .middle-block .best-maps .map-bottom{
            width: 100%;
            max-height: 100px;
            margin-top: 45px;
            list-style:none;
        }

        .middle-block .best-maps .map-bottom li{
            display: block;
            float:left;
            width:47%;
            margin-right: 3%;
            margin-bottom: 3%;
        }

        .middle-block .best-maps .map-bottom img{
            object-fit: cover;
            max-width: 100%;
            border-radius: 4px;
        }

        .middle-block .best-maps .map-top img{
            object-fit: cover;
            max-width: 100%;
            border-radius: 4px;
        }

        .middle-block .best-maps .map-top .map-lower {
            margin-top: -33px;
            position: relative;
        }
        .middle-block .map-title-rounds .icon {
            margin-right: 0px;
        }
        .middle-block .map-title-rounds .icon svg {
            fill: #ffffff;
            filter: inherit;
            margin-bottom: 4px;
            width: 10px;
        }

        .middle-block .best-maps .map-bottom .map-lower {
            max-width: 100%;
            position: relative;
        }

        .middle-block .best-maps .map-top .map-one {
            position: absolute;
            height: 28px;
            width: 25px;
            text-align: center;
            vertical-align: center;
            font-weight: 700;
            font-size: 18px;
            color: white;
            background-color: rgba(0, 0, 0, 0.75);
            padding-top: 1px;
            left: 7px;
        }
        .middle-block .best-maps .map-top .map-pretty-name {
            position: absolute;
            height: 28px;
            text-align: center;
            vertical-align: center;
            font-weight: 700;
            font-size: 18px;
            color: black;
            background-color: rgba(255, 255, 255, 0.75);
            padding-top: 1px;
            padding-left: 10px;
            padding-right: 10px;
            left: 33px;
        }
        .middle-block .best-maps .map-top .map-title-rounds {
            position: absolute;
            height: 28px;
            text-align: center;
            vertical-align: center;
            font-weight: 700;
            font-size: 18px;
            color: white;
            background-color: rgba(241, 122, 38, 0.85);
            padding-top: 1px;
            padding-left: 10px;
            padding-right: 10px;
            right: 7px;
        }

        .middle-block .best-maps .map-bottom .map-one {
            position: absolute;
            height: 18px;
            width: 18px;
            text-align: center;
            vertical-align: center;
            font-weight: 700;
            font-size: 11px;
            color: white;
            background-color: rgba(0, 0, 0, 0.75);
            padding-top: 1px;
            left: 7px;
            bottom: 5px;
        }
        .middle-block .best-maps .map-bottom .map-pretty-name {
            position: absolute;
            height: 18px;
            text-align: center;
            vertical-align: center;
            font-weight: 700;
            font-size: 11px;
            color: black;
            background-color: rgba(255, 255, 255, 0.75);
            padding-top: 1px;
            padding-left: 10px;
            padding-right: 10px;
            left: 25px;
            bottom: 5px;
        }
        .middle-block .best-maps .map-bottom .map-title-rounds {
            position: absolute;
            height: 18px;
            text-align: center;
            vertical-align: center;
            font-weight: 700;
            font-size: 11px;
            color: white;
            background-color: rgba(241, 122, 38, 0.85);
            padding-top: 1px;
            padding-left: 10px;
            padding-right: 10px;
            right: 5px;
            bottom: 5px;
        }

        .middle-block .hitstats-block{
            position: relative;
            overflow: hidden;
            float: left;
            width: 38%;
            height: 62vw;
        }

        .middle-block .hitstats-block .hit_player img{
            width: 100%;
            height: 100%;
            filter: brightness(40%);
        }

        .middle-block .hitstats-block .hitstats{
            position: relative;
            width: 100%;
            height: 100%;
        }

        .middle-block .hitstats-block .hitstats .tooltip-top{
            position: absolute;
            width: 100%;
            height: 100%;
        }


        .middle-block .hitstats-block .hitstats .back{
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            border: 0px solid transparent;
            background-size: cover;
            border-radius: 4px;
        }

        .middle-block .hitstats-block .hitstats .hit_head{
            position: absolute;
            height:13.2vw;
            width:12.9vw;
            z-index: 101;
            bottom: 42.5vw;
            left: 14vw;
        }

        .middle-block .hitstats-block .hitstats .hit_body{
            position: absolute;
            height:22vw;
            width: 21vw;
            bottom: 24.6vw;
            left: 8.5vw;
            z-index: 105;
        }

        .middle-block .hitstats-block .hitstats .hit_left_arm{
            position: absolute;
            height:29vw;
            width:9.8vw;
            bottom: 30vw;
            left: 1.3vw;
            z-index: 101;
        }

        .middle-block .hitstats-block .hitstats .hit_right_arm{
            position: absolute;
            height:29vw;
            width:8vw;
            bottom: 14vw;
            left: 26vw;
            z-index: 104;
        }

        .middle-block .hitstats-block .hitstats .hit_left_leg{
            position: absolute;
            height:26.5vw;
            width: 10vw;
            bottom: 0;
            left: 10.5vw;
            z-index: 101;
        }

        .middle-block .hitstats-block .hitstats .hit_right_leg{
            position: absolute;
            height:26vw;
            width: 14vw;
            bottom: 0;
            left: 18vw;
            z-index: 101;
        }

        .middle-block .hitstats-block .hitstats .hit_head:hover,
        .middle-block .hitstats-block .hitstats .hit_body:hover,
        .middle-block .hitstats-block .hitstats .hit_left_arm:hover,
        .middle-block .hitstats-block .hitstats .hit_right_arm:hover,
        .middle-block .hitstats-block .hitstats .hit_left_leg:hover,
        .middle-block .hitstats-block .hitstats .hit_right_leg:hover{
            -webkit-filter: none;
            filter: none;
        }

        .right-block .top{
            position: relative;
            width:100%;
            height: 100%;
            padding-top: 13px;
            background-color: var(--sidebar-color);
            border: 0px solid transparent;
            border-radius: 4px;
        }

        .right-block .top .table thead th {
            font-size: 11px;
            font-weight: var(--font-weight-1);
            color: var(--default-text-color);
            border-bottom: 2px solid var(--table-line);
        }
        .right-block .top .table tbody th {
            color: var(--default-text-color);
            font-size: 10px;
            font-weight: var(--font-weight-1);
            border-bottom: none;
            border-top: 1px solid var(--table-line);
        }
    }
    @media (min-width: 768px) and (max-width: 991.98px) {
        .header-profile {
        }

        .profile {
            position: relative;
            white-space: nowrap;
            height: 100%;
            width: 100%;
        }

        .left-block{
            float: left;
            width: 100%;
            margin-right: 1%;
        }
        .middle-block{
            float: left;
            width: 100%;
        }

        .right-block{
            float: left;
            width: 100%;
        }

        .user-block{
            position: relative;
            float: left;
            padding-top: 25px;
            height: 40vw;
            width:100%;
            max-width: 38%;
            text-align: center;
            background-color: var(--sidebar-color);
            border: 0px solid transparent;
            border-radius: 4px;
        }

        .best-weapon-block{
            position: relative;
            display: inline-block;
            margin-left: 17px;
            height: 40vw;
            width:100%;
            max-width: 59.3%;
            padding-top: 15px;
            background-color: var(--sidebar-color);
            text-align: center;
            border: 0px solid transparent;
            border-radius: 4px;
            overflow: hidden;
        }

        .user-block .avatar-block{
            position: relative;
            min-height: 180px;
            width: 100%;
        }

        .user-block .avatar{
            height: 12vw;
            width: auto;
            border-radius: 50%;
            border: 3px solid #fff;
        }
        .user-block .name{
            margin-top: 10px;
            font-size: 2.2vw;
            font-weight: var(--font-weight-1);
            color: #F17A26;
        }

        .user-block .country{
            font-size: 13px;
            font-weight: var(--font-weight-0);
            color: var(--default-text-color);
        }

        .user-block .rank-img {
            margin-top: 10px;
            width: 70px;
        }

        .user-block .rank {
            margin-top: 10px;
            font-size: 13px;
            font-weight: var(--font-weight-0);
            margin-bottom: 30px
        }
        .user-block .user-stats {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 40px;
            background-color: #F17A26;
            text-align: center;
            padding-top: 7px;
            color: #ffffff;
            font-size: 17px;
            font-weight: var(--font-weight-3);
            border: 0px solid transparent;
            border-radius: 4px;
        }

        .best-weapon-block .weapons{
            text-align: center;
            height: 20%;
        }

        .best-weapon-block .weapons .kills{
            margin-top: 5px;
            text-align: center;
            font-size: 17px;
            font-weight: var(--font-weight-3);
        }

        .best-weapon-block .weapons li{
            display: inline-block;
            padding-left: 3%;
            padding-right: 3%;
        }

        .best-weapon-block .weapons svg, .best-weapon-block .weapons img{
            width: 11vw;
            max-height: 4vw;
            filter:invert(var(--svg));
        }

        .best-weapon-block .weapon-table{
            height: 80%;
            overflow:auto;
        }

        .best-weapon-block .weapon-table svg, .best-weapon-block .weapon-table img{
            filter:invert(var(--svg));
        }

        .short-stats-block{
            position: relative;
            float: left;
            margin-top: 10px;
            height: 280px;
            max-height: 280px;
            width:100%;
            max-width: 100%;
            padding: 25px;
            background-color: var(--sidebar-color);
            text-align: center;
            border: 0px solid transparent;
            border-radius: 4px;
        }

        .short-stats-block .left-stats-block {
            float:left;
            width: 50%;
        }
        .short-stats-block .right-stats-block {
            margin-left: 50%;
            width: 50%;
        }
        .short-stats-block ul{
            font-size: 13px;
            font-weight: var(--font-weight-0);
            color: var(--default-text-color);
        }
        .short-stats-block li{
            padding-bottom: 5px;
        }
        .short-stats-block .left-stats-block ul{
            text-align: left;
        }
        .short-stats-block .right-stats-block ul{
            text-align: right;
        }

        .skull-block {
            margin-top: 5%;
            width:100%;
            font-size: 14px;
            font-weight: var(--font-weight-0);
        }

        .skull-block .info{
            font-size: 12px;
            color: var(--default-text-color);
            font-weight: var(--font-weight-1);
        }

        .skull-block .left-skull-block {
            float: left;
            width: 27%;
            text-align: center
        }

        .skull-block .center-skull-block {
            display: inline-block;
            width: 39%;
            text-align: center
        }

        .skull-block .right-skull-block {
            float: right;
            width: 34%;
            text-align: center
        }

        .skull-block .left-skull-block .skull{
            display: inline-block;
            width: 62px;
            background-image: url(storage/cache/img/icons/custom/global/skull.svg);
            background-repeat: space;
            height: 24px;
        }

        .skull-block .center-skull-block .skull{
            display: inline-block;
            width: 82px;
            background-image: url(storage/cache/img/icons/custom/global/skull.svg);
            background-repeat: space;
            height: 24px;
        }

        .skull-block .right-skull-block .skull{
            display: inline-block;
            width: 102px;
            background-image: url(storage/cache/img/icons/custom/global/skull.svg);
            background-repeat: space;
            height: 24px;
        }

        .middle-block .best-maps{
            position: relative;
            float: left;
            height: 100%;
            width: 64.5%;
        }

        .middle-block .up_block{
            position: relative;
            height: 100%;
            width: 100%;
        }

        .middle-block .best-maps .map-top{
            width: 97%;
        }

        .middle-block .best-maps .map-bottom{
            width: 100%;
            max-height: 100px;
            margin-top: 45px;
            list-style:none;
        }

        .middle-block .best-maps .map-bottom li{
            display: block;
            float:left;
            width:47%;
            margin-right: 3%;
            margin-bottom: 3%;
        }

        .middle-block .best-maps .map-bottom img{
            object-fit: cover;
            min-width: 100%;
            max-width: 100%;
            border-radius: 4px;
        }

        .middle-block .best-maps .map-top img{
            object-fit: cover;
            min-width: 100%;
            max-width: 100%;
            border-radius: 4px;
        }

        .middle-block .best-maps .map-top .map-lower {
            max-width: 100%;
            margin-top: -33px;
            position: relative;
        }
        .middle-block .map-title-rounds .icon {
            margin-right: 0px;
        }
        .middle-block .map-title-rounds .icon svg {
            fill: #ffffff;
            filter: inherit;
            margin-bottom: 4px;
            width: 10px;
        }

        .middle-block .best-maps .map-bottom .map-lower {
            max-width: 100%;
            position: relative;
        }

        .middle-block .best-maps .map-top .map-one {
            position: absolute;
            height: 28px;
            width: 25px;
            text-align: center;
            vertical-align: center;
            font-weight: 700;
            font-size: 18px;
            color: white;
            background-color: rgba(0, 0, 0, 0.75);
            padding-top: 1px;
            left: 7px;
        }
        .middle-block .best-maps .map-top .map-pretty-name {
            position: absolute;
            height: 28px;
            text-align: center;
            vertical-align: center;
            font-weight: 700;
            font-size: 18px;
            color: black;
            background-color: rgba(255, 255, 255, 0.75);
            padding-top: 1px;
            padding-left: 10px;
            padding-right: 10px;
            left: 33px;
        }
        .middle-block .best-maps .map-top .map-title-rounds {
            position: absolute;
            height: 28px;
            text-align: center;
            vertical-align: center;
            font-weight: 700;
            font-size: 18px;
            color: white;
            background-color: rgba(241, 122, 38, 0.85);
            padding-top: 1px;
            padding-left: 10px;
            padding-right: 10px;
            right: 7px;
        }

        .middle-block .best-maps .map-bottom .map-one {
            position: absolute;
            height: 18px;
            width: 18px;
            text-align: center;
            vertical-align: center;
            font-weight: 700;
            font-size: 11px;
            color: white;
            background-color: rgba(0, 0, 0, 0.75);
            padding-top: 1px;
            left: 7px;
            bottom: 5px;
        }
        .middle-block .best-maps .map-bottom .map-pretty-name {
            position: absolute;
            height: 18px;
            text-align: center;
            vertical-align: center;
            font-weight: 700;
            font-size: 11px;
            color: black;
            background-color: rgba(255, 255, 255, 0.75);
            padding-top: 1px;
            padding-left: 10px;
            padding-right: 10px;
            left: 25px;
            bottom: 5px;
        }
        .middle-block .best-maps .map-bottom .map-title-rounds {
            position: absolute;
            height: 18px;
            text-align: center;
            vertical-align: center;
            font-weight: 700;
            font-size: 11px;
            color: white;
            background-color: rgba(241, 122, 38, 0.85);
            padding-top: 1px;
            padding-left: 10px;
            padding-right: 10px;
            right: 5px;
            bottom: 5px;
        }

        .middle-block .hitstats-block{
            position: relative;
            float: left;
            width: 35%;
            height: 68.5vw;
        }

        .middle-block .hitstats-block .hit_player img{
            width: 100%;
            height: 100%;
            filter: brightness(40%);
        }

        .middle-block .hitstats-block .hitstats{
            position: relative;
            width: 100%;
            height: 100%;
        }

        .middle-block .hitstats-block .hitstats .tooltip-top{
            position: absolute;
            width: 100%;
            height: 100%;
        }


        .middle-block .hitstats-block .hitstats .back{
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            border: 0px solid transparent;
            background-size: cover;
            border-radius: 4px;
        }

        .middle-block .hitstats-block .hitstats .hit_head{
            position: absolute;
            height:13.2vw;
            width:12.9vw;
            z-index: 101;
            bottom: 42.5vw;
            left: 13vw;
        }

        .middle-block .hitstats-block .hitstats .hit_body{
            position: absolute;
            height:22vw;
            width: 21vw;
            bottom: 24.6vw;
            left: 7.5vw;
            z-index: 105;
        }

        .middle-block .hitstats-block .hitstats .hit_left_arm{
            position: absolute;
            height:29vw;
            width:9.8vw;
            bottom: 30vw;
            left: 0.3vw;
            z-index: 101;
        }

        .middle-block .hitstats-block .hitstats .hit_right_arm{
            position: absolute;
            height:29vw;
            width:8vw;
            bottom: 14vw;
            left: 25vw;
            z-index: 104;
        }

        .middle-block .hitstats-block .hitstats .hit_left_leg{
            position: absolute;
            height:26.5vw;
            width: 10vw;
            bottom: 0;
            left: 9.5vw;
            z-index: 101;
        }

        .middle-block .hitstats-block .hitstats .hit_right_leg{
            position: absolute;
            height:26vw;
            width: 14vw;
            bottom: 0;
            left: 17vw;
            z-index: 101;
        }

        .middle-block .hitstats-block .hitstats .hit_head:hover,
        .middle-block .hitstats-block .hitstats .hit_body:hover,
        .middle-block .hitstats-block .hitstats .hit_left_arm:hover,
        .middle-block .hitstats-block .hitstats .hit_right_arm:hover,
        .middle-block .hitstats-block .hitstats .hit_left_leg:hover,
        .middle-block .hitstats-block .hitstats .hit_right_leg:hover{
            -webkit-filter: none;
            filter: none;
        }

        .right-block .top{
            position: relative;
            padding-top: 15px;
            width:100%;
            height: 100%;
            background-color: var(--sidebar-color);
            border: 0px solid transparent;
            border-radius: 4px;
        }

        .right-block .top .table thead th {
            font-size: 13px;
            font-weight: var(--font-weight-1);
            color: var(--default-text-color);
            border-bottom: 2px solid var(--table-line);
        }
        .right-block .top .table tbody th {
            color: var(--default-text-color);
            font-size: 12px;
            font-weight: var(--font-weight-1);
            border-bottom: none;
            border-top: 1px solid var(--table-line);
        }
    }
    @media (min-width: 992px) and (max-width: 1199.98px) {
        .header-profile {
        }

        .profile {
            position: relative;
            white-space: nowrap;
            height: 100%;
            width: 100%;
        }

        .left-block{
            float: left;
            width: 49%;
            margin-right: 1%;
        }
        .middle-block{
            float: right;
            width: 50%;
        }

        .right-block{
            float: left;
            width: 50%;
        }

        .user-block{
            position: relative;
            float: left;
            padding-top: 25px;
            height: 28vw;
            width:100%;
            max-width: 38%;
            text-align: center;
            background-color: var(--sidebar-color);
            border: 0px solid transparent;
            border-radius: 4px;
        }

        .best-weapon-block{
            position: relative;
            display: inline-block;
            margin-left: 17px;
            height: 28vw;
            width:100%;
            max-width: 59.3%;
            padding-top: 15px;
            background-color: var(--sidebar-color);
            text-align: center;
            border: 0px solid transparent;
            border-radius: 4px;
            overflow: hidden;
        }

        .user-block .avatar-block{
            position: relative;
            min-height: 180px;
            width: 100%;
        }

        .user-block .avatar{
            height: 8vw;
            width: auto;
            border-radius: 50%;
            border: 3px solid #fff;
        }
        .user-block .name{
            margin-top: 10px;
            font-size: 1.2vw;
            font-weight: var(--font-weight-1);
            color: #F17A26;
        }

        .user-block .country{
            font-size: 13px;
            font-weight: var(--font-weight-0);
            color: var(--default-text-color);
        }

        .user-block .rank-img {
            margin-top: 10px;
            width: 70px;
        }

        .user-block .rank {
            margin-top: 10px;
            font-size: 0.6vw;
            font-weight: var(--font-weight-0);
            margin-bottom: 30px
        }
        .user-block .user-stats {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 40px;
            background-color: #F17A26;
            text-align: center;
            padding-top: 7px;
            color: #ffffff;
            font-size: 17px;
            font-weight: var(--font-weight-3);
            border: 0px solid transparent;
            border-radius: 4px;
        }

        .best-weapon-block .weapons{
            text-align: center;
            height: 20%;
        }

        .best-weapon-block .weapons .kills{
            margin-top: 5px;
            text-align: center;
            font-size: 12px;
            font-weight: var(--font-weight-3);
        }

        .best-weapon-block .weapons li{
            display: inline-block;
            padding-left: 3%;
            padding-right: 3%;
        }

        .best-weapon-block .weapons svg, .best-weapon-block .weapons img{
            width: 4.6vw;
            max-height: 1.8vw;
            filter:invert(var(--svg));
        }

        .best-weapon-block .weapon-table{
            height: 80%;
            overflow:auto;
        }

        .best-weapon-block .weapon-table svg, .best-weapon-block .weapon-table img{
            filter:invert(var(--svg));
        }

        .short-stats-block{
            position: relative;
            float: left;
            margin-top: 10px;
            height: 280px;
            max-height: 280px;
            width:100%;
            max-width: 100%;
            padding: 25px;
            background-color: var(--sidebar-color);
            text-align: center;
            border: 0px solid transparent;
            border-radius: 4px;
        }

        .short-stats-block .left-stats-block {
            float:left;
            width: 50%;
        }
        .short-stats-block .right-stats-block {
            margin-left: 50%;
            width: 50%;
        }
        .short-stats-block ul{
            font-size: 13px;
            font-weight: var(--font-weight-0);
            color: var(--default-text-color);
        }
        .short-stats-block li{
            padding-bottom: 5px;
        }
        .short-stats-block .left-stats-block ul{
            text-align: left;
        }
        .short-stats-block .right-stats-block ul{
            text-align: right;
        }

        .skull-block {
            margin-top: 5%;
            width:100%;
            font-size: 14px;
            font-weight: var(--font-weight-0);
        }

        .skull-block .info{
            font-size: 12px;
            color: var(--default-text-color);
            font-weight: var(--font-weight-1);
        }

        .skull-block .left-skull-block {
            float: left;
            width: 27%;
            text-align: center
        }

        .skull-block .center-skull-block {
            display: inline-block;
            width: 39%;
            text-align: center
        }

        .skull-block .right-skull-block {
            float: right;
            width: 34%;
            text-align: center
        }

        .skull-block .left-skull-block .skull{
            display: inline-block;
            width: 62px;
            background-image: url(storage/cache/img/icons/custom/global/skull.svg);
            background-repeat: space;
            height: 24px;
        }

        .skull-block .center-skull-block .skull{
            display: inline-block;
            width: 82px;
            background-image: url(storage/cache/img/icons/custom/global/skull.svg);
            background-repeat: space;
            height: 24px;
        }

        .skull-block .right-skull-block .skull{
            display: inline-block;
            width: 102px;
            background-image: url(storage/cache/img/icons/custom/global/skull.svg);
            background-repeat: space;
            height: 24px;
        }

        .middle-block .best-maps{
            position: relative;
            float: left;
            height: 100%;
            width: 64.5%;
        }

        .middle-block .up_block{
            position: relative;
            height: 32.5vw;
            width: 100%;
        }

        .middle-block .best-maps .map-top{
            width: 97%;
        }

        .middle-block .best-maps .map-bottom{
            width: 100%;
            max-height: 100px;
            margin-top: 45px;
            list-style:none;
        }

        .middle-block .best-maps .map-bottom li{
            display: block;
            float:left;
            width:47%;
            margin-right: 3%;
            margin-bottom: 3%;
        }

        .middle-block .best-maps .map-bottom img{
            object-fit: cover;
            min-width: 100%;
            max-width: 100%;
            border-radius: 4px;
        }

        .middle-block .best-maps .map-top img{
            object-fit: cover;
            min-width: 100%;
            max-width: 100%;
            border-radius: 4px;
        }

        .middle-block .best-maps .map-top .map-lower {
            max-width: 100%;
            margin-top: -33px;
            position: relative;
        }
        .middle-block .map-title-rounds .icon {
            margin-right: 0px;
        }
        .middle-block .map-title-rounds .icon svg {
            fill: #ffffff;
            filter: inherit;
            margin-bottom: 4px;
            width: 10px;
        }

        .middle-block .best-maps .map-bottom .map-lower {
            max-width: 100%;
            position: relative;
        }

        .middle-block .best-maps .map-top .map-one {
            position: absolute;
            height: 28px;
            width: 25px;
            text-align: center;
            vertical-align: center;
            font-weight: 700;
            font-size: 18px;
            color: white;
            background-color: rgba(0, 0, 0, 0.75);
            padding-top: 1px;
            left: 7px;
        }
        .middle-block .best-maps .map-top .map-pretty-name {
            position: absolute;
            height: 28px;
            text-align: center;
            vertical-align: center;
            font-weight: 700;
            font-size: 18px;
            color: black;
            background-color: rgba(255, 255, 255, 0.75);
            padding-top: 1px;
            padding-left: 10px;
            padding-right: 10px;
            left: 33px;
        }
        .middle-block .best-maps .map-top .map-title-rounds {
            position: absolute;
            height: 28px;
            text-align: center;
            vertical-align: center;
            font-weight: 700;
            font-size: 18px;
            color: white;
            background-color: rgba(241, 122, 38, 0.85);
            padding-top: 1px;
            padding-left: 10px;
            padding-right: 10px;
            right: 7px;
        }

        .middle-block .best-maps .map-bottom .map-one {
            position: absolute;
            height: 18px;
            width: 18px;
            text-align: center;
            vertical-align: center;
            font-weight: 700;
            font-size: 11px;
            color: white;
            background-color: rgba(0, 0, 0, 0.75);
            padding-top: 1px;
            left: 7px;
            bottom: 5px;
        }
        .middle-block .best-maps .map-bottom .map-pretty-name {
            position: absolute;
            height: 18px;
            text-align: center;
            vertical-align: center;
            font-weight: 700;
            font-size: 11px;
            color: black;
            background-color: rgba(255, 255, 255, 0.75);
            padding-top: 1px;
            padding-left: 10px;
            padding-right: 10px;
            left: 25px;
            bottom: 5px;
        }
        .middle-block .best-maps .map-bottom .map-title-rounds {
            position: absolute;
            height: 18px;
            text-align: center;
            vertical-align: center;
            font-weight: 700;
            font-size: 11px;
            color: white;
            background-color: rgba(241, 122, 38, 0.85);
            padding-top: 1px;
            padding-left: 10px;
            padding-right: 10px;
            right: 5px;
            bottom: 5px;
        }

        .middle-block .hitstats-block{
            position: relative;
            float: left;
            width: 35%;
            height: 35vw;
        }

        .middle-block .hitstats-block .hit_player img{
            width: 100%;
            height: 100%;
            filter: brightness(40%);
        }

        .middle-block .hitstats-block .hitstats{
            position: relative;
            width: 100%;
            height: 100%;
        }

        .middle-block .hitstats-block .hitstats .tooltip-top{
            position: absolute;
            width: 100%;
            height: 100%;
        }


        .middle-block .hitstats-block .hitstats .back{
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            border: 0px solid transparent;
            background-size: cover;
            border-radius: 4px;
        }

        .middle-block .hitstats-block .hitstats .hit_head{
            position: absolute;
            height:4.7vw;
            width:4.4vw;
            z-index: 101;
            bottom: 16.8vw;
            left: 4.6vw;
        }

        .middle-block .hitstats-block .hitstats .hit_body{
            position: absolute;
            height:8vw;
            width: 7.2vw;
            bottom: 10.4vw;
            left: 2.7vw;
            z-index: 105;
        }

        .middle-block .hitstats-block .hitstats .hit_left_arm{
            position: absolute;
            height:10vw;
            width:3.5vw;
            bottom: 12.5vw;
            left: 0vw;
            z-index: 101;
        }

        .middle-block .hitstats-block .hitstats .hit_right_arm{
            position: absolute;
            height:11vw;
            width:2.5vw;
            bottom: 6.2vw;
            left: 9vw;
            z-index: 104;
        }

        .middle-block .hitstats-block .hitstats .hit_left_leg{
            position: absolute;
            height:11.2vw;
            width: 4vw;
            bottom: 0;
            left: 2.9vw;
            z-index: 101;
        }

        .middle-block .hitstats-block .hitstats .hit_right_leg{
            position: absolute;
            height:11vw;
            width: 5vw;
            bottom: 0;
            left: 6.1vw;
            z-index: 101;
        }

        .middle-block .hitstats-block .hitstats .hit_head:hover,
        .middle-block .hitstats-block .hitstats .hit_body:hover,
        .middle-block .hitstats-block .hitstats .hit_left_arm:hover,
        .middle-block .hitstats-block .hitstats .hit_right_arm:hover,
        .middle-block .hitstats-block .hitstats .hit_left_leg:hover,
        .middle-block .hitstats-block .hitstats .hit_right_leg:hover{
            -webkit-filter: none;
            filter: none;
        }

        .right-block .top{
            padding-top: 15px;
            width:100%;
            background-color: var(--sidebar-color);
            border: 0px solid transparent;
            border-radius: 4px;
        }

        .right-block .top .table thead th {
            font-size: 13px;
            font-weight: var(--font-weight-1);
            color: var(--default-text-color);
            border-bottom: 2px solid var(--table-line);
        }
        .right-block .top .table tbody th {
            color: var(--default-text-color);
            font-size: 12px;
            font-weight: var(--font-weight-1);
            border-bottom: none;
            border-top: 1px solid var(--table-line);
        }
    }

    @media (min-width: 1200px) and (max-width: 1499.98px) {
        .header-profile {
        }

        .profile {
            position: relative;
            white-space: nowrap;
            height: 100%;
            width: 100%;
        }

        .left-block{
            float: left;
            width: 49%;
            margin-right: 1%;
        }
        .middle-block{
            float: right;
            width: 50%;
            margin-bottom: 13px;
        }

        .right-block{
            float: left;
            width: 50%;
        }

        .user-block{
            position: relative;
            float: left;
            padding-top: 25px;
            height: 26vw;
            width:100%;
            max-width: 38%;
            text-align: center;
            background-color: var(--sidebar-color);
            border: 0px solid transparent;
            border-radius: 4px;
        }

        .best-weapon-block{
            position: relative;
            display: inline-block;
            margin-left: 17px;
            height: 26vw;
            width:100%;
            max-width: 59.3%;
            padding-top: 15px;
            background-color: var(--sidebar-color);
            text-align: center;
            border: 0px solid transparent;
            border-radius: 4px;
            overflow: hidden;
        }

        .user-block .avatar-block{
            position: relative;
            min-height: 180px;
            width: 100%;
        }

        .user-block .avatar{
            height: 110px;
            width: 110px;
            border-radius: 50%;
            border: 3px solid #fff;
        }
        .user-block .name{
            margin-top: 10px;
            font-size: 1.2vw;
            font-weight: var(--font-weight-1);
            color: #F17A26;
        }

        .user-block .country{
            font-size: 13px;
            font-weight: var(--font-weight-0);
            color: var(--default-text-color);
        }

        .user-block .rank-img {
            margin-top: 10px;
            width: 70px;
        }

        .user-block .rank {
            margin-top: 10px;
            font-size: 0.7vw;
            font-weight: var(--font-weight-0);
            margin-bottom: 30px
        }
        .user-block .user-stats {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 40px;
            background-color: #F17A26;
            text-align: center;
            padding-top: 7px;
            color: #ffffff;
            font-size: 17px;
            font-weight: var(--font-weight-3);
            border: 0px solid transparent;
            border-radius: 4px;
        }

        .best-weapon-block .weapons{
            text-align: center;
            height: 20%;
        }

        .best-weapon-block .weapons .kills{
            margin-top: 5px;
            text-align: center;
            font-size: 15px;
            font-weight: var(--font-weight-3);
        }

        .best-weapon-block .weapons li{
            display: inline-block;
            padding-left: 3%;
            padding-right: 3%;
        }

        .best-weapon-block .weapons svg, .best-weapon-block .weapons img{
            width: 5vw;
            max-height: 2vw;
            filter:invert(var(--svg));
        }

        .best-weapon-block .weapon-table{
            height: 20vw;
            overflow:auto;
        }

        .best-weapon-block .weapon-table svg, .best-weapon-block .weapon-table img{
            filter:invert(var(--svg));
        }

        .short-stats-block{
            position: relative;
            float: left;
            margin-top: 10px;
            height: 280px;
            max-height: 280px;
            width:100%;
            max-width: 100%;
            padding: 25px;
            background-color: var(--sidebar-color);
            text-align: center;
            border: 0px solid transparent;
            border-radius: 4px;
        }

        .short-stats-block .left-stats-block {
            float:left;
            width: 50%;
        }
        .short-stats-block .right-stats-block {
            margin-left: 50%;
            width: 50%;
        }
        .short-stats-block ul{
            font-size: 13px;
            font-weight: var(--font-weight-0);
            color: var(--default-text-color);
        }
        .short-stats-block li{
            padding-bottom: 5px;
        }
        .short-stats-block .left-stats-block ul{
            text-align: left;
        }
        .short-stats-block .right-stats-block ul{
            text-align: right;
        }

        .skull-block {
            margin-top: 5%;
            width:100%;
            font-size: 14px;
            font-weight: var(--font-weight-0);
        }

        .skull-block .info{
            font-size: 12px;
            color: var(--default-text-color);
            font-weight: var(--font-weight-1);
        }

        .skull-block .left-skull-block {
            float: left;
            width: 27%;
            text-align: center
        }

        .skull-block .center-skull-block {
            display: inline-block;
            width: 39%;
            text-align: center
        }

        .skull-block .right-skull-block {
            float: right;
            width: 34%;
            text-align: center
        }

        .skull-block .left-skull-block .skull{
            display: inline-block;
            width: 62px;
            background-image: url(storage/cache/img/icons/custom/global/skull.svg);
            background-repeat: space;
            height: 24px;
        }

        .skull-block .center-skull-block .skull{
            display: inline-block;
            width: 82px;
            background-image: url(storage/cache/img/icons/custom/global/skull.svg);
            background-repeat: space;
            height: 24px;
        }

        .skull-block .right-skull-block .skull{
            display: inline-block;
            width: 102px;
            background-image: url(storage/cache/img/icons/custom/global/skull.svg);
            background-repeat: space;
            height: 24px;
        }

        .middle-block .best-maps{
            position: relative;
            float: left;
            height: 100%;
            width: 64.5%;
        }

        .middle-block .up_block{
            position: relative;
            height: 32.5vw;
            width: 100%;
        }

        .middle-block .best-maps .map-top{
            width: 97%;
        }

        .middle-block .best-maps .map-bottom{
            width: 100%;
            max-height: 100px;
            margin-top: 45px;
            list-style:none;
        }

        .middle-block .best-maps .map-bottom li{
            display: block;
            float:left;
            width:47%;
            margin-right: 3%;
            margin-bottom: 3%;
        }

        .middle-block .best-maps .map-bottom img{
            object-fit: cover;
            min-width: 100%;
            max-width: 100%;
            border-radius: 4px;
        }

        .middle-block .best-maps .map-top img{
            object-fit: cover;
            min-width: 100%;
            max-width: 100%;
            border-radius: 4px;
        }

        .middle-block .best-maps .map-top .map-lower {
            max-width: 100%;
            margin-top: -33px;
            position: relative;
        }
        .middle-block .map-title-rounds .icon {
            margin-right: 0px;
        }
        .middle-block .map-title-rounds .icon svg {
            fill: #ffffff;
            filter: inherit;
            margin-bottom: 4px;
            width: 10px;
        }

        .middle-block .best-maps .map-bottom .map-lower {
            max-width: 100%;
            position: relative;
        }

        .middle-block .best-maps .map-top .map-one {
            position: absolute;
            height: 28px;
            width: 25px;
            text-align: center;
            vertical-align: center;
            font-weight: 700;
            font-size: 18px;
            color: white;
            background-color: rgba(0, 0, 0, 0.75);
            padding-top: 1px;
            left: 7px;
        }
        .middle-block .best-maps .map-top .map-pretty-name {
            position: absolute;
            height: 28px;
            text-align: center;
            vertical-align: center;
            font-weight: 700;
            font-size: 18px;
            color: black;
            background-color: rgba(255, 255, 255, 0.75);
            padding-top: 1px;
            padding-left: 10px;
            padding-right: 10px;
            left: 33px;
        }
        .middle-block .best-maps .map-top .map-title-rounds {
            position: absolute;
            height: 28px;
            text-align: center;
            vertical-align: center;
            font-weight: 700;
            font-size: 18px;
            color: white;
            background-color: rgba(241, 122, 38, 0.85);
            padding-top: 1px;
            padding-left: 10px;
            padding-right: 10px;
            right: 7px;
        }

        .middle-block .best-maps .map-bottom .map-one {
            position: absolute;
            height: 18px;
            width: 18px;
            text-align: center;
            vertical-align: center;
            font-weight: 700;
            font-size: 11px;
            color: white;
            background-color: rgba(0, 0, 0, 0.75);
            padding-top: 1px;
            left: 7px;
            bottom: 5px;
        }
        .middle-block .best-maps .map-bottom .map-pretty-name {
            position: absolute;
            height: 18px;
            text-align: center;
            vertical-align: center;
            font-weight: 700;
            font-size: 11px;
            color: black;
            background-color: rgba(255, 255, 255, 0.75);
            padding-top: 1px;
            padding-left: 10px;
            padding-right: 10px;
            left: 25px;
            bottom: 5px;
        }
        .middle-block .best-maps .map-bottom .map-title-rounds {
            position: absolute;
            height: 18px;
            text-align: center;
            vertical-align: center;
            font-weight: 700;
            font-size: 11px;
            color: white;
            background-color: rgba(241, 122, 38, 0.85);
            padding-top: 1px;
            padding-left: 10px;
            padding-right: 10px;
            right: 5px;
            bottom: 5px;
        }

        .middle-block .hitstats-block{
            position: relative;
            float: left;
            width: 35%;
            height: 33.6vw;
        }

        .middle-block .hitstats-block .hit_player img{
            width: 100%;
            height: 100%;
            filter: brightness(40%);
        }

        .middle-block .hitstats-block .hitstats{
            position: relative;
            width: 100%;
            height: 100%;
        }

        .middle-block .hitstats-block .hitstats .tooltip-top{
            position: absolute;
            width: 100%;
            height: 100%;
        }


        .middle-block .hitstats-block .hitstats .back{
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            border: 0px solid transparent;
            background-size: cover;
            border-radius: 4px;
        }

        .middle-block .hitstats-block .hitstats .hit_head{
            position: absolute;
            height:4.7vw;
            width:4.4vw;
            z-index: 101;
            bottom: 16.8vw;
            left: 5.1vw;
        }

        .middle-block .hitstats-block .hitstats .hit_body{
            position: absolute;
            height:8vw;
            width: 7.2vw;
            bottom: 10.4vw;
            left: 3.2vw;
            z-index: 105;
        }

        .middle-block .hitstats-block .hitstats .hit_left_arm{
            position: absolute;
            height:10vw;
            width:3.5vw;
            bottom: 12.5vw;
            left: 0.5vw;
            z-index: 101;
        }

        .middle-block .hitstats-block .hitstats .hit_right_arm{
            position: absolute;
            height:11vw;
            width:2.5vw;
            bottom: 6.2vw;
            left: 9.5vw;
            z-index: 104;
        }

        .middle-block .hitstats-block .hitstats .hit_left_leg{
            position: absolute;
            height:11.2vw;
            width: 4vw;
            bottom: 0;
            left: 3.4vw;
            z-index: 101;
        }

        .middle-block .hitstats-block .hitstats .hit_right_leg{
            position: absolute;
            height:11vw;
            width: 5vw;
            bottom: 0;
            left: 6.6vw;
            z-index: 101;
        }

        .middle-block .hitstats-block .hitstats .hit_head:hover,
        .middle-block .hitstats-block .hitstats .hit_body:hover,
        .middle-block .hitstats-block .hitstats .hit_left_arm:hover,
        .middle-block .hitstats-block .hitstats .hit_right_arm:hover,
        .middle-block .hitstats-block .hitstats .hit_left_leg:hover,
        .middle-block .hitstats-block .hitstats .hit_right_leg:hover{
            -webkit-filter: none;
            filter: none;
        }

        .right-block .top{
            padding-top: 15px;
            width:100%;
            background-color: var(--sidebar-color);
            border: 0px solid transparent;
            border-radius: 4px;
        }

        .right-block .top .table thead th {
            font-size: 13px;
            font-weight: var(--font-weight-1);
            color: var(--default-text-color);
            border-bottom: 2px solid var(--table-line);
        }
        .right-block .top .table tbody th {
            color: var(--default-text-color);
            font-size: 12px;
            font-weight: var(--font-weight-1);
            border-bottom: none;
            border-top: 1px solid var(--table-line);
        }
    }
    @media (min-width: 1500px){
        .header-profile {
            
        }

        .profile {
            position: relative;
            white-space: nowrap;
            height: 100%;
            width: 100%;
        }

        .left-block{
            float: left;
            width: 40%;
            margin-right: 0.5%;
        }
        .middle-block{
            display: inline-block;
            width: 31%;
            margin-right: 0.5%;
        }

        .right-block{
            float: right;
            width: 28%;
        }

        .user-block{
            position: relative;
            float: left;
            padding-top: 25px;
            height: 20vw;
            width:100%;
            max-width: 38%;
            text-align: center;
            background-color: var(--sidebar-color);
            border: 0px solid transparent;
            border-radius: 4px;
        }

        .best-weapon-block{
            position: relative;
            display: inline-block;
            margin-left: 17px;
            height: 20vw;
            width:100%;
            max-width: 59.3%;
            padding-top: 15px;
            background-color: var(--sidebar-color);
            text-align: center;
            border: 0px solid transparent;
            border-radius: 4px;
            overflow: hidden;
        }

        .user-block .avatar-block{
            position: relative;
            min-height: 180px;
            width: 100%;
        }

        .user-block .avatar{
            height: 110px;
            width: 110px;
            border-radius: 50%;
            border: 3px solid #fff;
        }
        .user-block .name{
            margin-top: 10px;
            font-size: 1vw;
            font-weight: var(--font-weight-1);
            color: #F17A26;
        }

        .user-block .country{
            font-size: 13px;
            font-weight: var(--font-weight-0);
            color: var(--default-text-color);
        }

        .user-block .rank-img {
            margin-top: 10px;
            width: 70px;
        }

        .user-block .rank {
            margin-top: 10px;
            font-size: 0.6vw;
            font-weight: var(--font-weight-0);
            margin-bottom: 30px
        }
        .user-block .user-stats {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 40px;
            background-color: #F17A26;
            text-align: center;
            padding-top: 7px;
            color: #ffffff;
            font-size: 17px;
            font-weight: var(--font-weight-3);
            border: 0px solid transparent;
            border-radius: 4px;
        }

        .best-weapon-block .weapons{
            text-align: center;
            height: 20%;
        }

        .best-weapon-block .weapons .kills{
            margin-top: 5px;
            text-align: center;
            font-size: 15px;
            font-weight: var(--font-weight-3);
        }

        .best-weapon-block .weapons li{
            display: inline-block;
            padding-left: 3%;
            padding-right: 3%;
        }

        .best-weapon-block .weapons svg, .best-weapon-block .weapons img{
            width: 4.6vw;
            max-height: 1.8vw;
            filter:invert(var(--svg));
        }

        .best-weapon-block .weapon-table{
            height: 80%;
            overflow:auto;
        }

        .best-weapon-block .weapon-table svg, .best-weapon-block .weapon-table img{
            filter:invert(var(--svg));
        }

        .short-stats-block{
            position: relative;
            float: left;
            margin-top: 10px;
            height: 280px;
            max-height: 280px;
            width:100%;
            max-width: 100%;
            padding: 25px;
            background-color: var(--sidebar-color);
            text-align: center;
            border: 0px solid transparent;
            border-radius: 4px;
        }

        .short-stats-block .left-stats-block {
            float:left;
            width: 50%;
        }
        .short-stats-block .right-stats-block {
            margin-left: 50%;
            width: 50%;
        }
        .short-stats-block ul{
            font-size: 13px;
            font-weight: var(--font-weight-0);
            color: var(--default-text-color);
        }
        .short-stats-block li{
            padding-bottom: 5px;
        }
        .short-stats-block .left-stats-block ul{
            text-align: left;
        }
        .short-stats-block .right-stats-block ul{
            text-align: right;
        }

        .skull-block {
            margin-top: 5%;
            width:100%;
            font-size: 14px;
            font-weight: var(--font-weight-0);
        }

        .skull-block .info{
            font-size: 12px;
            color: var(--default-text-color);
            font-weight: var(--font-weight-1);
        }

        .skull-block .left-skull-block {
            float: left;
            width: 27%;
            text-align: center
        }

        .skull-block .center-skull-block {
            display: inline-block;
            width: 39%;
            text-align: center
        }

        .skull-block .right-skull-block {
            float: right;
            width: 34%;
            text-align: center
        }

        .skull-block .left-skull-block .skull{
            display: inline-block;
            width: 62px;
            background-image: url(storage/cache/img/icons/custom/global/skull.svg);
            background-repeat: space;
            height: 24px;
        }

        .skull-block .center-skull-block .skull{
            display: inline-block;
            width: 82px;
            background-image: url(storage/cache/img/icons/custom/global/skull.svg);
            background-repeat: space;
            height: 24px;
        }

        .skull-block .right-skull-block .skull{
            display: inline-block;
            width: 102px;
            background-image: url(storage/cache/img/icons/custom/global/skull.svg);
            background-repeat: space;
            height: 24px;
        }

        .middle-block .best-maps{
            position: relative;
            float: left;
            height: 100%;
            width: 61.5%;
        }

        .middle-block .up_block{
            position: relative;
            height: 20.5vw;
            width: 100%;
        }

        .middle-block .best-maps .map-top{
            width: 97%;
        }

        .middle-block .best-maps .map-bottom{
            width: 100%;
            max-height: 100px;
            margin-top: 45px;
            list-style:none;
        }

        .middle-block .best-maps .map-bottom li{
            display: block;
            float:left;
            width:47%;
            margin-right: 3%;
            margin-bottom: 3%;
        }

        .middle-block .best-maps .map-bottom img{
            object-fit: cover;
            min-width: 100%;
            max-width: 100%;
            border-radius: 4px;
        }

        .middle-block .best-maps .map-top img{
            object-fit: cover;
            min-width: 100%;
            max-width: 100%;
            border-radius: 4px;
        }

        .middle-block .best-maps .map-top .map-lower {
            max-width: 100%;
            margin-top: -33px;
            position: relative;
        }
        .middle-block .map-title-rounds .icon {
            margin-right: 0px;
        }
        .middle-block .map-title-rounds .icon svg {
            fill: #ffffff;
            filter: inherit;
            margin-bottom: 4px;
            width: 10px;
        }

        .middle-block .best-maps .map-bottom .map-lower {
            max-width: 100%;
            position: relative;
        }

        .middle-block .best-maps .map-top .map-one {
            position: absolute;
            height: 28px;
            width: 25px;
            text-align: center;
            vertical-align: center;
            font-weight: 700;
            font-size: 18px;
            color: white;
            background-color: rgba(0, 0, 0, 0.75);
            padding-top: 1px;
            left: 7px;
        }
        .middle-block .best-maps .map-top .map-pretty-name {
            position: absolute;
            height: 28px;
            text-align: center;
            vertical-align: center;
            font-weight: 700;
            font-size: 18px;
            color: black;
            background-color: rgba(255, 255, 255, 0.75);
            padding-top: 1px;
            padding-left: 10px;
            padding-right: 10px;
            left: 33px;
        }
        .middle-block .best-maps .map-top .map-title-rounds {
            position: absolute;
            height: 28px;
            text-align: center;
            vertical-align: center;
            font-weight: 700;
            font-size: 18px;
            color: white;
            background-color: rgba(241, 122, 38, 0.85);
            padding-top: 1px;
            padding-left: 10px;
            padding-right: 10px;
            right: 7px;
        }

        .middle-block .best-maps .map-bottom .map-one {
            position: absolute;
            height: 18px;
            width: 18px;
            text-align: center;
            vertical-align: center;
            font-weight: 700;
            font-size: 11px;
            color: white;
            background-color: rgba(0, 0, 0, 0.75);
            padding-top: 1px;
            left: 7px;
            bottom: 5px;
        }
        .middle-block .best-maps .map-bottom .map-pretty-name {
            position: absolute;
            height: 18px;
            text-align: center;
            vertical-align: center;
            font-weight: 700;
            font-size: 11px;
            color: black;
            background-color: rgba(255, 255, 255, 0.75);
            padding-top: 1px;
            padding-left: 10px;
            padding-right: 10px;
            left: 25px;
            bottom: 5px;
        }
        .middle-block .best-maps .map-bottom .map-title-rounds {
            position: absolute;
            height: 18px;
            text-align: center;
            vertical-align: center;
            font-weight: 700;
            font-size: 11px;
            color: white;
            background-color: rgba(241, 122, 38, 0.85);
            padding-top: 1px;
            padding-left: 10px;
            padding-right: 10px;
            right: 5px;
            bottom: 5px;
        }

        .middle-block .hitstats-block{
            position: relative;
            float: left;
            width: 38%;
            height: 100%;
        }

        .middle-block .hitstats-block .hit_player img{
            width: 100%;
            height: 100%;
            filter: brightness(40%);
        }

        .middle-block .hitstats-block .hitstats{
            position: relative;
            width: 100%;
            height: 100%;
        }

        .middle-block .hitstats-block .hitstats .tooltip-top{
            position: absolute;
            width: 100%;
            height: 100%;
        }


        .middle-block .hitstats-block .hitstats .back{
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            border: 0px solid transparent;
            background-size: cover;
            border-radius: 4px;
        }

        .middle-block .hitstats-block .hitstats .hit_head{
            position: absolute;
            height:3.6vw;
            width:3.32vw;
            z-index: 101;
            bottom: 12.1vw;
            left: 3.9vw;
        }

        .middle-block .hitstats-block .hitstats .hit_body{
            position: absolute;
            height:6.4vw;
            width: 5.4vw;
            bottom: 6.9vw;
            left: 2.5vw;
            z-index: 105;
        }

        .middle-block .hitstats-block .hitstats .hit_left_arm{
            position: absolute;
            height:8vw;
            width:2.65vw;
            bottom: 8.9vw;
            left: 0.5vw;
            z-index: 101;
        }

        .middle-block .hitstats-block .hitstats .hit_right_arm{
            position: absolute;
            height:8.3vw;
            width:2vw;
            bottom: 4.2vw;
            left: 7.1vw;
            z-index: 104;
        }

        .middle-block .hitstats-block .hitstats .hit_left_leg{
            position: absolute;
            height:8vw;
            width: 3vw;
            bottom: 0;
            left: 3vw;
            z-index: 101;
        }

        .middle-block .hitstats-block .hitstats .hit_right_leg{
            position: absolute;
            height:8vw;
            width: 3.5vw;
            bottom: 0;
            left: 5.40vw;
            z-index: 101;
        }

        .middle-block .hitstats-block .hitstats .hit_head:hover,
        .middle-block .hitstats-block .hitstats .hit_body:hover,
        .middle-block .hitstats-block .hitstats .hit_left_arm:hover,
        .middle-block .hitstats-block .hitstats .hit_right_arm:hover,
        .middle-block .hitstats-block .hitstats .hit_left_leg:hover,
        .middle-block .hitstats-block .hitstats .hit_right_leg:hover{
            -webkit-filter: none;
            filter: none;
        }

        .right-block .top{
            padding-top: 15px;
            width:100%;
            background-color: var(--sidebar-color);
            border: 0px solid transparent;
            border-radius: 4px;
        }

        .right-block .top .table thead th {
            font-size: 13px;
            font-weight: var(--font-weight-1);
            color: var(--default-text-color);
            border-bottom: 2px solid var(--table-line);
        }
        .right-block .top .table tbody th {
            color: var(--default-text-color);
            font-size: 12px;
            font-weight: var(--font-weight-1);
            border-bottom: none;
            border-top: 1px solid var(--table-line);
        }
    }
</style>