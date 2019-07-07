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
<style>.input-form {
        position: relative;
        margin-top: 6px;
        margin-bottom: 6px;
        width: 100%;
        float: left;
    }

    .server_line {
        position: relative;
        width: 92%;
        margin-left: 4%;
    }

    .page_modules button{
        margin-right: 16px;
        color: #FFF;
        float: left;
        background-color: #f37c00;
        border: none;
        cursor: pointer;
        -ms-touch-action: manipulation;
        touch-action: manipulation;
        background-image: none;
        text-align: center;
        line-height: 26px;
        vertical-align: middle;
        user-select: none;
        outline: none;
        margin-top: 8px;
        margin-bottom: 8px;
    }

    .remove_servers {
        cursor: pointer;
        white-space: nowrap;
        text-align: center;
        height: 30px;
        outline: none;
        font-weight: 400;
        font-size: .80vw;
        background: #f37c00;
        color: #fff;
        border: 0px solid #fff;
    }

    .remove_servers img{
        filter: invert(var(--svg));
    }

    .add_server {
        margin-right: 4%;
        color: #FFF;
        float: right;
        background-color: #f37c00;
        border: none;
        cursor: pointer;
        -ms-touch-action: manipulation;
        touch-action: manipulation;
        background-image: none;
        text-align: center;
        line-height: 26px;
        vertical-align: middle;
        user-select: none;
        outline: none;
        margin-bottom: 25px;
    }

    .save_servers {
        display: inline-block;
        color: #FFF;
        float: left;
        margin-left: 4%;
        background-color: #f37c00;
        border: none;
        cursor: pointer;
        -ms-touch-action: manipulation;
        touch-action: manipulation;
        background-image: none;
        text-align: center;
        line-height: 26px;
        vertical-align: middle;
        user-select: none;
        outline: none;
    }

    .card-block {
        width: 100%;
        margin-left: 0%;
        margin-bottom: 10px;
    }

    ._servers {
        width: 100%;
    }

    .text-group {
        width: 100%;
    }

    .select_label {
        float: left;
        margin-right: 45px;
    }

    .select-bar {
        display: inline-block;
        margin-right: 0px;
        margin-top: 2px;
    }

    .select-bar option{
        font-size: 15px;
        font-weight: var(--font-weight-2);
    }

    .select-bar select{
        font-size: 15px;
        font-weight: var(--font-weight-0);
    }

    .type {
        display: inline-block;
        margin-right: 0px;
        margin-top: 2px;
        margin-bottom: 18px;
        float: right;
        font-weight: var(--font-weight-3);
        font-size: 12px;
    }

    .text_label {
        display: inline-block;
        float: left;
        margin-top: 2px;
        width: 35%;
    }

    .menu .nav a {
        color: var(--default-text-color);
        margin-left: 15px;
        outline: none;
    }

    .menu .nav li {
        display: block;
        width: 100%;
        padding: 10px;
        cursor: pointer;
        font-weight: var(--font-weight-3);
        font-size: 12px;
    }

    .menu .nav li:hover {
        color: var(--default-text-color);
        background-color: var(--hover);
    }

    .menu .nav .active {
        color: var(--default-text-color);
        background-color: var(--hover);
    }

    .menu-header {
        border-bottom: 1px solid rgba(0, 0, 0, .125);
    }

    .menu-header h5 {
        font-weight: var(--font-weight-3);
        font-size: 18px;
        margin-bottom: 20px;
    }

    .module-setting {
        display: inline-block;
        position: relative;
        cursor: pointer;
        float: left;
        padding: 0;
        overflow: hidden;
        border: 0;
        background: transparent;
        margin: 4px 7px;
        outline: none;
    }

    .module-setting svg {
        width: 17px;
        height: 17px;
        filter: invert(var(--svg));
        outline: none;
    }

    .module-info {
        margin-bottom: 5px;
        font-weight: var(--font-weight-2);
        font-size: 13px;
    }

    .card .sub-title {
        font-size: 13px;
        font-weight: 500;
    }

    .sub-title {
        padding-bottom: 10px;
        margin-bottom: 10px;
        font-size: 14px;
        font-weight: 400;
        color: var(--default-text-color);
    }

    .col-sub-block {
        width: 84%;
        margin-left: 27px;
    }

    .border-checkbox:checked+.border-checkbox-label:after {
        -webkit-animation: check linear 0.5s;
        animation: check linear 0.5s;
        opacity: 1;
        border-color: #f37c00
    }

    .border-checkbox-group .border-checkbox-label {
        position: relative;
        display: inline-block;
        cursor: pointer;
        line-height: 20px;
        padding-left: 30px;
        margin-bottom: 18px;
        font-size: 13px;
        font-weight: 500
    }

    .border-checkbox-group .border-checkbox-label:after {
        content: "";
        display: block;
        width: 5px;
        height: 13px;
        opacity: .15;
        border-right: 2px solid var(--default-text-color);
        border-top: 2px solid var(--default-text-color);
        position: absolute;
        left: 5px;
        top: 13px;
        -webkit-transform: scaleX(-1) rotate(135deg);
        transform: scaleX(-1) rotate(135deg);
        -webkit-transform-origin: left top;
        transform-origin: left top
    }

    .border-checkbox-group .border-checkbox-label:before {
        content: "";
        display: block;
        border: 2px solid #f37c00;
        width: 23px;
        height: 23px;
        position: absolute;
        left: 0
    }

    .border-checkbox {
        display: none
    }

    .border-checkbox:disabled~.border-checkbox-label {
        cursor: no-drop;
        color: #ccc
    }

    @-webkit-keyframes check {
        0% {
            height: 0;
            width: 0
        }
        25% {
            height: 0;
            width: 5px
        }
        50% {
            height: 13px;
            width: 5px
        }
    }

    @keyframes check {
        0% {
            height: 0;
            width: 0
        }
        25% {
            height: 0;
            width: 5px
        }
        50% {
            height: 13px;
            width: 5px
        }
    }

    .dd {
        position: relative;
        display: block;
        margin: 0;
        padding: 0;
        max-width: 600px;
        list-style: none;
        font-size: 13px;
        line-height: 20px;
        -moz-user-select: none;
        -khtml-user-select: none;
        user-select: none;
    }

    .dd-list {
        display: block;
        position: relative;
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .dd-list .dd-list {
        padding-left: 30px;
    }

    .dd-item,
    .dd-empty,
    .dd-placeholder {
        display: block;
        position: relative;
        margin: 0;
        padding: 0;
        min-height: 20px;
        font-size: 13px;
        line-height: 20px;
    }

    .dd-handle {
        display: block;
        height: 30px;
        margin: 5px 0;
        padding: 5px 10px;
        color: var(--default-text-color);
        text-decoration: none;
        font-weight: bold;
        background: var(--hover);
        box-sizing: border-box;
        -moz-box-sizing: border-box;
    }

    .dd-handle:hover {
        background: var(--table-line)
    }

    .dd-placeholder,
    .dd-empty {
        margin: 5px 0;
        padding: 0;
        min-height: 30px;
        border: 1px dashed #b6bcbf;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
    }

    .dd-empty {
        border: 1px dashed #bbb;
        min-height: 100px;
        background-color: #e5e5e5;
        background-size: 60px 60px;
        background-position: 0 0, 30px 30px;
    }

    .dd-dragel {
        position: absolute;
        pointer-events: none;
        z-index: 9999;
    }

    .dd-dragel>.dd-item .dd-handle {
        margin-top: 0;
    }

    @media only screen and (min-width: 700px) {
        .dd {
            width: 100%;
        }
    }

</style>