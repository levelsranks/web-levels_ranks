function _init() {
    "use strict";
    var e = $(".slimScroll");
    e.length && e.each(function() {
        var e = $(this),
            i = e.data();
        e.slimscroll({
            height: i.height ? i.height + "px" : $(window).height() - 0 + "px",
            color: i.color ? i.color : "rgba(0,0,0,0.95)",
            size: i.size ? i.size + "px" : "5px"
        })
    }), $.Panel.layout = {
        activate: function() {
            var e = this;
            e.fix(), e.fixSidebar(), $(window, ".wrapper").on("resize", function() {
                e.fix(), e.fixSidebar()
            })
        },
        fix: function() {
            var e = $(".main-header").outerHeight() + $(".main-footer").outerHeight(),
                i = $(window).height(),
                t = $(".sidebar").height();
            if ($("body").hasClass("fixed")) $(".content-wrapper, .right-side").css("min-height", i - $(".main-footer").outerHeight());
            else {
                var a;
                a = t <= i ? ($(".content-wrapper, .right-side").css("min-height", i - e), i - e) : ($(".content-wrapper, .right-side").css("min-height", t), t);
                var s = $($.Panel.options.controlSidebarOptions.selector);
                void 0 !== s && s.height() > a && $(".content-wrapper, .right-side").css("min-height", s.height())
            }
        },
        fixSidebar: function() {
            $(".main-sidebar").hasClass("fixed") ? (void 0 === $.fn.slimScroll && window.console && window.console.error("Error: the fixed layout requires the slimscroll plugin!"), $.Panel.options.sidebarSlimScroll && void 0 !== $.fn.slimScroll && ($(".sidebar").slimScroll({
                destroy: !0
            }).height("auto"), $(".sidebar").slimscroll({
                height: $(window).height() + "px",
                color: "rgba(0,0,0,0.3)",
                size: "5px"
            }))) : void 0 !== $.fn.slimScroll && $(".sidebar").slimScroll({
                destroy: !0
            }).height("auto")
        }
    }, $.Panel.pushMenu = {
        activate: function(e) {
            var i = $.Panel.options.screenSizes;
            $(".sidebar-offcanvas-desktop").length && ($("body").addClass("sidebar-collapse"), $(".sidebar-offcanvas-desktop").show()), $(document).on("click", e, function(e) {
                e.preventDefault(), e.stopPropagation(), $(window).width() > i.md - 1 ? $("body").hasClass("sidebar-collapse") ? ($(".offcanvas").parent().removeClass("sidebar-collapse"), $.post("./app/includes/js_controller.php", {function: 'sidebar',setup: 1}) && $("body").removeClass("sidebar-collapse").trigger("expanded.pushMenu"), $(".sidebar-offcanvas-desktop").length && $("body").addClass("sidebar-open").trigger("expanded.pushMenu")) : $.post("./app/includes/js_controller.php", {function: 'sidebar',setup: 0}) && $("body").addClass("sidebar-collapse").trigger("collapsed.pushMenu") : $("body").hasClass("sidebar-open") ? $("body").removeClass("sidebar-open").removeClass("sidebar-collapse").trigger("collapsed.pushMenu") : $("body").addClass("sidebar-open").trigger("expanded.pushMenu")
            }), $(".page").on("click", function() {
                $(window).width() <= i.md - 1 && $("body").hasClass("sidebar-open") && $("body").removeClass("sidebar-open")
            })
        }
    }, $.Panel.tree = function(e) {
        var o = this,
            n = $.Panel.options.animationSpeed;
        $(document).on("click", e + " li a", function(e) {
            var i = $(this),
                t = i.next();
            if (t.is(".treeview-menu") && t.is(":visible") && !$("body").hasClass("sidebar-collapse")) t.slideUp(n, function() {
                t.removeClass("menu-open")
            }), t.parent("li").removeClass("active");
            else if (t.is(".treeview-menu") && !t.is(":visible")) {
                var a = i.parents("ul").first();
                a.find("ul:visible").slideUp(n).removeClass("menu-open");
                var s = i.parent("li");
                t.slideDown(n, function() {
                    t.addClass("menu-open"), a.find("li.active").removeClass("active"), s.addClass("active"), o.layout.fix()
                })
            }
            t.is(".treeview-menu") && e.preventDefault()
        })
    }
}! function(z) {
    z.fn.extend({
        slimScroll: function(A) {
            var P = z.extend({
                width: "auto",
                height: "250px",
                size: "7px",
                color: "#000",
                position: "right",
                distance: "1px",
                start: "top",
                opacity: .4,
                alwaysVisible: !1,
                disableFadeOut: !1,
                railVisible: !1,
                railColor: "#333",
                railOpacity: .2,
                railDraggable: !0,
                railClass: "slimScrollRail",
                barClass: "slimScrollBar",
                wrapperClass: "slimScrollDiv",
                allowPageScroll: !1,
                wheelStep: 20,
                touchScrollStep: 200,
                borderRadius: "7px",
                railBorderRadius: "7px"
            }, A);
            return this.each(function() {
                var a, e, s, i, o, n, r, l, d = "<div></div>",
                    c = 30,
                    h = !1,
                    p = z(this);
                if (p.parent().hasClass(P.wrapperClass)) {
                    var u = p.scrollTop();
                    if (m = p.siblings("." + P.barClass), v = p.siblings("." + P.railClass), y(), z.isPlainObject(A)) {
                        if ("height" in A && "auto" == A.height) {
                            p.parent().css("height", "auto"), p.css("height", "auto");
                            var g = p.parent().parent().height();
                            p.parent().css("height", g), p.css("height", g)
                        } else if ("height" in A) {
                            var f = A.height;
                            p.parent().css("height", f), p.css("height", f)
                        }
                        if ("scrollTo" in A) u = parseInt(P.scrollTo);
                        else if ("scrollBy" in A) u += parseInt(P.scrollBy);
                        else if ("destroy" in A) return m.remove(), v.remove(), void p.unwrap();
                        C(u, !1, !0)
                    }
                } else if (!(z.isPlainObject(A) && "destroy" in A)) {
                    P.height = "auto" == P.height ? p.parent().height() : P.height;
                    var b = z(d).addClass(P.wrapperClass).css({
                        position: "relative",
                        overflow: "hidden",
                        width: P.width,
                        height: P.height
                    });
                    p.css({
                        overflow: "hidden",
                        width: P.width,
                        height: P.height
                    });
                    var v = z(d).addClass(P.railClass).css({
                            width: P.size,
                            height: "100%",
                            position: "absolute",
                            top: 0,
                            display: P.alwaysVisible && P.railVisible ? "block" : "none",
                            "border-radius": P.railBorderRadius,
                            background: P.railColor,
                            opacity: P.railOpacity,
                            zIndex: 90
                        }),
                        m = z(d).addClass(P.barClass).css({
                            background: P.color,
                            width: P.size,
                            position: "absolute",
                            top: 0,
                            opacity: P.opacity,
                            display: P.alwaysVisible ? "block" : "none",
                            "border-radius": P.borderRadius,
                            BorderRadius: P.borderRadius,
                            MozBorderRadius: P.borderRadius,
                            WebkitBorderRadius: P.borderRadius,
                            zIndex: 99
                        }),
                        $ = "right" == P.position ? {
                            right: P.distance
                        } : {
                            left: P.distance
                        };
                    v.css($), m.css($), p.wrap(b), p.parent().append(m), p.parent().append(v), P.railDraggable && m.bind("mousedown", function(e) {
                        var i = z(document);
                        return s = !0, t = parseFloat(m.css("top")), pageY = e.pageY, i.bind("mousemove.slimscroll", function(e) {
                            currTop = t + e.pageY - pageY, m.css("top", currTop), C(0, m.position().top, !1)
                        }), i.bind("mouseup.slimscroll", function(e) {
                            s = !1, S(), i.unbind(".slimscroll")
                        }), !1
                    }).bind("selectstart.slimscroll", function(e) {
                        return e.stopPropagation(), e.preventDefault(), !1
                    }), v.hover(function() {
                        x()
                    }, function() {
                        S()
                    }), m.hover(function() {
                        e = !0
                    }, function() {
                        e = !1
                    }), p.hover(function() {
                        a = !0, x(), S()
                    }, function() {
                        a = !1, S()
                    }), p.bind("touchstart", function(e, i) {
                        e.originalEvent.touches.length && (o = e.originalEvent.touches[0].pageY)
                    }), p.bind("touchmove", function(e) {
                        h || e.originalEvent.preventDefault(), e.originalEvent.touches.length && (C((o - e.originalEvent.touches[0].pageY) / P.touchScrollStep, !0), o = e.originalEvent.touches[0].pageY)
                    }), y(), "bottom" === P.start ? (m.css({
                        top: p.outerHeight() - m.outerHeight()
                    }), C(0, !0)) : "top" !== P.start && (C(z(P.start).position().top, null, !0), P.alwaysVisible || m.hide()), window.addEventListener ? (this.addEventListener("DOMMouseScroll", w, !1), this.addEventListener("mousewheel", w, !1)) : document.attachEvent("onmousewheel", w)
                }

                function w(e) {
                    if (a) {
                        var i = 0;
                        (e = e || window.event).wheelDelta && (i = -e.wheelDelta / 120), e.detail && (i = e.detail / 3);
                        var t = e.target || e.srcTarget || e.srcElement;
                        z(t).closest("." + P.wrapperClass).is(p.parent()) && C(i, !0), e.preventDefault && !h && e.preventDefault(), h || (e.returnValue = !1)
                    }
                }

                function C(e, i, t) {
                    h = !1;
                    var a = e,
                        s = p.outerHeight() - m.outerHeight();
                    if (i && (a = parseInt(m.css("top")) + e * parseInt(P.wheelStep) / 100 * m.outerHeight(), a = Math.min(Math.max(a, 0), s), a = 0 < e ? Math.ceil(a) : Math.floor(a), m.css({
                        top: a + "px"
                    })), a = (r = parseInt(m.css("top")) / (p.outerHeight() - m.outerHeight())) * (p[0].scrollHeight - p.outerHeight()), t) {
                        var o = (a = e) / p[0].scrollHeight * p.outerHeight();
                        o = Math.min(Math.max(o, 0), s), m.css({
                            top: o + "px"
                        })
                    }
                    p.scrollTop(a), p.trigger("slimscrolling", ~~a), x(), S()
                }

                function y() {
                    n = Math.max(p.outerHeight() / p[0].scrollHeight * p.outerHeight(), c), m.css({
                        height: n + "px"
                    });
                    var e = n == p.outerHeight() ? "none" : "block";
                    m.css({
                        display: e
                    })
                }

                function x() {
                    if (y(), clearTimeout(i), r == ~~r) {
                        if (h = P.allowPageScroll, l != r) {
                            var e = 0 == ~~r ? "top" : "bottom";
                            p.trigger("slimscroll", e)
                        }
                    } else h = !1;
                    l = r, n >= p.outerHeight() ? h = !0 : (m.stop(!0, !0).fadeIn("fast"), P.railVisible && v.stop(!0, !0).fadeIn("fast"))
                }

                function S() {
                    P.alwaysVisible || (i = setTimeout(function() {
                        P.disableFadeOut && a || e || s || (m.fadeOut("slow"), v.fadeOut("slow"))
                    }, 1e3))
                }
            }), this
        }
    }), z.fn.extend({
        slimscroll: z.fn.slimScroll
    })
}(jQuery), $(function() {
    "use strict";
    $.Panel = {}, $.Panel.options = {
        animationSpeed: 500,
        sidebarToggleSelector: "[data-toggle='offcanvas']",
        sidebarPushMenu: !0,
        navbarMenuSlimscrollWidth: "3px",
        sidebarSlimScroll: !0,
        controlSidebarOptions: {
            toggleBtnSelector: "[data-toggle='control-sidebar']",
            selector: ".control-sidebar",
            slide: !0
        },
        screenSizes: {
            xs: 480,
            sm: 768,
            md: 1025,
            lg: 1200
        }
    }, $("body").removeClass("hold-transition"), "undefined" != typeof PanelOptions && $.extend(!0, $.Panel.options, PanelOptions);
    var e = $.Panel.options;
    _init(), $.Panel.layout.activate(), $.Panel.tree(".sidebar"), e.enableControlSidebar && $.Panel.controlSidebar.activate(), e.sidebarPushMenu && $.Panel.pushMenu.activate(e.sidebarToggleSelector), $('.btn-group[data-toggle="btn-toggle"]').each(function() {
        var i = $(this);
        $(this).find(".btn").on("click", function(e) {
            i.find(".btn.active").removeClass("active"), $(this).addClass("active"), e.preventDefault()
        })
    })
}),
    function(v, m, e, t) {
        function a(e, i) {
            return e[i] === t ? P[i] : e[i]
        }

        function $() {
            var e = m.pageYOffset;
            return e === t ? A.scrollTop : e
        }

        function w(e, i) {
            var t = P["on" + e];
            t && (z(t) ? t.call(i[0]) : (t.addClass && i.addClass(t.addClass), t.removeClass && i.removeClass(t.removeClass))), i.trigger("lazy" + e, [i]), d()
        }

        function C(e) {
            w(e.type, v(this).off(S, C))
        }

        function i(e) {
            if (E.length) {
                e = e || P.forceLoad, M = 1 / 0;
                var i, t, a = $(),
                    s = m.innerHeight || A.clientHeight,
                    o = m.innerWidth || A.clientWidth;
                for (i = 0, t = E.length; i < t; i++) {
                    var n, r = E[i],
                        l = r[0],
                        d = r[y],
                        c = !1,
                        h = e || H(l, x) < 0;
                    if (v.contains(A, l)) {
                        if (e || !d.visibleOnly || l.offsetWidth || l.offsetHeight) {
                            if (!h) {
                                var p = l.getBoundingClientRect(),
                                    u = d.edgeX,
                                    g = d.edgeY;
                                h = (n = p.top + a - g - s) <= a && p.bottom > -g && p.left <= o + u && p.right > -u
                            }
                            if (h) {
                                r.on(S, C), w("show", r);
                                var f = d.srcAttr,
                                    b = z(f) ? f(r) : l.getAttribute(f);
                                b && (l.src = b), c = !0
                            } else n < M && (M = n)
                        }
                    } else c = !0;
                    c && (H(l, x, 0), E.splice(i--, 1), t--)
                }
                t || w("complete", v(A))
            }
        }

        function s() {
            1 < p ? (p = 1, i(), setTimeout(s, P.throttle)) : p = 0
        }

        function d(e) {
            E.length && (e && "scroll" === e.type && e.currentTarget === m && M >= $() || (p || setTimeout(s, 0), p = 2))
        }

        function o() {
            l.lazyLoadXT()
        }

        function n() {
            i(!0)
        }
        var y = "lazyLoadXT",
            x = "lazied",
            S = "load error",
            r = "lazy-hidden",
            A = e.documentElement || e.body,
            P = {
                autoInit: !0,
                selector: "img[data-src]",
                blankImage: "data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7",
                throttle: 99,
                forceLoad: m.onscroll === t || !!m.operamini || !A.getBoundingClientRect,
                loadEvent: "pageshow",
                updateEvent: "load orientationchange resize scroll touchmove focus",
                forceEvent: "lazyloadall",
                oninit: {
                    removeClass: "lazy"
                },
                onshow: {
                    addClass: r
                },
                onload: {
                    removeClass: r,
                    addClass: "lazy-loaded"
                },
                onerror: {
                    removeClass: r
                },
                checkDuplicates: !0
            },
            c = {
                srcAttr: "data-src",
                edgeX: 0,
                edgeY: 0,
                visibleOnly: !0
            },
            l = v(m),
            z = v.isFunction,
            h = v.extend,
            H = v.data || function(e, i) {
                return v(e).data(i)
            },
            E = [],
            M = 0,
            p = 0;
        v[y] = h(P, c, v[y]), v.fn[y] = function(s) {
            var e, o = a(s = s || {}, "blankImage"),
                n = a(s, "checkDuplicates"),
                i = a(s, "scrollContainer"),
                r = a(s, "show"),
                l = {};
            for (e in v(i).on("scroll", d), c) l[e] = a(s, e);
            return this.each(function(e, i) {
                if (i === m) v(P.selector).lazyLoadXT(s);
                else {
                    var t = n && H(i, x),
                        a = v(i).data(x, r ? -1 : 1);
                    if (t) return void d();
                    o && "IMG" === i.tagName && !i.src && (i.src = o), a[y] = h({}, l), w("init", a), E.push(a), d()
                }
            })
        }, v(e).ready(function() {
            w("start", l), l.on(P.updateEvent, d).on(P.forceEvent, n), v(e).on(P.updateEvent, d), P.autoInit && (l.on(P.loadEvent, o), o())
        })
    }(window.jQuery || window.Zepto || window.$, window, document);
    /*$(".swipe-area").swipe({
    swipeStatus: function(e, i, t, a, s, o) {
        return "move" == i && "right" == t ? ($("body").removeClass("sidebar-collapse"), $("body").addClass("sidebar-open"), !1) : "move" == i && "left" == t ? ($("body").addClass("sidebar-collapse"), $("body").removeClass("sidebar-open"), !1) : void 0
    }
});*/
if (avatar != 0) {
    $.post("./app/includes/js_controller.php", {function: 'avatars', data: avatar}, function (e) {
        for (var i = 0; i < avatar.length; i++) document.getElementById(avatar[i]).setAttribute("src", "storage/cache/img/avatars/" + avatar[i] + ".jpg")
    })
};
function dark_mode() {

    var dark_mode = $.ajax({
        type: 'POST',
        url: "./app/includes/js_controller.php",
        data: ({function:'sessions', data:'dark_mode'}),
        dataType: 'text',
        global: false,
        async:false,
        success: function(data) {
            return data;
        }
    }).responseText;

    var theme = $.ajax({
        type: 'POST',
        url: "./app/includes/js_controller.php",
        data: ({function:'options', setup:'theme'}),
        dataType: 'text',
        global: false,
        async:false,
        success: function( data ) {
            return data;
        }
    }).responseText;

    if (dark_mode == 0) {

        var str = './storage/assets/css/themes/' + theme + '/dark_mode_palette.json';

        var palette = $.ajax({
            type: 'GET',
            url: str.split('"').join(''),
            success: function( data ){
                return data;
            },
            dataType: 'json',
            global: false,
            async:false,
            cache: true
        }).responseText;

        var obj = $.parseJSON( palette );

        $.post("./app/includes/js_controller.php", {function: 'dark_mode', setup: '1'});

        for (var key in obj) {
            document.documentElement.style.setProperty(key, obj[key]);
        }

    } else if (dark_mode == 1) {

        var str = './storage/assets/css/themes/' + theme + '/original_palette.json';

        var palette = $.ajax({
            type: 'GET',
            url: str.split('"').join(''),
            success: function( data ){
                return data;
            },
            dataType: 'json',
            global: false,
            async:false,
            cache: true
        }).responseText;

        var obj = JSON.parse( palette );

        $.post("./app/includes/js_controller.php", {function: 'dark_mode', setup: '0'});

        for (var key in obj) {
            document.documentElement.style.setProperty(key, obj[key]);
        }

    }

}