/* Lazy Load XT 1.1.0 | MIT License */
!function(a,b,c,d){function e(a,b){return a[b]===d?t[b]:a[b]}function f(){var a=b.pageYOffset;return a===d?r.scrollTop:a}function g(a,b){var c=t["on"+a];c&&(w(c)?c.call(b[0]):(c.addClass&&b.addClass(c.addClass),c.removeClass&&b.removeClass(c.removeClass))),b.trigger("lazy"+a,[b]),k()}function h(b){g(b.type,a(this).off(p,h))}function i(c){if(z.length){c=c||t.forceLoad,A=1/0;var d,e,i=f(),j=b.innerHeight||r.clientHeight,k=b.innerWidth||r.clientWidth;for(d=0,e=z.length;e>d;d++){var l,m=z[d],q=m[0],s=m[n],u=!1,v=c||y(q,o)<0;if(a.contains(r,q)){if(c||!s.visibleOnly||q.offsetWidth||q.offsetHeight){if(!v){var x=q.getBoundingClientRect(),B=s.edgeX,C=s.edgeY;l=x.top+i-C-j,v=i>=l&&x.bottom>-C&&x.left<=k+B&&x.right>-B}if(v){m.on(p,h),g("show",m);var D=s.srcAttr,E=w(D)?D(m):q.getAttribute(D);E&&(q.src=E),u=!0}else A>l&&(A=l)}}else u=!0;u&&(y(q,o,0),z.splice(d--,1),e--)}e||g("complete",a(r))}}function j(){B>1?(B=1,i(),setTimeout(j,t.throttle)):B=0}function k(a){z.length&&(a&&"scroll"===a.type&&a.currentTarget===b&&A>=f()||(B||setTimeout(j,0),B=2))}function l(){v.lazyLoadXT()}function m(){i(!0)}var n="lazyLoadXT",o="lazied",p="load error",q="lazy-hidden",r=c.documentElement||c.body,s=b.onscroll===d||!!b.operamini||!r.getBoundingClientRect,t={autoInit:!0,selector:"img[data-src]",blankImage:"data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7",throttle:99,forceLoad:s,loadEvent:"pageshow",updateEvent:"load orientationchange resize scroll touchmove focus",forceEvent:"lazyloadall",oninit:{removeClass:"lazy"},onshow:{addClass:q},onload:{removeClass:q,addClass:"lazy-loaded"},onerror:{removeClass:q},checkDuplicates:!0},u={srcAttr:"data-src",edgeX:0,edgeY:0,visibleOnly:!0},v=a(b),w=a.isFunction,x=a.extend,y=a.data||function(b,c){return a(b).data(c)},z=[],A=0,B=0;a[n]=x(t,u,a[n]),a.fn[n]=function(c){c=c||{};var d,f=e(c,"blankImage"),h=e(c,"checkDuplicates"),i=e(c,"scrollContainer"),j=e(c,"show"),l={};a(i).on("scroll",k);for(d in u)l[d]=e(c,d);return this.each(function(d,e){if(e===b)a(t.selector).lazyLoadXT(c);else{var i=h&&y(e,o),m=a(e).data(o,j?-1:1);if(i)return void k();f&&"IMG"===e.tagName&&!e.src&&(e.src=f),m[n]=x({},l),g("init",m),z.push(m),k()}})},a(c).ready(function(){g("start",v),v.on(t.updateEvent,k).on(t.forceEvent,m),a(c).on(t.updateEvent,k),t.autoInit&&(v.on(t.loadEvent,l),l())})}(window.jQuery||window.Zepto||window.$,window,document),function(a){var b=a.lazyLoadXT;b.selector+=",video,iframe[data-src]",b.videoPoster="data-poster",a(document).on("lazyshow","video",function(c,d){var e=d.lazyLoadXT.srcAttr,f=a.isFunction(e),g=!1;d.attr("poster",d.attr(b.videoPoster)),d.children("source,track").each(function(b,c){var d=a(c),h=f?e(d):d.attr(e);h&&(d.attr("src",h),g=!0)}),g&&this.load()})}(window.jQuery||window.Zepto||window.$);

!function(d) {

    "use strict";

    Object.assign||Object.defineProperty(Object,"assign",{enumerable:!1,configurable:!0,writable:!0,value:function(e,r){"use strict";if(null==e)throw new TypeError("Cannot convert first argument to object");for(var t=Object(e),n=1;n<arguments.length;n++){var o=arguments[n];if(null!=o)for(var a=Object.keys(Object(o)),c=0,b=a.length;c<b;c++){var i=a[c],l=Object.getOwnPropertyDescriptor(o,i);void 0!==l&&l.enumerable&&(t[i]=o[i])}}return t}});

    "remove" in Element.prototype||(Element.prototype.remove=function(){this.parentNode&&this.parentNode.removeChild(this)});

    window.note = function(settings) {

        settings = Object.assign({},{
            callback:    false,
            content:     "",
            time:        4.5,
            type:        "info"
        }, settings);

        if(!settings.content.length) return;

        var create = function(name, attr, append, content) {
            var node = d.createElement(name);
            for(var val in attr) { if(attr.hasOwnProperty(val)) node.setAttribute(val, attr[val]); }
            if(content) node.insertAdjacentHTML("afterbegin", content);
            append.appendChild(node);
            if(node.classList.contains("note-item-hidden")) node.classList.remove("note-item-hidden");
            return node;
        };

        var noteBox = d.getElementById("notes") || create("div", { "id": "notes" }, d.body);
        var noteItem = create("div", {
                "class": "note-item",
                "data-show": "false",
                "role": "alert",
                "data-type": settings.type
            }, noteBox),
            noteItemText = create("div", { "class": "note-item-text" }, noteItem, settings.content),
            noteItemBtn = create("button", {
                "class": "note-item-btn",
                "type": "button",
            }, noteItem);

        var isVisible = function() {
            var coords = noteItem.getBoundingClientRect();
            return (
                coords.top >= 0 &&
                coords.left >= 0 &&
                coords.bottom <= (window.innerHeight || d.documentElement.clientHeight) &&
                coords.right <= (window.innerWidth || d.documentElement.clientWidth)
            );
        };

        var remove = function(el) {
            el = el || noteItem;
            el.setAttribute("data-show","false");
            window.setTimeout(function() {
                el.remove();
            }, 250);
            if(settings.callback) settings.callback(); // callback
        };

        noteItemBtn.addEventListener("click", function() { remove(); });

        window.setTimeout(function() {
            noteItem.setAttribute("data-show","true");
        }, 250);

        if(!isVisible()) remove(noteBox.firstChild);

        window.setTimeout(remove, settings.time * 1000);

    };

}(document);

if (avatar != 0) {
    $.post(domain + "/app/includes/js_controller.php", {
        function: 'avatars', 
        data: avatar
    }, function (e) {
        var jsonData = $.parseJSON(e);
        if(typeof jsonData[0] !== 'undefined')
        {
            for (var i = 0; i < avatar.length; i++) {
                document.getElementById(avatar[i]).setAttribute("src", jsonData[i]);
            }
        }
    })
};

function action_sidebar() {
    if ($('body').hasClass('sidebar-collapse') || $('body').hasClass('sidebar-open')) {
        if (window.innerWidth > 1026) {
            $.post(domain + "/app/includes/js_controller.php", {function: 'sidebar', setup: 1});
            $("body").removeClass("sidebar-collapse");
            $("body").removeClass("sidebar-open");
        } else {
            $.post(domain + "/app/includes/js_controller.php", {function: 'sidebar', setup: 1});
            $("body").removeClass("sidebar-collapse");
            $("body").removeClass("sidebar-open");
        }
    } else {
        if (window.innerWidth > 1026) {
            $.post(domain + "/app/includes/js_controller.php", {function: 'sidebar', setup: 0});
            $("body").removeClass("sidebar-open");
            $("body").addClass("sidebar-collapse");
        } else {
            $.post(domain + "/app/includes/js_controller.php", {function: 'sidebar', setup: 1});
            $("body").removeClass("sidebar-collapse");
            $("body").addClass("sidebar-open");
        }
    }
}

function action_treeview() {
    if ($(".treeview-menu").hasClass('menu-open')) {
        $(".treeview-menu").removeClass("menu-open");
        $( ".treeview-menu" ).slideUp();
    } else {
        $(".treeview-menu").addClass("menu-open")
        $( ".treeview-menu" ).slideDown();
    }
}

function set_options_data(data_id,change_data) {
    $.post( domain + "/app/includes/js_controller.php", { function: "set", option: data_id, change: change_data } );
    note({
        content: 'Сохранено',
        type: 'success',
        time: 3
    });
}

function set_options_data_select( name, value ) {
    $.post( domain + "/app/includes/js_controller.php", { function: "set", option: name, data: value } );
    note({
        content: 'Сохранено',
        type: 'success',
        time: 3
    });

    if( name == 'white_palette' ) {
        change_palette( value );
    } else if ( name == 'dark_palette' ) {
        change_palette( value );
    } else if ( name == 'background_image' ) {
        change_background_image( value );
    } else if ( name == 'graphics_container' ) {
       if( value == 'stretch' ) {
           $( '.container-fluid' ).css( 'max-width', '1920px' );
       } else if( value == 'static' ) {
           $( '.container-fluid' ).css( 'max-width', '1400px' );
       }
    }
}

function change_background_image( value ) {

    var str = domain + '/storage/cache/img/global/backgrounds/' + value;

    document.body.style.backgroundImage = 'url(' + str + ')';

}

function SaveInStorage(key, value) {
    if (typeof(Storage) !== 'undefined') {
        sessionStorage.setItem(key, value);
    }
}

function LoadFromStorage(key) {
    if (typeof(Storage) !== 'undefined') {
        return sessionStorage.getItem(key);
    }
    else {
        return '';
    }
}
//Notifications -->
var notifications = {};
var nonot = true;

function PlaySound(src) {
    var audio = new Audio(src);
    audio.play();
}

function main_notifications_icon_adjust(count,$html){
    if(count != 0){
        $('#main_notifications_badge').html(count);
        $('#main_notifications_badge').show();
        return true;
    }else{
        $('#main_notifications').html($html);
        $('#main_notifications_badge').html(false);
        $('#main_notifications_badge').hide();
        return false;
    }
}

var main_notifications_cooldown  = false;

function main_notifications_refresh(){
    $.ajax({
        type: 'POST',
        url: window.location.href,
        data: {entryid: 1},
        success: function(reuslt){
            if(IsJsonString(reuslt)){
                var data = jQuery.parseJSON(reuslt);
                SaveInStorage('notifications_count', data['count']);
                if(main_notifications_icon_adjust(data['count'],data['no_notifications'])){
                    if(nonot){$('#main_notifications').html('');}
                    data['notifications'].forEach(function(notification){
                        if(!notifications.hasOwnProperty(notification['id'])){
                            $('#main_notifications').prepend(notification['html']);
                            notifications[notification['id']] = true;
                            if(notification['seen'] == 0 && main_notifications_cooldown == false){
                                main_notifications_cooldown = true;
                                setTimeout(function(){main_notifications_cooldown = false;}, 3000)
                                PlaySound('storage/assets/sounds/Knock.mp3');
                            }
                        }
                    });

                    nonot = false;
                }else{
                    nonot = true;
                }
            }
        }
    });
}

function main_notifications_load(){
    var count_saved = LoadFromStorage('notifications_count');

    if($.isNumeric(count_saved)){
        main_notifications_icon_adjust(count_saved);
    }

    main_notifications_refresh();

    setInterval(main_notifications_refresh, 30000);
}

function main_notifications_chek(id){
    $.ajax({
        type: 'POST',
        url: window.location.href,
        data: {
            notific: id
        },
        success: function(){
            main_notifications_refresh();
        }
    });
}

//<-- Notifications
main_notifications_load();

function IsJsonString(str) {
    try {
        JSON.parse(str);
    } catch (e) {
        return false;
    }
    return true;
}

$('#admin_idebar_right').click(function(){
    if($('.sidebar-right').hasClass("unshow"))
    {
        $('.sidebar-right').removeClass("unshow");
        SaveInStorage('panel_state', 'false');
    }
    else
    {
        $('.sidebar-right').addClass("unshow");
        SaveInStorage('panel_state', 'true');
    }
});

if(LoadFromStorage('panel_state') === 'true') {
    $('.sidebar-right').addClass("unshow");
} else {
    $('.sidebar-right').removeClass("unshow");
}

function updateURL(text) {
    if (history.pushState) {
        var baseUrl = window.location.protocol + "//" + window.location.host + window.location.pathname;
        var newUrl = baseUrl + text;
        history.pushState(null, null, newUrl);
    }
    else {
        console.warn('History API не поддерживается');
    }
}
$(".tooltip-js").on('mouseenter', function() {
    if ($('body').hasClass('sidebar-collapse')) {
    data = $(this).attr("data-tooltip-js");
    var offsetTop = $(this).offset().top + 7;
    var offsetLeft = $(this).offset().left + $(this).width() + 10;
    if (data.indexOf('srv-') != -1){
        offsetTop -= 10;
        offsetLeft += 30;
    }
    $('.box-button-'+data).css({
        top: offsetTop,
        left: offsetLeft -20,
        opacity: 0,
        display: 'inline-block'     
    }).animate({opacity: 1, left: offsetLeft},500);
    }
});
$(".tooltip-js").on('mouseleave', function() {
    data = $(this).attr("data-tooltip-js");
    $('.box-button-'+data).css({
        opacity: 0,
        display: 'none'
    });
    $('.box-button-'+data).offset({top: 0, left: 0});
});

