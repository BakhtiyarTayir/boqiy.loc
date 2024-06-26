/*! 
 * Boss Theme JavaScript Library 
 * @package Boss Theme 
 */
function excluded_inputs_selector(a) {
    return BuddyBossOptions.excluded_inputs.length ? BuddyBossOptions.excluded_inputs.filter(Boolean).reduce(function (a, b) {
        return a + ":not(" + b + ")"
    }, a) : a
}! function (a, b, c) {
    function d(a) {
        var b = y.className,
            c = w._config.classPrefix || "";
        if (z && (b = b.baseVal), w._config.enableJSClass) {
            var d = new RegExp("(^|\\s)" + c + "no-js(\\s|$)");
            b = b.replace(d, "$1" + c + "js$2")
        }
        w._config.enableClasses && (b += " " + c + a.join(" " + c), z ? y.className.baseVal = b : y.className = b)
    }

    function e(a, b) {
        return typeof a === b
    }

    function f() {
        var a, b, c, d, f, g, h;
        for (var i in u)
            if (u.hasOwnProperty(i)) {
                if (a = [], b = u[i], b.name && (a.push(b.name.toLowerCase()), b.options && b.options.aliases && b.options.aliases.length))
                    for (c = 0; c < b.options.aliases.length; c++) a.push(b.options.aliases[c].toLowerCase());
                for (d = e(b.fn, "function") ? b.fn() : b.fn, f = 0; f < a.length; f++) g = a[f], h = g.split("."), 1 === h.length ? w[h[0]] = d : (!w[h[0]] || w[h[0]] instanceof Boolean || (w[h[0]] = new Boolean(w[h[0]])), w[h[0]][h[1]] = d), t.push((d ? "" : "no-") + h.join("-"))
            }
    }

    function g(a, b) {
        return !!~("" + a).indexOf(b)
    }

    function h() {
        return "function" != typeof b.createElement ? b.createElement(arguments[0]) : z ? b.createElementNS.call(b, "http://www.w3.org/2000/svg", arguments[0]) : b.createElement.apply(b, arguments)
    }

    function i(a) {
        return a.replace(/([a-z])-([a-z])/g, function (a, b, c) {
            return b + c.toUpperCase()
        }).replace(/^-/, "")
    }

    function j() {
        var a = b.body;
        return a || (a = h(z ? "svg" : "body"), a.fake = !0), a
    }

    function k(a, c, d, e) {
        var f, g, i, k, l = "modernizr",
            m = h("div"),
            n = j();
        if (parseInt(d, 10))
            for (; d--;) i = h("div"), i.id = e ? e[d] : l + (d + 1), m.appendChild(i);
        return f = h("style"), f.type = "text/css", f.id = "s" + l, (n.fake ? n : m).appendChild(f), n.appendChild(m), f.styleSheet ? f.styleSheet.cssText = a : f.appendChild(b.createTextNode(a)), m.id = l, n.fake && (n.style.background = "", n.style.overflow = "hidden", k = y.style.overflow, y.style.overflow = "hidden", y.appendChild(n)), g = c(m, a), n.fake ? (n.parentNode.removeChild(n), y.style.overflow = k, y.offsetHeight) : m.parentNode.removeChild(m), !!g
    }

    function l(a, b) {
        return function () {
            return a.apply(b, arguments)
        }
    }

    function m(a, b, c) {
        var d;
        for (var f in a)
            if (a[f] in b) return c === !1 ? a[f] : (d = b[a[f]], e(d, "function") ? l(d, c || b) : d);
        return !1
    }

    function n(a) {
        return a.replace(/([A-Z])/g, function (a, b) {
            return "-" + b.toLowerCase()
        }).replace(/^ms-/, "-ms-")
    }

    function o(b, c, d) {
        var e;
        if ("getComputedStyle" in a) {
            e = getComputedStyle.call(a, b, c);
            var f = a.console;
            if (null !== e) d && (e = e.getPropertyValue(d));
            else if (f) {
                var g = f.error ? "error" : "log";
                f[g].call(f, "getComputedStyle returning null, its possible modernizr test results are inaccurate")
            }
        } else e = !c && b.currentStyle && b.currentStyle[d];
        return e
    }

    function p(b, d) {
        var e = b.length;
        if ("CSS" in a && "supports" in a.CSS) {
            for (; e--;)
                if (a.CSS.supports(n(b[e]), d)) return !0;
            return !1
        }
        if ("CSSSupportsRule" in a) {
            for (var f = []; e--;) f.push("(" + n(b[e]) + ":" + d + ")");
            return f = f.join(" or "), k("@supports (" + f + ") { #modernizr { position: absolute; } }", function (a) {
                return "absolute" == o(a, null, "position")
            })
        }
        return c
    }

    function q(a, b, d, f) {
        function j() {
            l && (delete J.style, delete J.modElem)
        }
        if (f = !e(f, "undefined") && f, !e(d, "undefined")) {
            var k = p(a, d);
            if (!e(k, "undefined")) return k
        }
        for (var l, m, n, o, q, r = ["modernizr", "tspan", "samp"]; !J.style && r.length;) l = !0, J.modElem = h(r.shift()), J.style = J.modElem.style;
        for (n = a.length, m = 0; n > m; m++)
            if (o = a[m], q = J.style[o], g(o, "-") && (o = i(o)), J.style[o] !== c) {
                if (f || e(d, "undefined")) return j(), "pfx" != b || o;
                try {
                    J.style[o] = d
                } catch (s) {}
                if (J.style[o] != q) return j(), "pfx" != b || o
            } return j(), !1
    }

    function r(a, b, c, d, f) {
        var g = a.charAt(0).toUpperCase() + a.slice(1),
            h = (a + " " + E.join(g + " ") + g).split(" ");
        return e(b, "string") || e(b, "undefined") ? q(h, b, d, f) : (h = (a + " " + B.join(g + " ") + g).split(" "), m(h, b, c))
    }

    function s(a, b, d) {
        return r(a, c, c, b, d)
    }
    var t = [],
        u = [],
        v = {
            _version: "3.6.0",
            _config: {
                classPrefix: "",
                enableClasses: !0,
                enableJSClass: !0,
                usePrefixes: !0
            },
            _q: [],
            on: function (a, b) {
                var c = this;
                setTimeout(function () {
                    b(c[a])
                }, 0)
            },
            addTest: function (a, b, c) {
                u.push({
                    name: a,
                    fn: b,
                    options: c
                })
            },
            addAsyncTest: function (a) {
                u.push({
                    name: null,
                    fn: a
                })
            }
        },
        w = function () {};
    w.prototype = v, w = new w;
    var x = v._config.usePrefixes ? " -webkit- -moz- -o- -ms- ".split(" ") : ["", ""];
    v._prefixes = x;
    var y = b.documentElement,
        z = "svg" === y.nodeName.toLowerCase();
    z || ! function (a, b) {
        function c(a, b) {
            var c = a.createElement("p"),
                d = a.getElementsByTagName("head")[0] || a.documentElement;
            return c.innerHTML = "x<style>" + b + "</style>", d.insertBefore(c.lastChild, d.firstChild)
        }

        function d() {
            var a = y.elements;
            return "string" == typeof a ? a.split(" ") : a
        }

        function e(a, b) {
            var c = y.elements;
            "string" != typeof c && (c = c.join(" ")), "string" != typeof a && (a = a.join(" ")), y.elements = c + " " + a, j(b)
        }

        function f(a) {
            var b = x[a[v]];
            return b || (b = {}, w++, a[v] = w, x[w] = b), b
        }

        function g(a, c, d) {
            if (c || (c = b), q) return c.createElement(a);
            d || (d = f(c));
            var e;
            return e = d.cache[a] ? d.cache[a].cloneNode() : u.test(a) ? (d.cache[a] = d.createElem(a)).cloneNode() : d.createElem(a), !e.canHaveChildren || t.test(a) || e.tagUrn ? e : d.frag.appendChild(e)
        }

        function h(a, c) {
            if (a || (a = b), q) return a.createDocumentFragment();
            c = c || f(a);
            for (var e = c.frag.cloneNode(), g = 0, h = d(), i = h.length; i > g; g++) e.createElement(h[g]);
            return e
        }

        function i(a, b) {
            b.cache || (b.cache = {}, b.createElem = a.createElement, b.createFrag = a.createDocumentFragment, b.frag = b.createFrag()), a.createElement = function (c) {
                return y.shivMethods ? g(c, a, b) : b.createElem(c)
            }, a.createDocumentFragment = Function("h,f", "return function(){var n=f.cloneNode(),c=n.createElement;h.shivMethods&&(" + d().join().replace(/[\w\-:]+/g, function (a) {
                return b.createElem(a), b.frag.createElement(a), 'c("' + a + '")'
            }) + ");return n}")(y, b.frag)
        }

        function j(a) {
            a || (a = b);
            var d = f(a);
            return !y.shivCSS || p || d.hasCSS || (d.hasCSS = !!c(a, "article,aside,dialog,figcaption,figure,footer,header,hgroup,main,nav,section{display:block}mark{background:#FF0;color:#000}template{display:none}")), q || i(a, d), a
        }

        function k(a) {
            for (var b, c = a.getElementsByTagName("*"), e = c.length, f = RegExp("^(?:" + d().join("|") + ")$", "i"), g = []; e--;) b = c[e], f.test(b.nodeName) && g.push(b.applyElement(l(b)));
            return g
        }

        function l(a) {
            for (var b, c = a.attributes, d = c.length, e = a.ownerDocument.createElement(A + ":" + a.nodeName); d--;) b = c[d], b.specified && e.setAttribute(b.nodeName, b.nodeValue);
            return e.style.cssText = a.style.cssText, e
        }

        function m(a) {
            for (var b, c = a.split("{"), e = c.length, f = RegExp("(^|[\\s,>+~])(" + d().join("|") + ")(?=[[\\s,>+~#.:]|$)", "gi"), g = "$1" + A + "\\:$2"; e--;) b = c[e] = c[e].split("}"), b[b.length - 1] = b[b.length - 1].replace(f, g), c[e] = b.join("}");
            return c.join("{")
        }

        function n(a) {
            for (var b = a.length; b--;) a[b].removeNode()
        }

        function o(a) {
            function b() {
                clearTimeout(g._removeSheetTimer), d && d.removeNode(!0), d = null
            }
            var d, e, g = f(a),
                h = a.namespaces,
                i = a.parentWindow;
            return !B || a.printShived ? a : ("undefined" == typeof h[A] && h.add(A), i.attachEvent("onbeforeprint", function () {
                b();
                for (var f, g, h, i = a.styleSheets, j = [], l = i.length, n = Array(l); l--;) n[l] = i[l];
                for (; h = n.pop();)
                    if (!h.disabled && z.test(h.media)) {
                        try {
                            f = h.imports, g = f.length
                        } catch (o) {
                            g = 0
                        }
                        for (l = 0; g > l; l++) n.push(f[l]);
                        try {
                            j.push(h.cssText)
                        } catch (o) {}
                    } j = m(j.reverse().join("")), e = k(a), d = c(a, j)
            }), i.attachEvent("onafterprint", function () {
                n(e), clearTimeout(g._removeSheetTimer), g._removeSheetTimer = setTimeout(b, 500)
            }), a.printShived = !0, a)
        }
        var p, q, r = "3.7.3",
            s = a.html5 || {},
            t = /^<|^(?:button|map|select|textarea|object|iframe|option|optgroup)$/i,
            u = /^(?:a|b|code|div|fieldset|h1|h2|h3|h4|h5|h6|i|label|li|ol|p|q|span|strong|style|table|tbody|td|th|tr|ul)$/i,
            v = "_html5shiv",
            w = 0,
            x = {};
        ! function () {
            try {
                var a = b.createElement("a");
                a.innerHTML = "<xyz></xyz>", p = "hidden" in a, q = 1 == a.childNodes.length || function () {
                    b.createElement("a");
                    var a = b.createDocumentFragment();
                    return "undefined" == typeof a.cloneNode || "undefined" == typeof a.createDocumentFragment || "undefined" == typeof a.createElement
                }()
            } catch (c) {
                p = !0, q = !0
            }
        }();
        var y = {
            elements: s.elements || "abbr article aside audio bdi canvas data datalist details dialog figcaption figure footer header hgroup main mark meter nav output picture progress section summary template time video",
            version: r,
            shivCSS: s.shivCSS !== !1,
            supportsUnknownElements: q,
            shivMethods: s.shivMethods !== !1,
            type: "default",
            shivDocument: j,
            createElement: g,
            createDocumentFragment: h,
            addElements: e
        };
        a.html5 = y, j(b);
        var z = /^$|\b(?:all|print)\b/,
            A = "html5shiv",
            B = !q && function () {
                var c = b.documentElement;
                return !("undefined" == typeof b.namespaces || "undefined" == typeof b.parentWindow || "undefined" == typeof c.applyElement || "undefined" == typeof c.removeNode || "undefined" == typeof a.attachEvent)
            }();
        y.type += " print", y.shivPrint = o, o(b), "object" == typeof module && module.exports && (module.exports = y)
    }("undefined" != typeof a ? a : this, b);
    var A = "Moz O ms Webkit",
        B = v._config.usePrefixes ? A.toLowerCase().split(" ") : [];
    v._domPrefixes = B;
    var C = "CSS" in a && "supports" in a.CSS,
        D = "supportsCSS" in a;
    w.addTest("supports", C || D);
    var E = v._config.usePrefixes ? A.split(" ") : [];
    v._cssomPrefixes = E;
    var F = h("input"),
        G = "search tel url email datetime date month week time datetime-local number range color".split(" "),
        H = {};
    w.inputtypes = function (a) {
        for (var d, e, f, g = a.length, h = "1)", i = 0; g > i; i++) F.setAttribute("type", d = a[i]), f = "text" !== F.type && "style" in F, f && (F.value = h, F.style.cssText = "position:absolute;visibility:hidden;", /^range$/.test(d) && F.style.WebkitAppearance !== c ? (y.appendChild(F), e = b.defaultView, f = e.getComputedStyle && "textfield" !== e.getComputedStyle(F, null).WebkitAppearance && 0 !== F.offsetHeight, y.removeChild(F)) : /^(search|tel)$/.test(d) || (f = /^(url|email)$/.test(d) ? F.checkValidity && F.checkValidity() === !1 : F.value != h)), H[a[i]] = !!f;
        return H
    }(G);
    var I = (v.testStyles = k, {
        elem: h("modernizr")
    });
    w._q.push(function () {
        delete I.elem
    });
    var J = {
        style: I.elem.style
    };
    w._q.unshift(function () {
        delete J.style
    }), v.testProp = function (a, b, d) {
        return q([a], c, b, d)
    }, v.testAllProps = r, v.testAllProps = s, w.addTest("csstransforms", function () {
        return -1 === navigator.userAgent.indexOf("Android 2.") && s("transform", "scale(1)", !0)
    }), w.addTest("csstransforms3d", function () {
        return !!s("perspective", "1px", !0)
    }), w.addTest("csstransitions", s("transition", "all", !0)), f(), d(t), delete v.addTest, delete v.addAsyncTest;
    for (var K = 0; K < w._q.length; K++) w._q[K]();
    a.Modernizr = w
}(window, document);
var Selects = {
    $: jQuery,
    $selects: !1,
    populate_select_label: function (a) {
        var b = jQuery;
        this.$selects && this.$selects.length && this.$selects.each(function (a, c) {
            var d, e = b(this),
                f = e.data("buddyboss-select-info");
            f && (f.$label || "pass" == e.data("state")) && (d = f.$label, d && d.length && (e.data("state", "mobile"), d.text(e.find("option:selected").text()).show()))
        })
    },
    init_select: function (a, b) {
        var c = 0,
            d = this,
            e = jQuery;
        if (b) {
            var f = excluded_inputs_selector("#page select:not([multiple]):not(#bbwall-privacy-selectbox):not(.bp-ap-selectbox):not(select#cat)");
            this.$selects = e(f + ", .boss-modal-form select:not([multiple])").filter(function () {
                return !e(this).closest(".frm_form_field").length
            })
        } else this.$selects = e(".messages-options-nav-drafts select, .item-list-tabs select, #whats-new-form select, .editfield select, #notifications-bulk-management select, #messages-bulk-management select, .field-visibility select, .register-section select, .bbp-form select, #bp-group-course, #bbp_group_forum_id, .boss-modal-form select:not([multiple]), .tablenav select, #event-form select, .em-search-category select, .em-search-country select");
        this.$selects.each(function () {
            var b, f, g, h, i = e(this),
                j = !1,
                k = "pass";
            if (!i.data("state") || "mobile" != i.data("state")) {
                if ("none" === this.style.display || i.hasClass("select2-hidden-accessible")) return;
                if (0 !== e(this).parents(".buddyboss-select").length) return;
                b = e('<div class="buddyboss-select"></div>'), e(this).hasClass("large") && b.addClass("large"), e(this).hasClass("small") && b.addClass("small"), e(this).hasClass("medium") && b.addClass("medium"), f = this.getAttribute("id") || "buddyboss-select-" + c, g = i.prev("span"), h = i.prev("label"), i.wrap(b), h.insertBefore(i), $inner_wrap = e('<div class="buddyboss-select-inner"></div>'), i.wrap($inner_wrap), g.length || (g = e("<span></span>").hide(), j = !0), g.insertBefore(i), i.data("buddyboss-select-info", {
                    dynamic: j,
                    $wrap: b,
                    $label: g,
                    orig_text: g.text()
                }), k = "init"
            }
            i.data("state", k), i.on("change", function (b) {
                d.populate_select_label(a)
            })
        })
    }
};
! function (a) {
    "use strict";
    a.fn.fitVids = function (b) {
        var c = {
            customSelector: null
        };
        if (!document.getElementById("fit-vids-style")) {
            var d = document.head || document.getElementsByTagName("head")[0],
                e = ".fluid-width-video-wrapper{width:100%;position:relative;padding:0;}.fluid-width-video-wrapper iframe,.fluid-width-video-wrapper object,.fluid-width-video-wrapper embed {position:absolute;top:0;left:0;width:100%;height:100%;}",
                f = document.createElement("div");
            f.innerHTML = '<p>x</p><style id="fit-vids-style">' + e + "</style>", d.appendChild(f.childNodes[1])
        }
        return b && a.extend(c, b), this.each(function () {
            var b = ["iframe[src*='player.vimeo.com']", "iframe[src*='youtube.com']", "iframe[src*='youtube-nocookie.com']", "iframe[src*='kickstarter.com'][src*='video.html']", "object", "embed"];
            c.customSelector && b.push(c.customSelector);
            var d = a(this).find(b.join(","));
            d = d.not("object object"), d.each(function () {
                var b = a(this);
                if (!("embed" === this.tagName.toLowerCase() && b.parent("object").length || b.parent(".fluid-width-video-wrapper").length)) {
                    var c = "object" === this.tagName.toLowerCase() || b.attr("height") && !isNaN(parseInt(b.attr("height"), 10)) ? parseInt(b.attr("height"), 10) : b.height(),
                        d = isNaN(parseInt(b.attr("width"), 10)) ? b.width() : parseInt(b.attr("width"), 10),
                        e = c / d;
                    if (!b.attr("id")) {
                        var f = "fitvid" + Math.floor(999999 * Math.random());
                        b.attr("id", f)
                    }
                    b.wrap('<div class="fluid-width-video-wrapper"></div>').parent(".fluid-width-video-wrapper").css("padding-top", 100 * e + "%"), b.removeAttr("height").removeAttr("width")
                }
            })
        })
    }
}(window.jQuery || window.Zepto),
function (a) {
    "function" == typeof define && define.amd ? define(["jquery"], a) : a("object" == typeof exports ? require("jquery") : jQuery)
}(function (a) {
    function b(a) {
        return h.raw ? a : encodeURIComponent(a)
    }

    function c(a) {
        return h.raw ? a : decodeURIComponent(a)
    }

    function d(a) {
        return b(h.json ? JSON.stringify(a) : String(a))
    }

    function e(a) {
        0 === a.indexOf('"') && (a = a.slice(1, -1).replace(/\\"/g, '"').replace(/\\\\/g, "\\"));
        try {
            return a = decodeURIComponent(a.replace(g, " ")), h.json ? JSON.parse(a) : a
        } catch (b) {}
    }

    function f(b, c) {
        var d = h.raw ? b : e(b);
        return a.isFunction(c) ? c(d) : d
    }
    var g = /\+/g,
        h = a.cookie = function (e, g, i) {
            if (arguments.length > 1 && !a.isFunction(g)) {
                if (i = a.extend({}, h.defaults, i), "number" == typeof i.expires) {
                    var j = i.expires,
                        k = i.expires = new Date;
                    k.setTime(+k + 864e5 * j)
                }
                return document.cookie = [b(e), "=", d(g), i.expires ? "; expires=" + i.expires.toUTCString() : "", i.path ? "; path=" + i.path : "", i.domain ? "; domain=" + i.domain : "", i.secure ? "; secure" : ""].join("")
            }
            for (var l = e ? void 0 : {}, m = document.cookie ? document.cookie.split("; ") : [], n = 0, o = m.length; n < o; n++) {
                var p = m[n].split("="),
                    q = c(p.shift()),
                    r = p.join("=");
                if (e && e === q) {
                    l = f(r, g);
                    break
                }
                e || void 0 === (r = f(r)) || (l[q] = r)
            }
            return l
        };
    h.defaults = {}, a.removeCookie = function (b, c) {
        return void 0 !== a.cookie(b) && (a.cookie(b, "", a.extend({}, c, {
            expires: -1
        })), !a.cookie(b))
    }
}),
function (a, b) {
    "use strict";
    var c = function () {
        var c = {
                bcClass: "sf-breadcrumb",
                menuClass: "sf-js-enabled",
                anchorClass: "sf-with-ul",
                menuArrowClass: "sf-arrows"
            },
            d = function () {
                var c = /iPhone|iPad|iPod/i.test(navigator.userAgent);
                return c && a(b).load(function () {
                    a("body").children().on("click", a.noop)
                }), c
            }(),
            e = function () {
                var a = document.documentElement.style;
                return "behavior" in a && "fill" in a && /iemobile/i.test(navigator.userAgent)
            }(),
            f = function () {
                return !!b.PointerEvent
            }(),
            g = function (a, b) {
                var d = c.menuClass;
                b.cssArrows && (d += " " + c.menuArrowClass), a.toggleClass(d)
            },
            h = function (b, d) {
                return b.find("li." + d.pathClass).slice(0, d.pathLevels).addClass(d.hoverClass + " " + c.bcClass).filter(function () {
                    return a(this).children(d.popUpSelector).hide().show().length
                }).removeClass(d.pathClass)
            },
            i = function (a) {
                a.children("a").toggleClass(c.anchorClass)
            },
            j = function (a) {
                var b = a.css("ms-touch-action"),
                    c = a.css("touch-action");
                c = c || b, c = "pan-y" === c ? "auto" : "pan-y", a.css({
                    "ms-touch-action": c,
                    "touch-action": c
                })
            },
            k = function (b, c) {
                var g = "li:has(" + c.popUpSelector + ")";
                a.fn.hoverIntent && !c.disableHI ? b.hoverIntent(m, n, g) : b.on("mouseenter.superfish", g, m).on("mouseleave.superfish", g, n);
                var h = "MSPointerDown.superfish";
                f && (h = "pointerdown.superfish"), d || (h += " touchend.superfish"), e && (h += " mousedown.superfish"), b.on("focusin.superfish", "li", m).on("focusout.superfish", "li", n).on(h, "a", c, l)
            },
            l = function (b) {
                var c = a(this),
                    d = c.siblings(b.data.popUpSelector);
                d.length > 0 && d.is(":hidden") && (c.one("click.superfish", !1), "MSPointerDown" === b.type || "pointerdown" === b.type ? c.trigger("focus") : a.proxy(m, c.parent("li"))())
            },
            m = function () {
                var b = a(this),
                    c = q(b);
                clearTimeout(c.sfTimer), b.siblings().superfish("hide").end().superfish("show")
            },
            n = function () {
                var b = a(this),
                    c = q(b);
                d ? a.proxy(o, b, c)() : (clearTimeout(c.sfTimer), c.sfTimer = setTimeout(a.proxy(o, b, c), c.delay))
            },
            o = function (b) {
                b.retainPath = a.inArray(this[0], b.$path) > -1, this.superfish("hide"), this.parents("." + b.hoverClass).length || (b.onIdle.call(p(this)), b.$path.length && a.proxy(m, b.$path)())
            },
            p = function (a) {
                return a.closest("." + c.menuClass)
            },
            q = function (a) {
                return p(a).data("sf-options")
            };
        return {
            hide: function (b) {
                if (this.length) {
                    var c = this,
                        d = q(c);
                    if (!d) return this;
                    var e = d.retainPath === !0 ? d.$path : "",
                        f = c.find("li." + d.hoverClass).add(this).not(e).removeClass(d.hoverClass).children(d.popUpSelector),
                        g = d.speedOut;
                    b && (f.show(), g = 0), d.retainPath = !1, d.onBeforeHide.call(f), f.stop(!0, !0).animate(d.animationOut, g, function () {
                        var b = a(this);
                        d.onHide.call(b)
                    })
                }
                return this
            },
            show: function () {
                var a = q(this);
                if (!a) return this;
                var b = this.addClass(a.hoverClass),
                    c = b.children(a.popUpSelector);
                return a.onBeforeShow.call(c), c.stop(!0, !0).animate(a.animation, a.speed, function () {
                    a.onShow.call(c)
                }), this
            },
            destroy: function () {
                return this.each(function () {
                    var b, d = a(this),
                        e = d.data("sf-options");
                    return !!e && (b = d.find(e.popUpSelector).parent("li"), clearTimeout(e.sfTimer), g(d, e), i(b), j(d), d.off(".superfish").off(".hoverIntent"), b.children(e.popUpSelector).attr("style", function (a, b) {
                        return b.replace(/display[^;]+;?/g, "")
                    }), e.$path.removeClass(e.hoverClass + " " + c.bcClass).addClass(e.pathClass), d.find("." + e.hoverClass).removeClass(e.hoverClass), e.onDestroy.call(d), void d.removeData("sf-options"))
                })
            },
            init: function (b) {
                return this.each(function () {
                    var d = a(this);
                    if (d.data("sf-options")) return !1;
                    var e = a.extend({}, a.fn.superfish.defaults, b),
                        f = d.find(e.popUpSelector).parent("li");
                    e.$path = h(d, e), d.data("sf-options", e), g(d, e), i(f), j(d), k(d, e), f.not("." + c.bcClass).superfish("hide", !0), e.onInit.call(this)
                })
            }
        }
    }();
    a.fn.superfish = function (b, d) {
        return c[b] ? c[b].apply(this, Array.prototype.slice.call(arguments, 1)) : "object" != typeof b && b ? a.error("Method " + b + " does not exist on jQuery.fn.superfish") : c.init.apply(this, arguments)
    }, a.fn.superfish.defaults = {
        popUpSelector: "ul,.sf-mega",
        hoverClass: "sfHover",
        pathClass: "overrideThisToUse",
        pathLevels: 1,
        delay: 800,
        animation: {
            opacity: "show"
        },
        animationOut: {
            opacity: "hide"
        },
        speed: "normal",
        speedOut: "fast",
        cssArrows: !0,
        disableHI: !1,
        onInit: a.noop,
        onBeforeShow: a.noop,
        onShow: a.noop,
        onBeforeHide: a.noop,
        onHide: a.noop,
        onIdle: a.noop,
        onDestroy: a.noop
    }
}(jQuery, window),
function (a) {
    a.fn.hoverIntent = function (b, c, d) {
        var e = {
            interval: 100,
            sensitivity: 7,
            timeout: 0
        };
        e = "object" == typeof b ? a.extend(e, b) : a.isFunction(c) ? a.extend(e, {
            over: b,
            out: c,
            selector: d
        }) : a.extend(e, {
            over: b,
            out: b,
            selector: c
        });
        var f, g, h, i, j = function (a) {
                f = a.pageX, g = a.pageY
            },
            k = function (b, c) {
                return c.hoverIntent_t = clearTimeout(c.hoverIntent_t), Math.abs(h - f) + Math.abs(i - g) < e.sensitivity ? (a(c).off("mousemove.hoverIntent", j), c.hoverIntent_s = 1, e.over.apply(c, [b])) : (h = f, i = g, c.hoverIntent_t = setTimeout(function () {
                    k(b, c)
                }, e.interval), void 0)
            },
            l = function (a, b) {
                return b.hoverIntent_t = clearTimeout(b.hoverIntent_t), b.hoverIntent_s = 0, e.out.apply(b, [a])
            },
            m = function (b) {
                var c = jQuery.extend({}, b),
                    d = this;
                d.hoverIntent_t && (d.hoverIntent_t = clearTimeout(d.hoverIntent_t)), "mouseenter" == b.type ? (h = c.pageX, i = c.pageY, a(d).on("mousemove.hoverIntent", j), 1 != d.hoverIntent_s && (d.hoverIntent_t = setTimeout(function () {
                    k(c, d)
                }, e.interval))) : (a(d).off("mousemove.hoverIntent", j), 1 == d.hoverIntent_s && (d.hoverIntent_t = setTimeout(function () {
                    l(c, d)
                }, e.timeout)))
            };
        return this.on({
            "mouseenter.hoverIntent": m,
            "mouseleave.hoverIntent": m
        }, e.selector)
    }
}(jQuery),
function () {
    function a() {}

    function b(a, b) {
        for (var c = a.length; c--;)
            if (a[c].listener === b) return c;
        return -1
    }

    function c(a) {
        return function () {
            return this[a].apply(this, arguments)
        }
    }
    var d = a.prototype,
        e = this,
        f = e.EventEmitter;
    d.getListeners = function (a) {
        var b, c, d = this._getEvents();
        if ("object" == typeof a) {
            b = {};
            for (c in d) d.hasOwnProperty(c) && a.test(c) && (b[c] = d[c])
        } else b = d[a] || (d[a] = []);
        return b
    }, d.flattenListeners = function (a) {
        var b, c = [];
        for (b = 0; b < a.length; b += 1) c.push(a[b].listener);
        return c
    }, d.getListenersAsObject = function (a) {
        var b, c = this.getListeners(a);
        return c instanceof Array && (b = {}, b[a] = c), b || c
    }, d.addListener = function (a, c) {
        var d, e = this.getListenersAsObject(a),
            f = "object" == typeof c;
        for (d in e) e.hasOwnProperty(d) && b(e[d], c) === -1 && e[d].push(f ? c : {
            listener: c,
            once: !1
        });
        return this
    }, d.on = c("addListener"), d.addOnceListener = function (a, b) {
        return this.addListener(a, {
            listener: b,
            once: !0
        })
    }, d.once = c("addOnceListener"), d.defineEvent = function (a) {
        return this.getListeners(a), this
    }, d.defineEvents = function (a) {
        for (var b = 0; b < a.length; b += 1) this.defineEvent(a[b]);
        return this
    }, d.removeListener = function (a, c) {
        var d, e, f = this.getListenersAsObject(a);
        for (e in f) f.hasOwnProperty(e) && (d = b(f[e], c), d !== -1 && f[e].splice(d, 1));
        return this
    }, d.off = c("removeListener"), d.addListeners = function (a, b) {
        return this.manipulateListeners(!1, a, b)
    }, d.removeListeners = function (a, b) {
        return this.manipulateListeners(!0, a, b)
    }, d.manipulateListeners = function (a, b, c) {
        var d, e, f = a ? this.removeListener : this.addListener,
            g = a ? this.removeListeners : this.addListeners;
        if ("object" != typeof b || b instanceof RegExp)
            for (d = c.length; d--;) f.call(this, b, c[d]);
        else
            for (d in b) b.hasOwnProperty(d) && (e = b[d]) && ("function" == typeof e ? f.call(this, d, e) : g.call(this, d, e));
        return this
    }, d.removeEvent = function (a) {
        var b, c = typeof a,
            d = this._getEvents();
        if ("string" === c) delete d[a];
        else if ("object" === c)
            for (b in d) d.hasOwnProperty(b) && a.test(b) && delete d[b];
        else delete this._events;
        return this
    }, d.removeAllListeners = c("removeEvent"), d.emitEvent = function (a, b) {
        var c, d, e, f, g = this.getListenersAsObject(a);
        for (e in g)
            if (g.hasOwnProperty(e))
                for (d = g[e].length; d--;) c = g[e][d], c.once === !0 && this.removeListener(a, c.listener), f = c.listener.apply(this, b || []), f === this._getOnceReturnValue() && this.removeListener(a, c.listener);
        return this
    }, d.trigger = c("emitEvent"), d.emit = function (a) {
        var b = Array.prototype.slice.call(arguments, 1);
        return this.emitEvent(a, b)
    }, d.setOnceReturnValue = function (a) {
        return this._onceReturnValue = a, this
    }, d._getOnceReturnValue = function () {
        return !this.hasOwnProperty("_onceReturnValue") || this._onceReturnValue
    }, d._getEvents = function () {
        return this._events || (this._events = {})
    }, a.noConflict = function () {
        return e.EventEmitter = f, a
    }, "function" == typeof define && define.amd ? define("eventEmitter/EventEmitter", [], function () {
        return a
    }) : "object" == typeof module && module.exports ? module.exports = a : this.EventEmitter = a
}.call(this),
    function (a) {
        function b(b) {
            var c = a.event;
            return c.target = c.target || c.srcElement || b, c
        }
        var c = document.documentElement,
            d = function () {};
        c.addEventListener ? d = function (a, b, c) {
            a.addEventListener(b, c, !1)
        } : c.attachEvent && (d = function (a, c, d) {
            a[c + d] = d.handleEvent ? function () {
                var c = b(a);
                d.handleEvent.call(d, c)
            } : function () {
                var c = b(a);
                d.call(a, c)
            }, a.attachEvent("on" + c, a[c + d])
        });
        var e = function () {};
        c.removeEventListener ? e = function (a, b, c) {
            a.removeEventListener(b, c, !1)
        } : c.detachEvent && (e = function (a, b, c) {
            a.detachEvent("on" + b, a[b + c]);
            try {
                delete a[b + c]
            } catch (d) {
                a[b + c] = void 0
            }
        });
        var f = {
            bind: d,
            unbind: e
        };
        "function" == typeof define && define.amd ? define("eventie/eventie", f) : a.eventie = f
    }(this),
    function (a, b) {
        "function" == typeof define && define.amd ? define(["eventEmitter/EventEmitter", "eventie/eventie"], function (c, d) {
            return b(a, c, d)
        }) : "object" == typeof exports ? module.exports = b(a, require("wolfy87-eventemitter"), require("eventie")) : a.imagesLoaded = b(a, a.EventEmitter, a.eventie)
    }(window, function (a, b, c) {
        function d(a, b) {
            for (var c in b) a[c] = b[c];
            return a
        }

        function e(a) {
            return "[object Array]" === m.call(a)
        }

        function f(a) {
            var b = [];
            if (e(a)) b = a;
            else if ("number" == typeof a.length)
                for (var c = 0, d = a.length; c < d; c++) b.push(a[c]);
            else b.push(a);
            return b
        }

        function g(a, b, c) {
            if (!(this instanceof g)) return new g(a, b);
            "string" == typeof a && (a = document.querySelectorAll(a)), this.elements = f(a), this.options = d({}, this.options), "function" == typeof b ? c = b : d(this.options, b), c && this.on("always", c), this.getImages(), j && (this.jqDeferred = new j.Deferred);
            var e = this;
            setTimeout(function () {
                e.check()
            })
        }

        function h(a) {
            this.img = a
        }

        function i(a) {
            this.src = a, n[a] = this
        }
        var j = a.jQuery,
            k = a.console,
            l = "undefined" != typeof k,
            m = Object.prototype.toString;
        g.prototype = new b, g.prototype.options = {}, g.prototype.getImages = function () {
            this.images = [];
            for (var a = 0, b = this.elements.length; a < b; a++) {
                var c = this.elements[a];
                "IMG" === c.nodeName && this.addImage(c);
                var d = c.nodeType;
                if (d && (1 === d || 9 === d || 11 === d))
                    for (var e = c.querySelectorAll("img"), f = 0, g = e.length; f < g; f++) {
                        var h = e[f];
                        this.addImage(h)
                    }
            }
        }, g.prototype.addImage = function (a) {
            var b = new h(a);
            this.images.push(b)
        }, g.prototype.check = function () {
            function a(a, e) {
                return b.options.debug && l && k.log("confirm", a, e), b.progress(a), c++, c === d && b.complete(), !0
            }
            var b = this,
                c = 0,
                d = this.images.length;
            if (this.hasAnyBroken = !1, !d) return void this.complete();
            for (var e = 0; e < d; e++) {
                var f = this.images[e];
                f.on("confirm", a), f.check()
            }
        }, g.prototype.progress = function (a) {
            this.hasAnyBroken = this.hasAnyBroken || !a.isLoaded;
            var b = this;
            setTimeout(function () {
                b.emit("progress", b, a), b.jqDeferred && b.jqDeferred.notify && b.jqDeferred.notify(b, a)
            })
        }, g.prototype.complete = function () {
            var a = this.hasAnyBroken ? "fail" : "done";
            this.isComplete = !0;
            var b = this;
            setTimeout(function () {
                if (b.emit(a, b), b.emit("always", b), b.jqDeferred) {
                    var c = b.hasAnyBroken ? "reject" : "resolve";
                    b.jqDeferred[c](b)
                }
            })
        }, j && (j.fn.imagesLoaded = function (a, b) {
            var c = new g(this, a, b);
            return c.jqDeferred.promise(j(this))
        }), h.prototype = new b, h.prototype.check = function () {
            var a = n[this.img.src] || new i(this.img.src);
            if (a.isConfirmed) return void this.confirm(a.isLoaded, "cached was confirmed");
            if (this.img.complete && void 0 !== this.img.naturalWidth) return void this.confirm(0 !== this.img.naturalWidth, "naturalWidth");
            var b = this;
            a.on("confirm", function (a, c) {
                return b.confirm(a.isLoaded, c), !0
            }), a.check()
        }, h.prototype.confirm = function (a, b) {
            this.isLoaded = a, this.emit("confirm", this, b)
        };
        var n = {};
        return i.prototype = new b, i.prototype.check = function () {
            if (!this.isChecked) {
                var a = new Image;
                c.bind(a, "load", this), c.bind(a, "error", this), a.src = this.src, this.isChecked = !0
            }
        }, i.prototype.handleEvent = function (a) {
            var b = "on" + a.type;
            this[b] && this[b](a)
        }, i.prototype.onload = function (a) {
            this.confirm(!0, "onload"), this.unbindProxyEvents(a)
        }, i.prototype.onerror = function (a) {
            this.confirm(!1, "onerror"), this.unbindProxyEvents(a)
        }, i.prototype.confirm = function (a, b) {
            this.isConfirmed = !0, this.isLoaded = a, this.emit("confirm", this, b)
        }, i.prototype.unbindProxyEvents = function (a) {
            c.unbind(a.target, "load", this), c.unbind(a.target, "error", this)
        }, g
    }),
    function (a, b, c) {
        "$:nomunge";

        function d() {
            e = b[h](function () {
                f.each(function () {
                    var b = a(this),
                        c = b.width(),
                        d = b.height(),
                        e = a.data(this, j);
                    c === e.w && d === e.h || b.trigger(i, [e.w = c, e.h = d])
                }), d()
            }, g[k])
        }
        var e, f = a([]),
            g = a.resize = a.extend(a.resize, {}),
            h = "setTimeout",
            i = "resize",
            j = i + "-special-event",
            k = "delay",
            l = "throttleWindow";
        g[k] = 250, g[l] = !0, a.event.special[i] = {
            setup: function () {
                if (!g[l] && this[h]) return !1;
                var b = a(this);
                f = f.add(b), a.data(this, j, {
                    w: b.width(),
                    h: b.height()
                }), 1 === f.length && d()
            },
            teardown: function () {
                if (!g[l] && this[h]) return !1;
                var b = a(this);
                f = f.not(b), b.removeData(j), f.length || clearTimeout(e)
            },
            add: function (b) {
                function d(b, d, f) {
                    var g = a(this),
                        h = a.data(this, j);
                    null == h && (h = {
                        w: null,
                        h: null
                    }), h.w = d !== c ? d : g.width(), h.h = f !== c ? f : g.height(), e.apply(this, arguments)
                }
                if (!g[l] && this[h]) return !1;
                var e;
                return a.isFunction(b) ? (e = b, d) : (e = b.handler, void(b.handler = d))
            }
        }
    }(jQuery, this),
    function () {
        "use strict";
        var a, b, c, d = function (a, b) {
            return function () {
                return a.apply(b, arguments)
            }
        };
        a = jQuery, b = function () {
            function a() {}
            return a.transitions = {
                webkitTransition: "webkitTransitionEnd",
                mozTransition: "mozTransitionEnd",
                oTransition: "oTransitionEnd",
                transition: "transitionend"
            }, a.transition = function (a) {
                var b, c, d, e;
                b = a[0], e = this.transitions;
                for (d in e)
                    if (c = e[d], null != b.style[d]) return c
            }, a
        }(), c = function () {
            function c(b) {
                null == b && (b = {}), this.html = d(this.html, this), this.$growl = d(this.$growl, this), this.$growls = d(this.$growls, this), this.animate = d(this.animate, this), this.remove = d(this.remove, this), this.dismiss = d(this.dismiss, this), this.present = d(this.present, this), this.cycle = d(this.cycle, this), this.close = d(this.close, this), this.unbind = d(this.unbind, this), this.bind = d(this.bind, this), this.render = d(this.render, this), this.settings = a.extend({}, c.settings, b), this.$growls().attr("class", this.settings.location), this.render()
            }
            return c.settings = {
                namespace: "growl",
                duration: 3200,
                close: "&#215;",
                location: "default",
                style: "default",
                size: "medium"
            }, c.growl = function (a) {
                return null == a && (a = {}), this.initialize(), new c(a)
            }, c.initialize = function () {
                return a(".bb-cover-photo:not(:has(#growls))").append('<div id="growls" />')
            }, c.prototype.render = function () {
                var a;
                a = this.$growl(), this.$growls().append(a), null != this.settings["static"] ? this.present() : this.cycle()
            }, c.prototype.bind = function (a) {
                return null == a && (a = this.$growl()), a.on("contextmenu", this.close).find("." + this.settings.namespace + "-close").on("click", this.close)
            }, c.prototype.unbind = function (a) {
                return null == a && (a = this.$growl()), a.off("contextmenu", this.close).find("." + this.settings.namespace + "-close").off("click", this.close)
            }, c.prototype.close = function (a) {
                var b;
                return a.preventDefault(), a.stopPropagation(), b = this.$growl(), b.stop().queue(this.dismiss).queue(this.remove)
            }, c.prototype.cycle = function () {
                var a;
                return a = this.$growl(), a.queue(this.present).delay(this.settings.duration).queue(this.dismiss).queue(this.remove)
            }, c.prototype.present = function (a) {
                var b;
                return b = this.$growl(), this.bind(b), this.animate(b, "" + this.settings.namespace + "-incoming", "out", a)
            }, c.prototype.dismiss = function (a) {
                var b;
                return b = this.$growl(), this.unbind(b), this.animate(b, "" + this.settings.namespace + "-outgoing", "in", a)
            }, c.prototype.remove = function (a) {
                return this.$growl().remove(), a()
            }, c.prototype.animate = function (a, c, d, e) {
                var f;
                null == d && (d = "in"), f = b.transition(a), a["in" === d ? "removeClass" : "addClass"](c), a.offset().position, a["in" === d ? "addClass" : "removeClass"](c), null != e && (null != f ? a.one(f, e) : e())
            }, c.prototype.$growls = function () {
                return null != this.$_growls ? this.$_growls : this.$_growls = a("#growls")
            }, c.prototype.$growl = function () {
                return null != this.$_growl ? this.$_growl : this.$_growl = a(this.html())
            }, c.prototype.html = function () {
                return "<div class='" + this.settings.namespace + " " + this.settings.namespace + "-" + this.settings.style + " " + this.settings.namespace + "-" + this.settings.size + "'>\n  <div class='" + this.settings.namespace + "-close'>" + this.settings.close + "</div>\n  <div class='" + this.settings.namespace + "-title'>" + this.settings.title + "</div>\n  <div class='" + this.settings.namespace + "-message'>" + this.settings.message + "</div>\n</div>"
            }, c
        }(), a.growl = function (a) {
            return null == a && (a = {}), c.growl(a)
        }, a.growl.error = function (b) {
            var c;
            return null == b && (b = {}), c = {
                title: "Error!",
                style: "error"
            }, a.growl(a.extend(c, b))
        }, a.growl.notice = function (b) {
            var c;
            return null == b && (b = {}), c = {
                title: "Notice!",
                style: "notice"
            }, a.growl(a.extend(c, b))
        }, a.growl.warning = function (b) {
            var c;
            return null == b && (b = {}), c = {
                title: "Warning!",
                style: "warning"
            }, a.growl(a.extend(c, b))
        }
    }.call(this), ! function (a) {
        "use strict";
        "function" == typeof define && define.amd ? define(["jquery"], a) : "undefined" != typeof exports ? module.exports = a(require("jquery")) : a(jQuery)
    }(function (a) {
        "use strict";
        var b = window.Slick || {};
        b = function () {
            function b(b, d) {
                var e, f = this;
                f.defaults = {
                    accessibility: !0,
                    adaptiveHeight: !1,
                    appendArrows: a(b),
                    appendDots: a(b),
                    arrows: !0,
                    asNavFor: null,
                    prevArrow: '<button type="button" data-role="none" class="slick-prev" aria-label="Previous" tabindex="0" role="button">Previous</button>',
                    nextArrow: '<button type="button" data-role="none" class="slick-next" aria-label="Next" tabindex="0" role="button">Next</button>',
                    autoplay: !1,
                    autoplaySpeed: 3e3,
                    centerMode: !1,
                    centerPadding: "50px",
                    cssEase: "ease",
                    customPaging: function (a, b) {
                        return '<button type="button" data-role="none" role="button" aria-required="false" tabindex="0">' + (b + 1) + "</button>"
                    },
                    dots: !1,
                    dotsClass: "slick-dots",
                    draggable: !0,
                    easing: "linear",
                    edgeFriction: .35,
                    fade: !1,
                    focusOnSelect: !1,
                    infinite: !0,
                    initialSlide: 0,
                    lazyLoad: "ondemand",
                    mobileFirst: !1,
                    pauseOnHover: !0,
                    pauseOnDotsHover: !1,
                    respondTo: "window",
                    responsive: null,
                    rows: 1,
                    rtl: !1,
                    slide: "",
                    slidesPerRow: 1,
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    speed: 500,
                    swipe: !0,
                    swipeToSlide: !1,
                    touchMove: !0,
                    touchThreshold: 5,
                    useCSS: !0,
                    variableWidth: !1,
                    vertical: !1,
                    verticalSwiping: !1,
                    waitForAnimate: !0,
                    zIndex: 1e3
                }, f.initials = {
                    animating: !1,
                    dragging: !1,
                    autoPlayTimer: null,
                    currentDirection: 0,
                    currentLeft: null,
                    currentSlide: 0,
                    direction: 1,
                    $dots: null,
                    listWidth: null,
                    listHeight: null,
                    loadIndex: 0,
                    $nextArrow: null,
                    $prevArrow: null,
                    slideCount: null,
                    slideWidth: null,
                    $slideTrack: null,
                    $slides: null,
                    sliding: !1,
                    slideOffset: 0,
                    swipeLeft: null,
                    $list: null,
                    touchObject: {},
                    transformsEnabled: !1,
                    unslicked: !1
                }, a.extend(f, f.initials), f.activeBreakpoint = null, f.animType = null, f.animProp = null, f.breakpoints = [], f.breakpointSettings = [], f.cssTransitions = !1, f.hidden = "hidden", f.paused = !1, f.positionProp = null, f.respondTo = null, f.rowCount = 1, f.shouldClick = !0, f.$slider = a(b), f.$slidesCache = null, f.transformType = null, f.transitionType = null, f.visibilityChange = "visibilitychange", f.windowWidth = 0, f.windowTimer = null, e = a(b).data("slick") || {}, f.options = a.extend({}, f.defaults, e, d), f.currentSlide = f.options.initialSlide, f.originalSettings = f.options, "undefined" != typeof document.mozHidden ? (f.hidden = "mozHidden", f.visibilityChange = "mozvisibilitychange") : "undefined" != typeof document.webkitHidden && (f.hidden = "webkitHidden", f.visibilityChange = "webkitvisibilitychange"), f.autoPlay = a.proxy(f.autoPlay, f), f.autoPlayClear = a.proxy(f.autoPlayClear, f), f.changeSlide = a.proxy(f.changeSlide, f), f.clickHandler = a.proxy(f.clickHandler, f), f.selectHandler = a.proxy(f.selectHandler, f), f.setPosition = a.proxy(f.setPosition, f), f.swipeHandler = a.proxy(f.swipeHandler, f), f.dragHandler = a.proxy(f.dragHandler, f), f.keyHandler = a.proxy(f.keyHandler, f), f.autoPlayIterator = a.proxy(f.autoPlayIterator, f), f.instanceUid = c++, f.htmlExpr = /^(?:\s*(<[\w\W]+>)[^>]*)$/, f.registerBreakpoints(), f.init(!0), f.checkResponsive(!0)
            }
            var c = 0;
            return b
        }(), b.prototype.addSlide = b.prototype.slickAdd = function (b, c, d) {
            var e = this;
            if ("boolean" == typeof c) d = c, c = null;
            else if (0 > c || c >= e.slideCount) return !1;
            e.unload(), "number" == typeof c ? 0 === c && 0 === e.$slides.length ? a(b).appendTo(e.$slideTrack) : d ? a(b).insertBefore(e.$slides.eq(c)) : a(b).insertAfter(e.$slides.eq(c)) : d === !0 ? a(b).prependTo(e.$slideTrack) : a(b).appendTo(e.$slideTrack), e.$slides = e.$slideTrack.children(this.options.slide), e.$slideTrack.children(this.options.slide).detach(), e.$slideTrack.append(e.$slides), e.$slides.each(function (b, c) {
                a(c).attr("data-slick-index", b)
            }), e.$slidesCache = e.$slides, e.reinit()
        }, b.prototype.animateHeight = function () {
            var a = this;
            if (1 === a.options.slidesToShow && a.options.adaptiveHeight === !0 && a.options.vertical === !1) {
                var b = a.$slides.eq(a.currentSlide).outerHeight(!0);
                a.$list.animate({
                    height: b
                }, a.options.speed)
            }
        }, b.prototype.animateSlide = function (b, c) {
            var d = {},
                e = this;
            e.animateHeight(), e.options.rtl === !0 && e.options.vertical === !1 && (b = -b), e.transformsEnabled === !1 ? e.options.vertical === !1 ? e.$slideTrack.animate({
                left: b
            }, e.options.speed, e.options.easing, c) : e.$slideTrack.animate({
                top: b
            }, e.options.speed, e.options.easing, c) : e.cssTransitions === !1 ? (e.options.rtl === !0 && (e.currentLeft = -e.currentLeft), a({
                animStart: e.currentLeft
            }).animate({
                animStart: b
            }, {
                duration: e.options.speed,
                easing: e.options.easing,
                step: function (a) {
                    a = Math.ceil(a), e.options.vertical === !1 ? (d[e.animType] = "translate(" + a + "px, 0px)", e.$slideTrack.css(d)) : (d[e.animType] = "translate(0px," + a + "px)", e.$slideTrack.css(d))
                },
                complete: function () {
                    c && c.call()
                }
            })) : (e.applyTransition(), b = Math.ceil(b), d[e.animType] = e.options.vertical === !1 ? "translate3d(" + b + "px, 0px, 0px)" : "translate3d(0px," + b + "px, 0px)", e.$slideTrack.css(d), c && setTimeout(function () {
                e.disableTransition(), c.call()
            }, e.options.speed))
        }, b.prototype.asNavFor = function (b) {
            var c = this,
                d = c.options.asNavFor;
            d && null !== d && (d = a(d).not(c.$slider)), null !== d && "object" == typeof d && d.each(function () {
                var c = a(this).slick("getSlick");
                c.unslicked || c.slideHandler(b, !0)
            })
        }, b.prototype.applyTransition = function (a) {
            var b = this,
                c = {};
            c[b.transitionType] = b.options.fade === !1 ? b.transformType + " " + b.options.speed + "ms " + b.options.cssEase : "opacity " + b.options.speed + "ms " + b.options.cssEase, b.options.fade === !1 ? b.$slideTrack.css(c) : b.$slides.eq(a).css(c)
        }, b.prototype.autoPlay = function () {
            var a = this;
            a.autoPlayTimer && clearInterval(a.autoPlayTimer), a.slideCount > a.options.slidesToShow && a.paused !== !0 && (a.autoPlayTimer = setInterval(a.autoPlayIterator, a.options.autoplaySpeed))
        }, b.prototype.autoPlayClear = function () {
            var a = this;
            a.autoPlayTimer && clearInterval(a.autoPlayTimer)
        }, b.prototype.autoPlayIterator = function () {
            var a = this;
            a.options.infinite === !1 ? 1 === a.direction ? (a.currentSlide + 1 === a.slideCount - 1 && (a.direction = 0), a.slideHandler(a.currentSlide + a.options.slidesToScroll)) : (0 === a.currentSlide - 1 && (a.direction = 1), a.slideHandler(a.currentSlide - a.options.slidesToScroll)) : a.slideHandler(a.currentSlide + a.options.slidesToScroll)
        }, b.prototype.buildArrows = function () {
            var b = this;
            b.options.arrows === !0 && (b.$prevArrow = a(b.options.prevArrow).addClass("slick-arrow"), b.$nextArrow = a(b.options.nextArrow).addClass("slick-arrow"), b.slideCount > b.options.slidesToShow ? (b.$prevArrow.removeClass("slick-hidden").removeAttr("aria-hidden tabindex"), b.$nextArrow.removeClass("slick-hidden").removeAttr("aria-hidden tabindex"), b.htmlExpr.test(b.options.prevArrow) && b.$prevArrow.prependTo(b.options.appendArrows), b.htmlExpr.test(b.options.nextArrow) && b.$nextArrow.appendTo(b.options.appendArrows), b.options.infinite !== !0 && b.$prevArrow.addClass("slick-disabled").attr("aria-disabled", "true")) : b.$prevArrow.add(b.$nextArrow).addClass("slick-hidden").attr({
                "aria-disabled": "true",
                tabindex: "-1"
            }))
        }, b.prototype.buildDots = function () {
            var b, c, d = this;
            if (d.options.dots === !0 && d.slideCount > d.options.slidesToShow) {
                for (c = '<ul class="' + d.options.dotsClass + '">', b = 0; b <= d.getDotCount(); b += 1) c += "<li>" + d.options.customPaging.call(this, d, b) + "</li>";
                c += "</ul>", d.$dots = a(c).appendTo(d.options.appendDots), d.$dots.find("li").first().addClass("slick-active").attr("aria-hidden", "false")
            }
        }, b.prototype.buildOut = function () {
            var b = this;
            b.$slides = b.$slider.children(b.options.slide + ":not(.slick-cloned)").addClass("slick-slide"), b.slideCount = b.$slides.length, b.$slides.each(function (b, c) {
                a(c).attr("data-slick-index", b).data("originalStyling", a(c).attr("style") || "")
            }), b.$slidesCache = b.$slides, b.$slider.addClass("slick-slider"), b.$slideTrack = 0 === b.slideCount ? a('<div class="slick-track"/>').appendTo(b.$slider) : b.$slides.wrapAll('<div class="slick-track"/>').parent(), b.$list = b.$slideTrack.wrap('<div aria-live="polite" class="slick-list"/>').parent(), b.$slideTrack.css("opacity", 0), (b.options.centerMode === !0 || b.options.swipeToSlide === !0) && (b.options.slidesToScroll = 1), a("img[data-lazy]", b.$slider).not("[src]").addClass("slick-loading"), b.setupInfinite(), b.buildArrows(), b.buildDots(), b.updateDots(), b.setSlideClasses("number" == typeof b.currentSlide ? b.currentSlide : 0), b.options.draggable === !0 && b.$list.addClass("draggable")
        }, b.prototype.buildRows = function () {
            var a, b, c, d, e, f, g, h = this;
            if (d = document.createDocumentFragment(), f = h.$slider.children(), h.options.rows > 1) {
                for (g = h.options.slidesPerRow * h.options.rows, e = Math.ceil(f.length / g), a = 0; e > a; a++) {
                    var i = document.createElement("div");
                    for (b = 0; b < h.options.rows; b++) {
                        var j = document.createElement("div");
                        for (c = 0; c < h.options.slidesPerRow; c++) {
                            var k = a * g + (b * h.options.slidesPerRow + c);
                            f.get(k) && j.appendChild(f.get(k))
                        }
                        i.appendChild(j)
                    }
                    d.appendChild(i)
                }
                h.$slider.html(d), h.$slider.children().children().children().css({
                    width: 100 / h.options.slidesPerRow + "%",
                    display: "inline-block"
                })
            }
        }, b.prototype.checkResponsive = function (b, c) {
            var d, e, f, g = this,
                h = !1,
                i = g.$slider.width(),
                j = window.innerWidth || a(window).width();
            if ("window" === g.respondTo ? f = j : "slider" === g.respondTo ? f = i : "min" === g.respondTo && (f = Math.min(j, i)), g.options.responsive && g.options.responsive.length && null !== g.options.responsive) {
                e = null;
                for (d in g.breakpoints) g.breakpoints.hasOwnProperty(d) && (g.originalSettings.mobileFirst === !1 ? f < g.breakpoints[d] && (e = g.breakpoints[d]) : f > g.breakpoints[d] && (e = g.breakpoints[d]));
                null !== e ? null !== g.activeBreakpoint ? (e !== g.activeBreakpoint || c) && (g.activeBreakpoint = e, "unslick" === g.breakpointSettings[e] ? g.unslick(e) : (g.options = a.extend({}, g.originalSettings, g.breakpointSettings[e]), b === !0 && (g.currentSlide = g.options.initialSlide), g.refresh(b)), h = e) : (g.activeBreakpoint = e, "unslick" === g.breakpointSettings[e] ? g.unslick(e) : (g.options = a.extend({}, g.originalSettings, g.breakpointSettings[e]), b === !0 && (g.currentSlide = g.options.initialSlide), g.refresh(b)), h = e) : null !== g.activeBreakpoint && (g.activeBreakpoint = null, g.options = g.originalSettings, b === !0 && (g.currentSlide = g.options.initialSlide), g.refresh(b), h = e), b || h === !1 || g.$slider.trigger("breakpoint", [g, h])
            }
        }, b.prototype.changeSlide = function (b, c) {
            var d, e, f, g = this,
                h = a(b.target);
            switch (h.is("a") && b.preventDefault(), h.is("li") || (h = h.closest("li")), f = 0 !== g.slideCount % g.options.slidesToScroll, d = f ? 0 : (g.slideCount - g.currentSlide) % g.options.slidesToScroll, b.data.message) {
                case "previous":
                    e = 0 === d ? g.options.slidesToScroll : g.options.slidesToShow - d, g.slideCount > g.options.slidesToShow && g.slideHandler(g.currentSlide - e, !1, c);
                    break;
                case "next":
                    e = 0 === d ? g.options.slidesToScroll : d, g.slideCount > g.options.slidesToShow && g.slideHandler(g.currentSlide + e, !1, c);
                    break;
                case "index":
                    var i = 0 === b.data.index ? 0 : b.data.index || h.index() * g.options.slidesToScroll;
                    g.slideHandler(g.checkNavigable(i), !1, c), h.children().trigger("focus");
                    break;
                default:
                    return
            }
        }, b.prototype.checkNavigable = function (a) {
            var b, c, d = this;
            if (b = d.getNavigableIndexes(), c = 0, a > b[b.length - 1]) a = b[b.length - 1];
            else
                for (var e in b) {
                    if (a < b[e]) {
                        a = c;
                        break
                    }
                    c = b[e]
                }
            return a
        }, b.prototype.cleanUpEvents = function () {
            var b = this;
            b.options.dots && null !== b.$dots && (a("li", b.$dots).off("click.slick", b.changeSlide), b.options.pauseOnDotsHover === !0 && b.options.autoplay === !0 && a("li", b.$dots).off("mouseenter.slick", a.proxy(b.setPaused, b, !0)).off("mouseleave.slick", a.proxy(b.setPaused, b, !1))), b.options.arrows === !0 && b.slideCount > b.options.slidesToShow && (b.$prevArrow && b.$prevArrow.off("click.slick", b.changeSlide), b.$nextArrow && b.$nextArrow.off("click.slick", b.changeSlide)), b.$list.off("touchstart.slick mousedown.slick", b.swipeHandler), b.$list.off("touchmove.slick mousemove.slick", b.swipeHandler), b.$list.off("touchend.slick mouseup.slick", b.swipeHandler), b.$list.off("touchcancel.slick mouseleave.slick", b.swipeHandler), b.$list.off("click.slick", b.clickHandler), a(document).off(b.visibilityChange, b.visibility), b.$list.off("mouseenter.slick", a.proxy(b.setPaused, b, !0)), b.$list.off("mouseleave.slick", a.proxy(b.setPaused, b, !1)), b.options.accessibility === !0 && b.$list.off("keydown.slick", b.keyHandler), b.options.focusOnSelect === !0 && a(b.$slideTrack).children().off("click.slick", b.selectHandler), a(window).off("orientationchange.slick.slick-" + b.instanceUid, b.orientationChange), a(window).off("resize.slick.slick-" + b.instanceUid, b.resize), a("[draggable!=true]", b.$slideTrack).off("dragstart", b.preventDefault), a(window).off("load.slick.slick-" + b.instanceUid, b.setPosition), a(document).off("ready.slick.slick-" + b.instanceUid, b.setPosition)
        }, b.prototype.cleanUpRows = function () {
            var a, b = this;
            b.options.rows > 1 && (a = b.$slides.children().children(), a.removeAttr("style"), b.$slider.html(a))
        }, b.prototype.clickHandler = function (a) {
            var b = this;
            b.shouldClick === !1 && (a.stopImmediatePropagation(), a.stopPropagation(), a.preventDefault())
        }, b.prototype.destroy = function (b) {
            var c = this;
            c.autoPlayClear(), c.touchObject = {}, c.cleanUpEvents(), a(".slick-cloned", c.$slider).detach(), c.$dots && c.$dots.remove(), c.options.arrows === !0 && (c.$prevArrow && c.$prevArrow.length && (c.$prevArrow.removeClass("slick-disabled slick-arrow slick-hidden").removeAttr("aria-hidden aria-disabled tabindex").css("display", ""), c.htmlExpr.test(c.options.prevArrow) && c.$prevArrow.remove()), c.$nextArrow && c.$nextArrow.length && (c.$nextArrow.removeClass("slick-disabled slick-arrow slick-hidden").removeAttr("aria-hidden aria-disabled tabindex").css("display", ""), c.htmlExpr.test(c.options.nextArrow) && c.$nextArrow.remove())), c.$slides && (c.$slides.removeClass("slick-slide slick-active slick-center slick-visible slick-current").removeAttr("aria-hidden").removeAttr("data-slick-index").each(function () {
                a(this).attr("style", a(this).data("originalStyling"))
            }), c.$slideTrack.children(this.options.slide).detach(), c.$slideTrack.detach(), c.$list.detach(), c.$slider.append(c.$slides)), c.cleanUpRows(), c.$slider.removeClass("slick-slider"), c.$slider.removeClass("slick-initialized"), c.unslicked = !0, b || c.$slider.trigger("destroy", [c])
        }, b.prototype.disableTransition = function (a) {
            var b = this,
                c = {};
            c[b.transitionType] = "", b.options.fade === !1 ? b.$slideTrack.css(c) : b.$slides.eq(a).css(c)
        }, b.prototype.fadeSlide = function (a, b) {
            var c = this;
            c.cssTransitions === !1 ? (c.$slides.eq(a).css({
                zIndex: c.options.zIndex
            }), c.$slides.eq(a).animate({
                opacity: 1
            }, c.options.speed, c.options.easing, b)) : (c.applyTransition(a), c.$slides.eq(a).css({
                opacity: 1,
                zIndex: c.options.zIndex
            }), b && setTimeout(function () {
                c.disableTransition(a), b.call()
            }, c.options.speed))
        }, b.prototype.fadeSlideOut = function (a) {
            var b = this;
            b.cssTransitions === !1 ? b.$slides.eq(a).animate({
                opacity: 0,
                zIndex: b.options.zIndex - 2
            }, b.options.speed, b.options.easing) : (b.applyTransition(a), b.$slides.eq(a).css({
                opacity: 0,
                zIndex: b.options.zIndex - 2
            }))
        }, b.prototype.filterSlides = b.prototype.slickFilter = function (a) {
            var b = this;
            null !== a && (b.unload(), b.$slideTrack.children(this.options.slide).detach(), b.$slidesCache.filter(a).appendTo(b.$slideTrack), b.reinit())
        }, b.prototype.getCurrent = b.prototype.slickCurrentSlide = function () {
            var a = this;
            return a.currentSlide
        }, b.prototype.getDotCount = function () {
            var a = this,
                b = 0,
                c = 0,
                d = 0;
            if (a.options.infinite === !0)
                for (; b < a.slideCount;) ++d, b = c + a.options.slidesToShow, c += a.options.slidesToScroll <= a.options.slidesToShow ? a.options.slidesToScroll : a.options.slidesToShow;
            else if (a.options.centerMode === !0) d = a.slideCount;
            else
                for (; b < a.slideCount;) ++d, b = c + a.options.slidesToShow, c += a.options.slidesToScroll <= a.options.slidesToShow ? a.options.slidesToScroll : a.options.slidesToShow;
            return d - 1
        }, b.prototype.getLeft = function (a) {
            var b, c, d, e = this,
                f = 0;
            return e.slideOffset = 0, c = e.$slides.first().outerHeight(!0), e.options.infinite === !0 ? (e.slideCount > e.options.slidesToShow && (e.slideOffset = -1 * e.slideWidth * e.options.slidesToShow, f = -1 * c * e.options.slidesToShow), 0 !== e.slideCount % e.options.slidesToScroll && a + e.options.slidesToScroll > e.slideCount && e.slideCount > e.options.slidesToShow && (a > e.slideCount ? (e.slideOffset = -1 * (e.options.slidesToShow - (a - e.slideCount)) * e.slideWidth, f = -1 * (e.options.slidesToShow - (a - e.slideCount)) * c) : (e.slideOffset = -1 * e.slideCount % e.options.slidesToScroll * e.slideWidth, f = -1 * e.slideCount % e.options.slidesToScroll * c))) : a + e.options.slidesToShow > e.slideCount && (e.slideOffset = (a + e.options.slidesToShow - e.slideCount) * e.slideWidth, f = (a + e.options.slidesToShow - e.slideCount) * c), e.slideCount <= e.options.slidesToShow && (e.slideOffset = 0, f = 0), e.options.centerMode === !0 && e.options.infinite === !0 ? e.slideOffset += e.slideWidth * Math.floor(e.options.slidesToShow / 2) - e.slideWidth : e.options.centerMode === !0 && (e.slideOffset = 0, e.slideOffset += e.slideWidth * Math.floor(e.options.slidesToShow / 2)), b = e.options.vertical === !1 ? -1 * a * e.slideWidth + e.slideOffset : -1 * a * c + f, e.options.variableWidth === !0 && (d = e.slideCount <= e.options.slidesToShow || e.options.infinite === !1 ? e.$slideTrack.children(".slick-slide").eq(a) : e.$slideTrack.children(".slick-slide").eq(a + e.options.slidesToShow), b = d[0] ? -1 * d[0].offsetLeft : 0, e.options.centerMode === !0 && (d = e.options.infinite === !1 ? e.$slideTrack.children(".slick-slide").eq(a) : e.$slideTrack.children(".slick-slide").eq(a + e.options.slidesToShow + 1), b = d[0] ? -1 * d[0].offsetLeft : 0, b += (e.$list.width() - d.outerWidth()) / 2)), b
        }, b.prototype.getOption = b.prototype.slickGetOption = function (a) {
            var b = this;
            return b.options[a]
        }, b.prototype.getNavigableIndexes = function () {
            var a, b = this,
                c = 0,
                d = 0,
                e = [];
            for (b.options.infinite === !1 ? a = b.slideCount : (c = -1 * b.options.slidesToScroll, d = -1 * b.options.slidesToScroll, a = 2 * b.slideCount); a > c;) e.push(c), c = d + b.options.slidesToScroll, d += b.options.slidesToScroll <= b.options.slidesToShow ? b.options.slidesToScroll : b.options.slidesToShow;
            return e
        }, b.prototype.getSlick = function () {
            return this
        }, b.prototype.getSlideCount = function () {
            var b, c, d, e = this;
            return d = e.options.centerMode === !0 ? e.slideWidth * Math.floor(e.options.slidesToShow / 2) : 0, e.options.swipeToSlide === !0 ? (e.$slideTrack.find(".slick-slide").each(function (b, f) {
                return f.offsetLeft - d + a(f).outerWidth() / 2 > -1 * e.swipeLeft ? (c = f, !1) : void 0
            }), b = Math.abs(a(c).attr("data-slick-index") - e.currentSlide) || 1) : e.options.slidesToScroll
        }, b.prototype.goTo = b.prototype.slickGoTo = function (a, b) {
            var c = this;
            c.changeSlide({
                data: {
                    message: "index",
                    index: parseInt(a)
                }
            }, b)
        }, b.prototype.init = function (b) {
            var c = this;
            a(c.$slider).hasClass("slick-initialized") || (a(c.$slider).addClass("slick-initialized"), c.buildRows(), c.buildOut(), c.setProps(), c.startLoad(), c.loadSlider(), c.initializeEvents(), c.updateArrows(), c.updateDots()), b && c.$slider.trigger("init", [c]), c.options.accessibility === !0 && c.initADA()
        }, b.prototype.initArrowEvents = function () {
            var a = this;
            a.options.arrows === !0 && a.slideCount > a.options.slidesToShow && (a.$prevArrow.on("click.slick", {
                message: "previous"
            }, a.changeSlide), a.$nextArrow.on("click.slick", {
                message: "next"
            }, a.changeSlide))
        }, b.prototype.initDotEvents = function () {
            var b = this;
            b.options.dots === !0 && b.slideCount > b.options.slidesToShow && a("li", b.$dots).on("click.slick", {
                message: "index"
            }, b.changeSlide), b.options.dots === !0 && b.options.pauseOnDotsHover === !0 && b.options.autoplay === !0 && a("li", b.$dots).on("mouseenter.slick", a.proxy(b.setPaused, b, !0)).on("mouseleave.slick", a.proxy(b.setPaused, b, !1))
        }, b.prototype.initializeEvents = function () {
            var b = this;
            b.initArrowEvents(), b.initDotEvents(), b.$list.on("touchstart.slick mousedown.slick", {
                action: "start"
            }, b.swipeHandler), b.$list.on("touchmove.slick mousemove.slick", {
                action: "move"
            }, b.swipeHandler), b.$list.on("touchend.slick mouseup.slick", {
                action: "end"
            }, b.swipeHandler), b.$list.on("touchcancel.slick mouseleave.slick", {
                action: "end"
            }, b.swipeHandler), b.$list.on("click.slick", b.clickHandler), a(document).on(b.visibilityChange, a.proxy(b.visibility, b)), b.$list.on("mouseenter.slick", a.proxy(b.setPaused, b, !0)), b.$list.on("mouseleave.slick", a.proxy(b.setPaused, b, !1)), b.options.accessibility === !0 && b.$list.on("keydown.slick", b.keyHandler), b.options.focusOnSelect === !0 && a(b.$slideTrack).children().on("click.slick", b.selectHandler), a(window).on("orientationchange.slick.slick-" + b.instanceUid, a.proxy(b.orientationChange, b)), a(window).on("resize.slick.slick-" + b.instanceUid, a.proxy(b.resize, b)), a("[draggable!=true]", b.$slideTrack).on("dragstart", b.preventDefault), a(window).on("load.slick.slick-" + b.instanceUid, b.setPosition), a(document).on("ready.slick.slick-" + b.instanceUid, b.setPosition)
        }, b.prototype.initUI = function () {
            var a = this;
            a.options.arrows === !0 && a.slideCount > a.options.slidesToShow && (a.$prevArrow.show(), a.$nextArrow.show()), a.options.dots === !0 && a.slideCount > a.options.slidesToShow && a.$dots.show(), a.options.autoplay === !0 && a.autoPlay()
        }, b.prototype.keyHandler = function (a) {
            var b = this;
            a.target.tagName.match("TEXTAREA|INPUT|SELECT") || (37 === a.keyCode && b.options.accessibility === !0 ? b.changeSlide({
                data: {
                    message: "previous"
                }
            }) : 39 === a.keyCode && b.options.accessibility === !0 && b.changeSlide({
                data: {
                    message: "next"
                }
            }))
        }, b.prototype.lazyLoad = function () {
            function b(b) {
                a("img[data-lazy]", b).each(function () {
                    var b = a(this),
                        c = a(this).attr("data-lazy"),
                        d = document.createElement("img");
                    d.onload = function () {
                        b.animate({
                            opacity: 0
                        }, 100, function () {
                            b.attr("src", c).animate({
                                opacity: 1
                            }, 200, function () {
                                b.removeAttr("data-lazy").removeClass("slick-loading")
                            })
                        })
                    }, d.src = c
                })
            }
            var c, d, e, f, g = this;
            g.options.centerMode === !0 ? g.options.infinite === !0 ? (e = g.currentSlide + (g.options.slidesToShow / 2 + 1), f = e + g.options.slidesToShow + 2) : (e = Math.max(0, g.currentSlide - (g.options.slidesToShow / 2 + 1)), f = 2 + (g.options.slidesToShow / 2 + 1) + g.currentSlide) : (e = g.options.infinite ? g.options.slidesToShow + g.currentSlide : g.currentSlide, f = e + g.options.slidesToShow, g.options.fade === !0 && (e > 0 && e--, f <= g.slideCount && f++)), c = g.$slider.find(".slick-slide").slice(e, f), b(c), g.slideCount <= g.options.slidesToShow ? (d = g.$slider.find(".slick-slide"), b(d)) : g.currentSlide >= g.slideCount - g.options.slidesToShow ? (d = g.$slider.find(".slick-cloned").slice(0, g.options.slidesToShow), b(d)) : 0 === g.currentSlide && (d = g.$slider.find(".slick-cloned").slice(-1 * g.options.slidesToShow), b(d))
        }, b.prototype.loadSlider = function () {
            var a = this;
            a.setPosition(), a.$slideTrack.css({
                opacity: 1
            }), a.$slider.removeClass("slick-loading"), a.initUI(), "progressive" === a.options.lazyLoad && a.progressiveLazyLoad()
        }, b.prototype.next = b.prototype.slickNext = function () {
            var a = this;
            a.changeSlide({
                data: {
                    message: "next"
                }
            })
        }, b.prototype.orientationChange = function () {
            var a = this;
            a.checkResponsive(), a.setPosition()
        }, b.prototype.pause = b.prototype.slickPause = function () {
            var a = this;
            a.autoPlayClear(), a.paused = !0
        }, b.prototype.play = b.prototype.slickPlay = function () {
            var a = this;
            a.paused = !1, a.autoPlay()
        }, b.prototype.postSlide = function (a) {
            var b = this;
            b.$slider.trigger("afterChange", [b, a]), b.animating = !1, b.setPosition(), b.swipeLeft = null, b.options.autoplay === !0 && b.paused === !1 && b.autoPlay(), b.options.accessibility === !0 && b.initADA()
        }, b.prototype.prev = b.prototype.slickPrev = function () {
            var a = this;
            a.changeSlide({
                data: {
                    message: "previous"
                }
            })
        }, b.prototype.preventDefault = function (a) {
            a.preventDefault()
        }, b.prototype.progressiveLazyLoad = function () {
            var b, c, d = this;
            b = a("img[data-lazy]", d.$slider).length, b > 0 && (c = a("img[data-lazy]", d.$slider).first(), c.attr("src", c.attr("data-lazy")).removeClass("slick-loading").load(function () {
                c.removeAttr("data-lazy"), d.progressiveLazyLoad(), d.options.adaptiveHeight === !0 && d.setPosition()
            }).error(function () {
                c.removeAttr("data-lazy"), d.progressiveLazyLoad()
            }))
        }, b.prototype.refresh = function (b) {
            var c = this,
                d = c.currentSlide;
            c.destroy(!0), a.extend(c, c.initials, {
                currentSlide: d
            }), c.init(), b || c.changeSlide({
                data: {
                    message: "index",
                    index: d
                }
            }, !1)
        }, b.prototype.registerBreakpoints = function () {
            var b, c, d, e = this,
                f = e.options.responsive || null;
            if ("array" === a.type(f) && f.length) {
                e.respondTo = e.options.respondTo || "window";
                for (b in f)
                    if (d = e.breakpoints.length - 1, c = f[b].breakpoint, f.hasOwnProperty(b)) {
                        for (; d >= 0;) e.breakpoints[d] && e.breakpoints[d] === c && e.breakpoints.splice(d, 1), d--;
                        e.breakpoints.push(c), e.breakpointSettings[c] = f[b].settings
                    } e.breakpoints.sort(function (a, b) {
                    return e.options.mobileFirst ? a - b : b - a
                })
            }
        }, b.prototype.reinit = function () {
            var b = this;
            b.$slides = b.$slideTrack.children(b.options.slide).addClass("slick-slide"), b.slideCount = b.$slides.length, b.currentSlide >= b.slideCount && 0 !== b.currentSlide && (b.currentSlide = b.currentSlide - b.options.slidesToScroll), b.slideCount <= b.options.slidesToShow && (b.currentSlide = 0), b.registerBreakpoints(), b.setProps(), b.setupInfinite(), b.buildArrows(), b.updateArrows(), b.initArrowEvents(), b.buildDots(), b.updateDots(), b.initDotEvents(), b.checkResponsive(!1, !0), b.options.focusOnSelect === !0 && a(b.$slideTrack).children().on("click.slick", b.selectHandler), b.setSlideClasses(0), b.setPosition(), b.$slider.trigger("reInit", [b]), b.options.autoplay === !0 && b.focusHandler()
        }, b.prototype.resize = function () {
            var b = this;
            a(window).width() !== b.windowWidth && (clearTimeout(b.windowDelay), b.windowDelay = window.setTimeout(function () {
                b.windowWidth = a(window).width(), b.checkResponsive(), b.unslicked || b.setPosition()
            }, 50))
        }, b.prototype.removeSlide = b.prototype.slickRemove = function (a, b, c) {
            var d = this;
            return "boolean" == typeof a ? (b = a, a = b === !0 ? 0 : d.slideCount - 1) : a = b === !0 ? --a : a, !(d.slideCount < 1 || 0 > a || a > d.slideCount - 1) && (d.unload(), c === !0 ? d.$slideTrack.children().remove() : d.$slideTrack.children(this.options.slide).eq(a).remove(), d.$slides = d.$slideTrack.children(this.options.slide), d.$slideTrack.children(this.options.slide).detach(), d.$slideTrack.append(d.$slides), d.$slidesCache = d.$slides, void d.reinit())
        }, b.prototype.setCSS = function (a) {
            var b, c, d = this,
                e = {};
            d.options.rtl === !0 && (a = -a), b = "left" == d.positionProp ? Math.ceil(a) + "px" : "0px", c = "top" == d.positionProp ? Math.ceil(a) + "px" : "0px", e[d.positionProp] = a, d.transformsEnabled === !1 ? d.$slideTrack.css(e) : (e = {}, d.cssTransitions === !1 ? (e[d.animType] = "translate(" + b + ", " + c + ")", d.$slideTrack.css(e)) : (e[d.animType] = "translate3d(" + b + ", " + c + ", 0px)", d.$slideTrack.css(e)))
        }, b.prototype.setDimensions = function () {
            var a = this;
            a.options.vertical === !1 ? a.options.centerMode === !0 && a.$list.css({
                padding: "0px " + a.options.centerPadding
            }) : (a.$list.height(a.$slides.first().outerHeight(!0) * a.options.slidesToShow), a.options.centerMode === !0 && a.$list.css({
                padding: a.options.centerPadding + " 0px"
            })), a.listWidth = a.$list.width(), a.listHeight = a.$list.height(), a.options.vertical === !1 && a.options.variableWidth === !1 ? (a.slideWidth = Math.ceil(a.listWidth / a.options.slidesToShow), a.$slideTrack.width(Math.ceil(a.slideWidth * a.$slideTrack.children(".slick-slide").length))) : a.options.variableWidth === !0 ? a.$slideTrack.width(5e3 * a.slideCount) : (a.slideWidth = Math.ceil(a.listWidth), a.$slideTrack.height(Math.ceil(a.$slides.first().outerHeight(!0) * a.$slideTrack.children(".slick-slide").length)));
            var b = a.$slides.first().outerWidth(!0) - a.$slides.first().width();
            a.options.variableWidth === !1 && a.$slideTrack.children(".slick-slide").width(a.slideWidth - b)
        }, b.prototype.setFade = function () {
            var b, c = this;
            c.$slides.each(function (d, e) {
                b = -1 * c.slideWidth * d, c.options.rtl === !0 ? a(e).css({
                    position: "relative",
                    right: b,
                    top: 0,
                    zIndex: c.options.zIndex - 2,
                    opacity: 0
                }) : a(e).css({
                    position: "relative",
                    left: b,
                    top: 0,
                    zIndex: c.options.zIndex - 2,
                    opacity: 0
                })
            }), c.$slides.eq(c.currentSlide).css({
                zIndex: c.options.zIndex - 1,
                opacity: 1
            })
        }, b.prototype.setHeight = function () {
            var a = this;
            if (1 === a.options.slidesToShow && a.options.adaptiveHeight === !0 && a.options.vertical === !1) {
                var b = a.$slides.eq(a.currentSlide).outerHeight(!0);
                a.$list.css("height", b)
            }
        }, b.prototype.setOption = b.prototype.slickSetOption = function (b, c, d) {
            var e, f, g = this;
            if ("responsive" === b && "array" === a.type(c))
                for (f in c)
                    if ("array" !== a.type(g.options.responsive)) g.options.responsive = [c[f]];
                    else {
                        for (e = g.options.responsive.length - 1; e >= 0;) g.options.responsive[e].breakpoint === c[f].breakpoint && g.options.responsive.splice(e, 1), e--;
                        g.options.responsive.push(c[f])
                    }
            else g.options[b] = c;
            d === !0 && (g.unload(), g.reinit())
        }, b.prototype.setPosition = function () {
            var a = this;
            a.setDimensions(), a.setHeight(), a.options.fade === !1 ? a.setCSS(a.getLeft(a.currentSlide)) : a.setFade(), a.$slider.trigger("setPosition", [a])
        }, b.prototype.setProps = function () {
            var a = this,
                b = document.body.style;
            a.positionProp = a.options.vertical === !0 ? "top" : "left", "top" === a.positionProp ? a.$slider.addClass("slick-vertical") : a.$slider.removeClass("slick-vertical"), (void 0 !== b.WebkitTransition || void 0 !== b.MozTransition || void 0 !== b.msTransition) && a.options.useCSS === !0 && (a.cssTransitions = !0), a.options.fade && ("number" == typeof a.options.zIndex ? a.options.zIndex < 3 && (a.options.zIndex = 3) : a.options.zIndex = a.defaults.zIndex), void 0 !== b.OTransform && (a.animType = "OTransform", a.transformType = "-o-transform", a.transitionType = "OTransition", void 0 === b.perspectiveProperty && void 0 === b.webkitPerspective && (a.animType = !1)), void 0 !== b.MozTransform && (a.animType = "MozTransform", a.transformType = "-moz-transform", a.transitionType = "MozTransition", void 0 === b.perspectiveProperty && void 0 === b.MozPerspective && (a.animType = !1)), void 0 !== b.webkitTransform && (a.animType = "webkitTransform", a.transformType = "-webkit-transform", a.transitionType = "webkitTransition", void 0 === b.perspectiveProperty && void 0 === b.webkitPerspective && (a.animType = !1)), void 0 !== b.msTransform && (a.animType = "msTransform", a.transformType = "-ms-transform", a.transitionType = "msTransition", void 0 === b.msTransform && (a.animType = !1)), void 0 !== b.transform && a.animType !== !1 && (a.animType = "transform", a.transformType = "transform", a.transitionType = "transition"), a.transformsEnabled = null !== a.animType && a.animType !== !1
        }, b.prototype.setSlideClasses = function (a) {
            var b, c, d, e, f = this;
            c = f.$slider.find(".slick-slide").removeClass("slick-active slick-center slick-current").attr("aria-hidden", "true"), f.$slides.eq(a).addClass("slick-current"), f.options.centerMode === !0 ? (b = Math.floor(f.options.slidesToShow / 2), f.options.infinite === !0 && (a >= b && a <= f.slideCount - 1 - b ? f.$slides.slice(a - b, a + b + 1).addClass("slick-active").attr("aria-hidden", "false") : (d = f.options.slidesToShow + a, c.slice(d - b + 1, d + b + 2).addClass("slick-active").attr("aria-hidden", "false")), 0 === a ? c.eq(c.length - 1 - f.options.slidesToShow).addClass("slick-center") : a === f.slideCount - 1 && c.eq(f.options.slidesToShow).addClass("slick-center")), f.$slides.eq(a).addClass("slick-center")) : a >= 0 && a <= f.slideCount - f.options.slidesToShow ? f.$slides.slice(a, a + f.options.slidesToShow).addClass("slick-active").attr("aria-hidden", "false") : c.length <= f.options.slidesToShow ? c.addClass("slick-active").attr("aria-hidden", "false") : (e = f.slideCount % f.options.slidesToShow, d = f.options.infinite === !0 ? f.options.slidesToShow + a : a, f.options.slidesToShow == f.options.slidesToScroll && f.slideCount - a < f.options.slidesToShow ? c.slice(d - (f.options.slidesToShow - e), d + e).addClass("slick-active").attr("aria-hidden", "false") : c.slice(d, d + f.options.slidesToShow).addClass("slick-active").attr("aria-hidden", "false")), "ondemand" === f.options.lazyLoad && f.lazyLoad()
        }, b.prototype.setupInfinite = function () {
            var b, c, d, e = this;
            if (e.options.fade === !0 && (e.options.centerMode = !1), e.options.infinite === !0 && e.options.fade === !1 && (c = null, e.slideCount > e.options.slidesToShow)) {
                for (d = e.options.centerMode === !0 ? e.options.slidesToShow + 1 : e.options.slidesToShow, b = e.slideCount; b > e.slideCount - d; b -= 1) c = b - 1, a(e.$slides[c]).clone(!0).attr("id", "").attr("data-slick-index", c - e.slideCount).prependTo(e.$slideTrack).addClass("slick-cloned");
                for (b = 0; d > b; b += 1) c = b, a(e.$slides[c]).clone(!0).attr("id", "").attr("data-slick-index", c + e.slideCount).appendTo(e.$slideTrack).addClass("slick-cloned");
                e.$slideTrack.find(".slick-cloned").find("[id]").each(function () {
                    a(this).attr("id", "")
                })
            }
        }, b.prototype.setPaused = function (a) {
            var b = this;
            b.options.autoplay === !0 && b.options.pauseOnHover === !0 && (b.paused = a, a ? b.autoPlayClear() : b.autoPlay())
        }, b.prototype.selectHandler = function (b) {
            var c = this,
                d = a(b.target).is(".slick-slide") ? a(b.target) : a(b.target).parents(".slick-slide"),
                e = parseInt(d.attr("data-slick-index"));
            return e || (e = 0), c.slideCount <= c.options.slidesToShow ? (c.setSlideClasses(e), void c.asNavFor(e)) : void c.slideHandler(e)
        }, b.prototype.slideHandler = function (a, b, c) {
            var d, e, f, g, h = null,
                i = this;
            return b = b || !1, i.animating === !0 && i.options.waitForAnimate === !0 || i.options.fade === !0 && i.currentSlide === a || i.slideCount <= i.options.slidesToShow ? void 0 : (b === !1 && i.asNavFor(a), d = a, h = i.getLeft(d), g = i.getLeft(i.currentSlide), i.currentLeft = null === i.swipeLeft ? g : i.swipeLeft, i.options.infinite === !1 && i.options.centerMode === !1 && (0 > a || a > i.getDotCount() * i.options.slidesToScroll) ? void(i.options.fade === !1 && (d = i.currentSlide, c !== !0 ? i.animateSlide(g, function () {
                i.postSlide(d)
            }) : i.postSlide(d))) : i.options.infinite === !1 && i.options.centerMode === !0 && (0 > a || a > i.slideCount - i.options.slidesToScroll) ? void(i.options.fade === !1 && (d = i.currentSlide, c !== !0 ? i.animateSlide(g, function () {
                i.postSlide(d)
            }) : i.postSlide(d))) : (i.options.autoplay === !0 && clearInterval(i.autoPlayTimer), e = 0 > d ? 0 !== i.slideCount % i.options.slidesToScroll ? i.slideCount - i.slideCount % i.options.slidesToScroll : i.slideCount + d : d >= i.slideCount ? 0 !== i.slideCount % i.options.slidesToScroll ? 0 : d - i.slideCount : d, i.animating = !0, i.$slider.trigger("beforeChange", [i, i.currentSlide, e]), f = i.currentSlide, i.currentSlide = e, i.setSlideClasses(i.currentSlide), i.updateDots(), i.updateArrows(), i.options.fade === !0 ? (c !== !0 ? (i.fadeSlideOut(f), i.fadeSlide(e, function () {
                i.postSlide(e)
            })) : i.postSlide(e), void i.animateHeight()) : void(c !== !0 ? i.animateSlide(h, function () {
                i.postSlide(e)
            }) : i.postSlide(e))))
        }, b.prototype.startLoad = function () {
            var a = this;
            a.options.arrows === !0 && a.slideCount > a.options.slidesToShow && (a.$prevArrow.hide(), a.$nextArrow.hide()), a.options.dots === !0 && a.slideCount > a.options.slidesToShow && a.$dots.hide(), a.$slider.addClass("slick-loading")
        }, b.prototype.swipeDirection = function () {
            var a, b, c, d, e = this;
            return a = e.touchObject.startX - e.touchObject.curX, b = e.touchObject.startY - e.touchObject.curY, c = Math.atan2(b, a), d = Math.round(180 * c / Math.PI), 0 > d && (d = 360 - Math.abs(d)), 45 >= d && d >= 0 ? e.options.rtl === !1 ? "left" : "right" : 360 >= d && d >= 315 ? e.options.rtl === !1 ? "left" : "right" : d >= 135 && 225 >= d ? e.options.rtl === !1 ? "right" : "left" : e.options.verticalSwiping === !0 ? d >= 35 && 135 >= d ? "left" : "right" : "vertical";
        }, b.prototype.swipeEnd = function () {
            var a, b = this;
            if (b.dragging = !1, b.shouldClick = !(b.touchObject.swipeLength > 10), void 0 === b.touchObject.curX) return !1;
            if (b.touchObject.edgeHit === !0 && b.$slider.trigger("edge", [b, b.swipeDirection()]), b.touchObject.swipeLength >= b.touchObject.minSwipe) switch (b.swipeDirection()) {
                case "left":
                    a = b.options.swipeToSlide ? b.checkNavigable(b.currentSlide + b.getSlideCount()) : b.currentSlide + b.getSlideCount(), b.slideHandler(a), b.currentDirection = 0, b.touchObject = {}, b.$slider.trigger("swipe", [b, "left"]);
                    break;
                case "right":
                    a = b.options.swipeToSlide ? b.checkNavigable(b.currentSlide - b.getSlideCount()) : b.currentSlide - b.getSlideCount(), b.slideHandler(a), b.currentDirection = 1, b.touchObject = {}, b.$slider.trigger("swipe", [b, "right"])
            } else b.touchObject.startX !== b.touchObject.curX && (b.slideHandler(b.currentSlide), b.touchObject = {})
        }, b.prototype.swipeHandler = function (a) {
            var b = this;
            if (!(b.options.swipe === !1 || "ontouchend" in document && b.options.swipe === !1 || b.options.draggable === !1 && -1 !== a.type.indexOf("mouse"))) switch (b.touchObject.fingerCount = a.originalEvent && void 0 !== a.originalEvent.touches ? a.originalEvent.touches.length : 1, b.touchObject.minSwipe = b.listWidth / b.options.touchThreshold, b.options.verticalSwiping === !0 && (b.touchObject.minSwipe = b.listHeight / b.options.touchThreshold), a.data.action) {
                case "start":
                    b.swipeStart(a);
                    break;
                case "move":
                    b.swipeMove(a);
                    break;
                case "end":
                    b.swipeEnd(a)
            }
        }, b.prototype.swipeMove = function (a) {
            var b, c, d, e, f, g = this;
            return f = void 0 !== a.originalEvent ? a.originalEvent.touches : null, !(!g.dragging || f && 1 !== f.length) && (b = g.getLeft(g.currentSlide), g.touchObject.curX = void 0 !== f ? f[0].pageX : a.clientX, g.touchObject.curY = void 0 !== f ? f[0].pageY : a.clientY, g.touchObject.swipeLength = Math.round(Math.sqrt(Math.pow(g.touchObject.curX - g.touchObject.startX, 2))), g.options.verticalSwiping === !0 && (g.touchObject.swipeLength = Math.round(Math.sqrt(Math.pow(g.touchObject.curY - g.touchObject.startY, 2)))), c = g.swipeDirection(), "vertical" !== c ? (void 0 !== a.originalEvent && g.touchObject.swipeLength > 4 && a.preventDefault(), e = (g.options.rtl === !1 ? 1 : -1) * (g.touchObject.curX > g.touchObject.startX ? 1 : -1), g.options.verticalSwiping === !0 && (e = g.touchObject.curY > g.touchObject.startY ? 1 : -1), d = g.touchObject.swipeLength, g.touchObject.edgeHit = !1, g.options.infinite === !1 && (0 === g.currentSlide && "right" === c || g.currentSlide >= g.getDotCount() && "left" === c) && (d = g.touchObject.swipeLength * g.options.edgeFriction, g.touchObject.edgeHit = !0), g.swipeLeft = g.options.vertical === !1 ? b + d * e : b + d * (g.$list.height() / g.listWidth) * e, g.options.verticalSwiping === !0 && (g.swipeLeft = b + d * e), g.options.fade !== !0 && g.options.touchMove !== !1 && (g.animating === !0 ? (g.swipeLeft = null, !1) : void g.setCSS(g.swipeLeft))) : void 0)
        }, b.prototype.swipeStart = function (a) {
            var b, c = this;
            return 1 !== c.touchObject.fingerCount || c.slideCount <= c.options.slidesToShow ? (c.touchObject = {}, !1) : (void 0 !== a.originalEvent && void 0 !== a.originalEvent.touches && (b = a.originalEvent.touches[0]), c.touchObject.startX = c.touchObject.curX = void 0 !== b ? b.pageX : a.clientX, c.touchObject.startY = c.touchObject.curY = void 0 !== b ? b.pageY : a.clientY, void(c.dragging = !0))
        }, b.prototype.unfilterSlides = b.prototype.slickUnfilter = function () {
            var a = this;
            null !== a.$slidesCache && (a.unload(), a.$slideTrack.children(this.options.slide).detach(), a.$slidesCache.appendTo(a.$slideTrack), a.reinit())
        }, b.prototype.unload = function () {
            var b = this;
            a(".slick-cloned", b.$slider).remove(), b.$dots && b.$dots.remove(), b.$prevArrow && b.htmlExpr.test(b.options.prevArrow) && b.$prevArrow.remove(), b.$nextArrow && b.htmlExpr.test(b.options.nextArrow) && b.$nextArrow.remove(), b.$slides.removeClass("slick-slide slick-active slick-visible slick-current").attr("aria-hidden", "true").css("width", "")
        }, b.prototype.unslick = function (a) {
            var b = this;
            b.$slider.trigger("unslick", [b, a]), b.destroy()
        }, b.prototype.updateArrows = function () {
            var a, b = this;
            a = Math.floor(b.options.slidesToShow / 2), b.options.arrows === !0 && b.slideCount > b.options.slidesToShow && !b.options.infinite && (b.$prevArrow.removeClass("slick-disabled").attr("aria-disabled", "false"), b.$nextArrow.removeClass("slick-disabled").attr("aria-disabled", "false"), 0 === b.currentSlide ? (b.$prevArrow.addClass("slick-disabled").attr("aria-disabled", "true"), b.$nextArrow.removeClass("slick-disabled").attr("aria-disabled", "false")) : b.currentSlide >= b.slideCount - b.options.slidesToShow && b.options.centerMode === !1 ? (b.$nextArrow.addClass("slick-disabled").attr("aria-disabled", "true"), b.$prevArrow.removeClass("slick-disabled").attr("aria-disabled", "false")) : b.currentSlide >= b.slideCount - 1 && b.options.centerMode === !0 && (b.$nextArrow.addClass("slick-disabled").attr("aria-disabled", "true"), b.$prevArrow.removeClass("slick-disabled").attr("aria-disabled", "false")))
        }, b.prototype.updateDots = function () {
            var a = this;
            null !== a.$dots && (a.$dots.find("li").removeClass("slick-active").attr("aria-hidden", "true"), a.$dots.find("li").eq(Math.floor(a.currentSlide / a.options.slidesToScroll)).addClass("slick-active").attr("aria-hidden", "false"))
        }, b.prototype.visibility = function () {
            var a = this;
            document[a.hidden] ? (a.paused = !0, a.autoPlayClear()) : a.options.autoplay === !0 && (a.paused = !1, a.autoPlay())
        }, b.prototype.initADA = function () {
            var b = this;
            b.$slides.add(b.$slideTrack.find(".slick-cloned")).attr({
                "aria-hidden": "true",
                tabindex: "-1"
            }).find("a, input, button, select").attr({
                tabindex: "-1"
            }), b.$slideTrack.attr("role", "listbox"), b.$slides.not(b.$slideTrack.find(".slick-cloned")).each(function (c) {
                a(this).attr({
                    role: "option",
                    "aria-describedby": "slick-slide" + b.instanceUid + c
                })
            }), null !== b.$dots && b.$dots.attr("role", "tablist").find("li").each(function (c) {
                a(this).attr({
                    role: "presentation",
                    "aria-selected": "false",
                    "aria-controls": "navigation" + b.instanceUid + c,
                    id: "slick-slide" + b.instanceUid + c
                })
            }).first().attr("aria-selected", "true").end().find("button").attr("role", "button").end().closest("div").attr("role", "toolbar"), b.activateADA()
        }, b.prototype.activateADA = function () {
            var a = this,
                b = a.$slider.find("*").is(":focus");
            a.$slideTrack.find(".slick-active").attr({
                "aria-hidden": "false",
                tabindex: "0"
            }).find("a, input, button, select").attr({
                tabindex: "0"
            }), b && a.$slideTrack.find(".slick-active").focus()
        }, b.prototype.focusHandler = function () {
            var b = this;
            b.$slider.on("focus.slick blur.slick", "*", function (c) {
                c.stopImmediatePropagation();
                var d = a(this);
                setTimeout(function () {
                    b.isPlay && (d.is(":focus") ? (b.autoPlayClear(), b.paused = !0) : (b.paused = !1, b.autoPlay()))
                }, 0)
            })
        }, a.fn.slick = function () {
            var a, c = this,
                d = arguments[0],
                e = Array.prototype.slice.call(arguments, 1),
                f = c.length,
                g = 0;
            for (g; f > g; g++)
                if ("object" == typeof d || "undefined" == typeof d ? c[g].slick = new b(c[g], d) : a = c[g].slick[d].apply(c[g].slick, e), "undefined" != typeof a) return a;
            return c
        }
    });
var jq = $ = jQuery,
    BuddyBossMain = function (a, b, c) {
        var d = {
                $document: a(document),
                $window: a(b)
            },
            e = {},
            f = (a({}), {}),
            g = {};
        e.init = function () {
            d.$document.ready(e.domReady), g.init()
        }, e.domReady = function () {
            d.body = a("body"), d.$buddypress = a("#buddypress"), f.domReady()
        }, f.domReady = function () {
            function c(a, b) {
                if ("string" != typeof a || "" == a || "undefined" == typeof b || "" == b) return "";
                for (var c = a.split("&"), d = 0; d < c.length; d++) {
                    var e = c[d].split("=");
                    if (e[0] == b) return e[1]
                }
                return !1
            }

            function d() {
                var a = Array.prototype.slice.call(document.querySelectorAll("select"));
                a.length > 0 && a.forEach(function (a) {
                    aa.observe(a, {
                        attributes: !0
                    })
                })
            }

            function e() {
                return O.remove().appendTo(N), "mobile" != a.cookie("switch_mode") && (translation.only_mobile || (n().width < 480 ? a("body").removeClass("is-desktop").addClass("is-mobile") : a("body").removeClass("is-mobile").addClass("is-desktop"))), P = BuddyBoss.is_mobile = a("body").hasClass("is-mobile")
            }

            function f() {
                return V && V.length && (Q = !0), Q
            }

            function g() {
                var b = U.find("#item-nav");
                I = a('<div id="mobile-item-nav-wrap" class="mobile-item-nav-container mobile-item-nav-scroll-container">'), J = a('<div class="mobile-item-nav-wrapper">').appendTo(I), K = a('<div id="mobile-item-nav" class="mobile-item-nav">').appendTo(J), K.append(b.html()), K.css("width", 94 * b.find("li").length), I.insertBefore(b).show(), a("#mobile-item-nav-wrap, .mobile-item-nav-scroll-container, .mobile-item-nav-container").addClass("fixed"), b.css({
                    display: "none"
                })
            }

            function h() {
                var c = (M.height(), 94 * V.find("li").length);
                P && T.height() < M.height() && a("#page").css("min-height", M.height() - (a("#mobile-header").height() + a("#colophon").height())), P && a("#buddyboss-swipe-area").length && W.state && a("#buddyboss-swipe-area").css({
                    left: "left" === W.state ? 240 : "auto",
                    right: "right" === W.state ? 240 : "auto",
                    width: a(b).width() - 240,
                    height: a(b).outerHeight(!0) + 200
                });
                var d = a("#wp-admin-bar-logout"),
                    e = a("#wp-admin-bar-user-actions"),
                    f = a("#wp-admin-bar-my-account-settings .ab-submenu").first();
                d.length && e.length && f.length && (P ? d.appendTo(f) : d.appendTo(e)), P && Q && !R ? (R = !0, g()) : !P && Q && R ? (I.css({
                    display: "none"
                }), V.css({
                    display: "block"
                }), L.trigger("menu-close.buddyboss")) : P && Q && R && (I.css({
                    display: "block",
                    width: c
                }), K.css({
                    width: c
                }), V.css({
                    display: "none"
                })), "undefined" != typeof Selects && a.isFunction(Selects.populate_select_label) && Selects.populate_select_label(P)
            }

            function i() {
                e(), a(b).resize(e), f(), h(), j()
            }

            function j() {
                P && Q && (a("#mobile-item-nav #nav-bar-filter .hideshow ul").length > 0 && (a("#mobile-item-nav #nav-bar-filter").append(a("#mobile-item-nav #nav-bar-filter .hideshow ul").html()), a("#mobile-item-nav #nav-bar-filter .hideshow").remove()), S || (S = a(".mobile-item-nav-scroll-container").swiper({
                    scrollContainer: !0,
                    slideElement: "div",
                    slideClass: "mobile-item-nav",
                    wrapperClass: "mobile-item-nav-wrapper",
                    slidesPerView: "auto",
                    freeMode: !0
                })))
            }

            function k() {
                a("#content").fitVids(), a(".activity-inner").length > 0 && a(".activity-inner").find(".fluid-width-video-wrapper").each(function () {
                    a(this).parent().css({
                        "max-width": "530px"
                    })
                })
            }

            function l() {
                !P && ca.length > 0 ? (height = n().height, a("#scroll-area").css({
                    position: "relative"
                }), a("#scroll-area").outerHeight() + a("#masthead").outerHeight() + a("#wpadminbar").outerHeight() < height && a("#scroll-area").css({
                    position: "fixed"
                })) : a("#scroll-area").css({
                    position: "relative"
                })
            }

            function m() {
                var b = a("#primary"),
                    c = a("#menu-buddypanel").height();
                !P && b.length > 0 && c > b.height() && b.css({
                    "min-height": c + "px"
                })
            }

            function n() {
                var a = b,
                    c = "inner";
                return "innerWidth" in b || (c = "client", a = document.documentElement || document.body), {
                    width: a[c + "Width"],
                    height: a[c + "Height"]
                }
            }

            function o() {
                a("#left-menu-toggle").bind("click", function (b) {
                    b.preventDefault(), a("body").toggleClass(Z), a("body").hasClass(Z) ? (a("#left-panel #nav-menu > ul > li").each(function () {
                        a(this).children(".sub-menu-wrap").find("ul").length ? a(this).children(".sub-menu-wrap").children("a").remove() : a(this).children(".sub-menu-wrap").remove()
                    }), a.cookie("left-panel-status", "open", {
                        path: "/"
                    })) : (a("#left-panel #nav-menu > ul > li").each(function () {
                        var b = a(this).children("a:not(.fa)").clone();
                        if (a(this).children(".sub-menu-wrap").length) a(this).children(".sub-menu-wrap").prepend(b);
                        else {
                            var c = a("<div/>", {
                                "class": "sub-menu-wrap"
                            });
                            b.appendTo(c), a(this).append(c)
                        }
                    }), a.cookie("left-panel-status", "close", {
                        path: "/"
                    })), setTimeout(function () {
                        Y ? a(".left-col").toggleClass("open") : a(".right-col").toggleClass("open"), M.trigger("resize"), m()
                    }, 500), r()
                })
            }

            function p() {
                0 === a(".menu-panel .open-submenu").length && (a(".menu-panel .bp_components ul li ul li.menupop").prepend('<a class="open-submenu" href="#"><i class="fa fa-angle-right"></i></a>'), a(".menu-panel #nav-menu > ul > li").each(function () {
                    a(this).children(".sub-menu-wrap").length && 0 === a(this).children(".open-submenu").length && a(this).prepend('<a class="open-submenu" href="#"><i class="fa fa-angle-right"></i></a>')
                }), a(b).on("load", function () {
                    a(".menu-panel #header-menu .sub-menu-wrap").hide(), a(".menu-panel #header-menu ul li").each(function () {
                        a(this).children(".sub-menu-wrap").length && 0 === a(this).children(".open-submenu").length && a(this).prepend('<a class="open-submenu" href="#"><i class="fa fa-angle-right"></i></a>')
                    })
                })), a(".menu-panel .open-submenu").unbind(), a("body").off("click", ".menu-panel .open-submenu"), a("body").on("click", ".menu-panel .open-submenu", function (b) {
                    b.preventDefault(), a(this).next().next().slideToggle("fast", function () {}), a(this).find(".fa, .svg-inline--fa").toggleClass("fa-angle-down fa-angle-right"), a(this).closest("li").toggleClass("dropdown")
                })
            }

            function q() {
                a(".menu-panel .open-submenu").remove(), a(".menu-panel .ab-sub-wrapper, .sub-menu-wrap").removeAttr("style")
            }

            function r() {
                P || a("body").hasClass("tablet") && a("body").hasClass(Z) && a("body").hasClass("tablet") ? p() : q()
            }

            function s() {
                a("#main-button, .generic-button:not(.pending):not(.group-subscription-options)").on("click", function () {
                    $link = a(this).find("a"), $link.find("i").length || $link.hasClass("pending") || $link.append('<i class="fa fa-spinner fa-spin"></i>')
                })
            }

            function t() {
                if (X) {
                    var b = excluded_inputs_selector('input[type="checkbox"]'),
                        c = excluded_inputs_selector('input[type="radio"]');
                    a(b + "," + c).each(function () {
                        var b = a(this);
                        "gf_other_choice" == b.val() ? (b.addClass("styled"), b.next().wrap('<strong class="other-option"></strong>')) : b.parents("#bp-group-documents-form").length || (b.addClass("styled"), 0 == b.next("label").length && 0 == b.next("strong").length && b.after("<strong></strong>"))
                    })
                } else a('.events input[type="checkbox"], #buddypress table.notifications input, #send_message_form input[type="checkbox"], #profile-edit-form input[type="checkbox"],  #profile-edit-form input[type="radio"], #message-threads input, #settings-form input[type="radio"], #create-group-form input[type="radio"], #create-group-form input[type="checkbox"], #invite-list input[type="checkbox"], #group-settings-form input[type="radio"], #group-settings-form input[type="checkbox"], #new-post input[type="checkbox"], .bbp-form input[type="checkbox"], .bbp-form .input[type="radio"], .register-section .input[type="radio"], .register-section input[type="checkbox"], .message-check, #select-all-messages').each(function () {
                    var b = a(this);
                    b.addClass("styled"), 0 == b.next("label").length && 0 == b.next("strong").length && b.after("<strong></strong>")
                })
            }

            function u() {
                a("#left-panel").css("opacity", "1"), a("#left-panel").css("display", "block"), a("#profile-nav").addClass("close"), a("#right-panel").addClass("side-menu-right"), a("#mobile-header").addClass("side-menu-right"), a("#left-panel-inner").addClass("animated BeanSidebarIn").removeClass("BeanSidebarOut"), a("#masthead").css("margin-top", "0"), setTimeout(function () {
                    a("#left-panel").css("z-index", "0")
                }, 300)
            }

            function v() {
                a("#mobile-menu").css("opacity", "1"), a("#mobile-menu").css("display", "block"), a("#custom-nav").addClass("close"), a("#right-panel").addClass("side-menu-left"), a("#mobile-header").addClass("side-menu-left"), a("#mobile-menu-inner").addClass("animated BeanSidebarIn").removeClass("BeanSidebarOut"), a("#masthead").css("margin-top", "0"), setTimeout(function () {
                    a("#mobile-menu").css("z-index", "0")
                }, 300)
            }

            function w() {
                a("#left-panel").css("z-index", "-1"), a("#profile-nav").removeClass("close"), a("#right-panel").removeClass("side-menu-right"), a("#mobile-header").removeClass("side-menu-right"), a("#left-panel-inner").removeClass("BeanSidebarIn").addClass("BeanSidebarOut"), a("#left-panel-inner").addClass("animated "), setTimeout(function () {
                    a("#left-panel").css("z-index", "-1"), a("#left-panel").css("opacity", "0")
                }, 300)
            }

            function x() {
                a("#mobile-menu").css("z-index", "-1"), a("#custom-nav").removeClass("close"), a("#right-panel").removeClass("side-menu-left"), a("#mobile-header").removeClass("side-menu-left"), a("#mobile-menu-inner").removeClass("BeanSidebarIn").addClass("BeanSidebarOut"), a("#mobile-menu-inner").addClass("animated "), setTimeout(function () {
                    a("#mobile-menu").css("z-index", "-1"), a("#mobile-menu").css("opacity", "0")
                }, 300)
            }

            function y() {
                if (P) {
                    var b = a(".mobile-header-inner .searchform");
                    b.length && (b.focusin(function () {
                        a(this).css({
                            "z-index": "2"
                        }).stop().animate({
                            "padding-left": "5px",
                            "padding-right": "5px"
                        }, 400)
                    }), b.focusout(function () {
                        a(this).stop().animate({
                            "padding-left": "77px",
                            "padding-right": "77px"
                        }, 400), setTimeout(function () {
                            b.css({
                                "z-index": "0"
                            })
                        }, 400)
                    }))
                }
            }

            function z() {
                P ? (a("#header-search .search-wrap").unbind("focus"), a("#header-search .search-wrap").unbind("focusout")) : (a("#header-search .search-wrap").focusin(function () {
                    a(this).closest(".search-wrap").stop().animate({
                        width: "360px"
                    }, 400)
                }), a("#header-search .search-wrap").focusout(function () {
                    a(this).closest(".search-wrap").stop().animate({
                        width: "100px"
                    }, 400)
                }))
            }

            function A() {
                var b = a(".ui-autocomplete-input").offset().top + 48;
                a(".bb-global-search-ac").css({
                    top: b
                })
            }

            function B() {
                a(".more-items-btn").click(function () {
                    a(this).parent(".single-member-more-actions").find(".pop").slideToggle(100)
                })
            }

            function C() {
                a("#wp-admin-bar-my-account-buddypress").find("li").each(function () {
                    var b, c, d = a(this),
                        e = d.children("a").children(".count");
                    0 != e.length && (b = d.attr("id"), c = a(".bp-menu.bp-" + b.replace(/wp-admin-bar-my-account-/, "") + "-nav"), 0 == c.find(".count").length && c.find("a").append('<span class="count">' + e.html() + "</span>"))
                })
            }

            function D() {
                if (P) {
                    var b = a("#mobile-menu-inner");
                    if (!b.find("#header-menu").length) {
                        var c = a("#header-menu").clone(),
                            d = b.data("titlebar"),
                            e = b.find("#nav-menu");
                        c.find(".hideshow ul li").each(function () {
                            c.children("ul").append(a(this))
                        }), c.find(".hideshow").remove(), e.length ? "top" == d ? e.before(c) : "bottom" == d && e.after(c) : b.append(c)
                    }
                }
            }

            function E() {
                P ? 0 == a("#aw-whats-new-submit").prev("#buddyboss-media-add-photo").length && a("#buddyboss-media-add-photo").insertBefore("#aw-whats-new-submit") : 0 == a("#whats-new-additional").find("#buddyboss-media-add-photo").length && a("#whats-new-additional").append(a("#buddyboss-media-add-photo"))
            }

            function F() {
                ja.each(function () {
                    1 == ia.find(".selected").length ? a(this).hasClass("selected") && ha.html(a(this).html()) : ha.html(a("#activity-all").html())
                })
            }

            function G() {
                a(".pricing-content").css("height", "auto"), a(".pricing-content").equalHeights()
            }

            function H() {
                var b = a("#masthead").outerHeight();
                a("#right-panel").css({
                    "margin-top": b
                })
            }
            b.BuddyBoss = b.BuddyBoss || {}, b.BuddyBoss.is_mobile = null;
            var I, J, K, L = a(document),
                M = a(b),
                N = a("body"),
                O = a("#mobile-check").css({
                    position: "absolute",
                    top: 0,
                    left: 0,
                    width: "100%",
                    height: 1,
                    zIndex: 1
                }),
                P = !1,
                Q = !1,
                R = !1,
                S = !1,
                T = (a("#main-wrap"), a("#inner-wrap")),
                U = a("#buddypress"),
                V = U.find("#item-nav"),
                W = {},
                X = a("body").data("inputs"),
                Y = Boolean(a("body").data("rtl")),
                Z = "left-menu-open",
                $ = navigator.userAgent.indexOf("Android") >= 0,
                _ = parseInt((/WebKit\/([0-9]+)/.exec(navigator.appVersion) || 0)[1], 10) || void 0,
                aa = ($ && _ <= 534 && 0 == navigator.vendor.indexOf("Google"), new MutationObserver(function (b) {
                    b.forEach(function (b) {
                        if ("class" === b.attributeName) {
                            var c = a(b.target).prop(b.attributeName),
                                d = a(b.target).parent().hasClass("buddyboss-select-inner");
                            c.includes("select2-hidden-accessible") && d && (a(b.target).parent(".buddyboss-select-inner").children("span").first().remove(), a(b.target).unwrap(".buddyboss-select-inner"), a(b.target).unwrap(".buddyboss-select"))
                        }
                    })
                }));
            i(), M.bind("load", function () {
                i()
            });
            var ba;
            M.resize(function () {
                clearTimeout(ba), ba = setTimeout(i, 150)
            }), a(document).ajaxComplete(function (a, b, d) {
                var e = c(d.data, "action");
                "undefined" != typeof e && "bboss_global_search_ajax" == e && setTimeout(function () {
                    P && Q && (R = !0, g()), S = !1, j()
                }, 100)
            }), "undefined" != typeof Selects && a.isFunction(Selects.init_select) && (Selects.init_select(P, X), d()), L.ajaxComplete(function () {
                setTimeout(function () {
                    a.isFunction(Selects.init_select) && (Selects.init_select(P, X), d()), "undefined" != typeof Selects && a.isFunction(Selects.populate_select_label) && Selects.populate_select_label(P)
                }, 500)
            }), 0 !== a("body").find("#siteRegisterBox-step-2").length && L.ajaxComplete(function () {
                setTimeout(function () {
                    a.isFunction(Selects.init_select) && (Selects.init_select(P, X), d()), "undefined" != typeof Selects && a.isFunction(Selects.populate_select_label) && Selects.populate_select_label(P)
                }, 500)
            }), a(document).on("em_bookings_filtered", function () {
                a.isFunction(Selects.init_select) && (Selects.init_select(P, X), d()), "undefined" != typeof Selects && a.isFunction(Selects.populate_select_label) && Selects.populate_select_label(P)
            }), a("body").hasClass("bp-docs-create") && 0 === a("#item-nav").length && a("#buddypress").addClass("add-space"), a("a.show-options").click(function (b) {
                b.preventDefault, parent_li = a(this).parent("li"), a(parent_li).children("ul#members-list span.small").hasClass("inactive") ? (a(this).removeClass("inactive").addClass("active"), a(parent_li).children("ul#members-list span.small").removeClass("inactive").addClass("active")) : (a(this).removeClass("active").addClass("inactive"), a(parent_li).children("ul#members-list span.small").removeClass("active").addClass("inactive"))
            }), a("#buddypress div.dir-search form, #buddypress div.message-search form, div.bbp-search-form form, form#bbp-search-form").append('<a href="#" id="clear-input"> </a>'), a("a#clear-input").click(function () {
                jQuery("#buddypress div.dir-search form input[type=text], #buddypress div.message-search form input[type=text], div.bbp-search-form form input[type=text], form#bbp-search-form input[type=text]").val("")
            }), a("#buddypress #item-header #item-buttons .generic-button").length || a("#buddypress #item-header #item-buttons").hide(), a("#message-threads.messages-notices .thread-options .checkbox").each(function () {
                move_to_spot = a(this).parent().siblings(".thread-avatar"), a(this).appendTo(move_to_spot)
            }), jq("#message-type-select").change(function () {
                var a = jq("#message-type-select").val(),
                    b = jq("ul input[type='checkbox']");
                switch (b.each(function (a) {
                    b[a].checked = ""
                }), a) {
                    case "unread":
                        var b = jq("ul.unread input[type='checkbox']");
                        break;
                    case "read":
                        var b = jq("ul.read input[type='checkbox']")
                }
                "" != a ? b.each(function (a) {
                    b[a].checked = "checked"
                }) : b.each(function (a) {
                    b[a].checked = ""
                })
            }), "undefined" != typeof starAction && jq("#message-threads").on("click", ".thread-star a", starAction), jq("#delete_inbox_messages, #delete_sentbox_messages").on("click", function () {
                return checkboxes_tosend = "", checkboxes = jq("#message-threads ul input[type='checkbox']"), jq("#message").remove(), jq(this).addClass("loading"), jq(checkboxes).each(function (a) {
                    jq(this).is(":checked") && (checkboxes_tosend += jq(this).attr("value") + ",")
                }), "" == checkboxes_tosend ? (jq(this).removeClass("loading"), !1) : (jq.post(ajaxurl, {
                    action: "messages_delete",
                    thread_ids: checkboxes_tosend
                }, function (a) {
                    a[0] + a[1] == "-1" ? jq("#message-threads").prepend(a.substr(2, a.length)) : (jq("#message-threads").before('<div id="message" class="updated"><p>' + a + "</p></div>"), jq(checkboxes).each(function (a) {
                        jq(this).is(":checked") && jq(this).parent().parent().fadeOut(150)
                    })), jq("#message").hide().slideDown(150), jq("#delete_inbox_messages, #delete_sentbox_messages").removeClass("loading")
                }), !1)
            }), "undefined" != typeof a.fn.fitVids && a.isFunction(a.fn.fitVids) && (k(), a(document).ajaxSuccess(function (a, b, d) {
                var e = c(d.data, "action");
                "heartbeat" !== e && k()
            }));
            var ca = a("#primary");
            m(), imagesLoaded("body", function (a) {
                l()
            }), M.resize(function () {
                l(), m()
            }), a(document).ajaxComplete(function () {
                setTimeout(function () {
                    l()
                }, 500)
            }), setTimeout(function () {
                a(".right-col").toggleClass("open"), l()
            }, 500), a("#menu-buddypanel li.menu-item-has-children:not(.current-menu-item)").hover(function () {
                var c = a(".sub-menu-wrap", this),
                    d = a(this).offset().top - a(b).scrollTop(),
                    e = c.height(),
                    f = a(b).height(),
                    g = d + e;
                if (g >= f) {
                    var h = f - g;
                    c.css({
                        top: h + "px"
                    }), a("<style type='text/css' id='buddypanel-dynamic' />").appendTo("head");
                    var i = Math.abs(h) + 18;
                    a("#buddypanel-dynamic").text("body.left-menu-open .menu-panel .sub-menu-wrap:before,body.left-menu-open .sub-menu-wrap:after,body:not(.left-menu-open) .menu-panel .sub-menu-wrap:before,body:not(.left-menu-open) .sub-menu-wrap:after{ top:" + i + "px;}")
                }
            }, function () {
                var b = a(".sub-menu-wrap", this);
                b.css({
                    top: 0
                }), a("#buddypanel-dynamic").remove()
            }), a("#comment").attr("placeholder", translation.comment_placeholder), a(".accordion").length && a(".accordion").each(function () {
                var b = a(this).data("open");
                "false" == b && (b = !1), a(this).accordion({
                    active: b,
                    heightStyle: "content",
                    collapsible: !0
                })
            }), a(".tabs").length && a(".tabs").tabs(), a(".progressbar").length && a(".progressbar").each(function () {
                a(this).progressbar({
                    value: a(this).data("progress")
                })
            }), a(".tooltip").length && a(".tooltip").tooltip({
                position: {
                    my: "center bottom-10",
                    at: "center top",
                    using: function (b, c) {
                        a(this).css(b), a("<div>").addClass("arrow").addClass(c.vertical).addClass(c.horizontal).appendTo(this)
                    }
                }
            }), a(".menu-dropdown > ul").length && a(".menu-dropdown > ul").superfish(), a("#signup_form #signup_submit").on("click", function () {
                a("html, body").animate({
                    scrollTop: a("#profile-details-section").position().top
                }, "slow")
            });
            var da = navigator.userAgent;
            da.match(/iPad/i) || da.match(/iPhone/i) || da.match(/Android/i) ? "touch" : "click";
            if (a.fn.removeStyle = function (b) {
                    var c = new RegExp(b + "[^;]+;?", "g");
                    return this.each(function () {
                        a(this).attr("style", function (a, b) {
                            if (b) return b.replace(c, "")
                        })
                    })
                }, a.fn.fitText = function (c, d) {
                    var e = c || 1,
                        f = a.extend({
                            minFontSize: Number.NEGATIVE_INFINITY,
                            maxFontSize: Number.POSITIVE_INFINITY
                        }, d);
                    return this.each(function () {
                        var c = a(this),
                            d = function () {
                                c.css("font-size", Math.max(Math.min(c.width() / (10 * e), parseFloat(f.maxFontSize)), parseFloat(f.minFontSize)))
                            };
                        d(), a(b).on("resize.fittext orientationchange.fittext", d)
                    })
                }, a(".mobile-site-title").fitText(1, {
                    minFontSize: "18px",
                    maxFontSize: "25px"
                }), P && a(".bb-slider-container .title").fitText(1, {
                    minFontSize: "18px",
                    maxFontSize: "70px"
                }), a("body").hasClass(Z) || a("#left-panel #nav-menu > ul > li").each(function () {
                    var b = a(this).children("a:not(.fa)").clone();
                    if (a(this).children(".sub-menu-wrap").length) a(this).children(".sub-menu-wrap").prepend(b);
                    else {
                        var c = a("<div/>", {
                            "class": "sub-menu-wrap"
                        });
                        b.appendTo(c), a(this).append(c)
                    }
                }), o(), a(document).ajaxComplete(function () {
                    setTimeout(function () {
                        s()
                    }, 500), setTimeout(function () {
                        s()
                    }, 1500)
                }), jQuery(document).on("click", ".bb-add-label-button", function (a) {
                    a.preventDefault(), _this = jQuery(this), _this.find(".fa-spin").fadeOut();
                    var c = jQuery(".bb-label-name").val(),
                        d = {
                            action: "bbm_label_ajax",
                            task: "add_new_label",
                            thread_id: 0,
                            label_name: c
                        };
                    jQuery.post(ajaxurl, d, function (a) {
                        _this.find(".fa-spin").fadeIn();
                        var a = jQuery.parseJSON(a);
                        return "" != a.label_id && jQuery(".bb-label-container").load(b.location.href + " .bb-label-container", function () {
                            jQuery(".bb-label-container > .bb-label-container").attr("class", "")
                        }), "undefined" != typeof a.message && void("" != a.message && alert(a.message))
                    })
                }), jQuery(document).on("keydown", ".bb-label-name", function (a) {
                    13 == a.keyCode && jQuery(".bb-add-label-button").click()
                }), r(), a(b).resize(r), a(".tablet .header-account-login").on("click touch", function (b) {
                    a(this).find(".pop").toggleClass("hover")
                }), a("#wp-admin-bar-shortcode-secondary").length ? a(".tablet #wp-admin-bar-shortcode-secondary .menupop").on("click touch", function (b) {
                    a(this).find(".ab-sub-wrapper").toggleClass("hover")
                }) : a(".tablet .header-notifications").on("click touch", function (b) {
                    a(this).find(".pop").toggleClass("hover")
                }), a(".header-account-login ul#wp-admin-bar-my-account-buddypress > li.menupop, .header-account-login ul#menu-my-profile > li.menu-item-has-children").hover(function () {
                    var c = a("div.ab-sub-wrapper, ul.sub-menu", this),
                        d = a(this).offset().top - a(b).scrollTop(),
                        e = c.height(),
                        f = a("div.user-pop-links").height(),
                        g = d + e;
                    if (g >= f) {
                        var h = f - g;
                        c.css({
                            top: h + "px"
                        }), a("<style type='text/css' id='my-account-dynamic' />").appendTo("head");
                        var i = Math.abs(h) + 11;
                        a("#my-account-dynamic").text(".header-account-login .pop .bp_components .menupop:not(#wp-admin-bar-my-account) > .ab-sub-wrapper:before,.header-account-login .pop .links li > .sub-menu:before { top:" + i + "px;}")
                    }
                }, function () {
                    var b = a("div.ab-sub-wrapper, ul.sub-menu", this);
                    b.css({
                        top: 0
                    }), a("#my-account-dynamic").remove()
                }), s(), a("#whats-new-submit").append('<span class="spinner"></span>'), a(".scroll").bind("click", function (b) {
                    b.preventDefault();
                    var c = a(this);
                    a("html, body").stop().animate({
                        scrollTop: a(c.attr("href")).offset().top + "px"
                    }, 1e3, "easeInOutExpo")
                }), a("#group-create-body input[type=file], #avatar-upload input[type=file], #group-settings-form input[type=file]").change(function (b) {
                    var c = a(this).val(),
                        d = c.split("\\"),
                        e = d[d.length - 1];
                    a("#file-path").text(e)
                }), a(".back-btn").click(function (a) {
                    a.preventDefault(), b.history.back()
                }), t(), a(document).on("click", function (b) {
                    b.originalEvent && "profile-nav" != a(b.target)[0].id && 0 == a(b.target).closest("#left-panel").length && P && w(), b.originalEvent && "custom-nav" != a(b.target)[0].id && 0 == a(b.target).closest("#mobile-menu").length && P && x()
                }), a(document).on("click", "#profile-nav", function (b) {
                    b.preventDefault(), P && (b.preventDefault(), a("#right-panel").hasClass("side-menu-right") ? w() : u())
                }), a(document).on("click", "#custom-nav", function (b) {
                    b.preventDefault(), P && (b.preventDefault(), a("#right-panel").hasClass("side-menu-left") ? x() : v())
                }), y(), a('.search-wrap input[type="text"]').hasClass("ui-autocomplete-input") && (z(), M.scroll(function () {
                    A()
                })), "2" != N.data("header") && (a(".search-toggle a").click(function (b) {
                    b.preventDefault();
                    var c = a(this),
                        d = a(".searchform");
                    c.hasClass("closed") ? (c.removeClass("closed"), c.addClass("open"), setTimeout(function () {
                        d.find("#s").focus()
                    }, 301)) : (c.removeClass("open"), c.addClass("closed")), d.fadeToggle(300, "linear")
                }), a(document).click(function (b) {
                    var c = a(".searchform"),
                        d = a(".search-toggle");
                    c.is(b.target) || d.is(b.target) || 0 !== d.has(b.target).length || 0 !== c.has(b.target).length || !a("body").hasClass("boxed") || (d.find("a").removeClass("open").addClass("closed"), c.fadeOut())
                })), P && B(), !P) {
                a("#item-nav > .item-list-tabs > ul").jRMenuMore(60);
                var ea = 0;
                a("#members-directory-form div.item-list-tabs ul:first-child li").each(function () {
                    ea += a(this).outerWidth()
                });
                var fa = a("#members-directory-form div.item-list-tabs ul:first-child").width();
                ea > fa && a("#members-directory-form div.item-list-tabs ul:first-child").jRMenuMore(140), "2" == N.data("header") ? a("#header-menu > ul").jRMenuMore(120) : a("#header-menu > ul").jRMenuMore(70)
            }
            var ga = function () {
                function b() {
                    if (!P) {
                        var b = a("#item-nav > .item-list-tabs > ul > .hideshow > ul").height(),
                            c = a("#item-body").height();
                        b > c && a("#item-nav > .item-list-tabs > ul > .hideshow > ul").css({
                            height: c + "px",
                            "overflow-y": "auto"
                        })
                    }
                }
                return b
            }();
            if (M.resize(ga), C(), M.resize(D), P ? (a("#switch_mode").val("desktop"), a("#switch_submit").val(translation.view_desktop)) : (a("#switch_mode").val("mobile"), a("#switch_submit").val(translation.view_mobile)), a("#switch_submit").click(function () {
                    a.cookie("switch_mode", a("#switch_mode").val(), {
                        path: "/"
                    })
                }), "on" == a("#masthead").data("infinite")) {
                jq(document).on("scroll", function () {
                    var a = jq(".load-more:visible");
                    if (a.get(0)) {
                        var c = a.offset();
                        jq(b).scrollTop() + jq(b).height() > c.top && a.find("a").trigger("click")
                    }
                })
            }
            a(".page").find(".standard-form").each(function () {
                var b = a(this).attr("id");
                b && b.indexOf("bps_shortcode") >= 0 && a("#" + b).addClass("bps_form")
            }), E(), M.resize(E), a("#buddyboss-media-add-photo-button").text("");
            var ha = a(".item-list-tabs.activity-type-tabs .selected-tab"),
                ia = a(".item-list-tabs.activity-type-tabs > ul"),
                ja = a(".item-list-tabs.activity-type-tabs > ul > li");
            ha.click(function (a) {
                a.stopPropagation(), ia.slideToggle()
            }), a(document).ajaxComplete(function () {
                F()
            }), F(), ja.click(function () {
                ha.html(a(this).html())
            }), a(".dir-list div.is_friend").remove();
            var ka = a("#mobile-header");
            ka.hasClass("with-adminbar") && a(b).scroll(function () {
                    $fromTop = a("body").scrollTop(), $fromTop > 46 ? n().width < 600 ? ka.css({
                        position: "fixed",
                        top: 0
                    }) : ka.css({
                        position: "fixed",
                        top: 46
                    }) : ka.css({
                        position: "static",
                        top: 0
                    })
                }), ! function (a) {
                    a.fn.equalHeights = function () {
                        var b = 0,
                            c = a(this);
                        return c.each(function () {
                            var c = a(this).outerHeight();
                            c > b && (b = c)
                        }), c.css("height", b - 34)
                    }, a("[data-equal]").each(function () {
                        var b = a(this),
                            c = b.data("equal");
                        b.find(c).equalHeights()
                    })
                }(jQuery), a("#pmpro_levels_pricing_tables") && (G(), a(b).resize(function () {
                    clearTimeout(a.data(this, "resizeTimer")), a.data(this, "resizeTimer", setTimeout(function () {
                        G()
                    }, 50))
                }), a("#left-menu-toggle").click(function () {
                    setTimeout(function () {
                        G()
                    }, 550)
                }), a(b).trigger("resize")), a("body").hasClass("boxed") && !P && (H(), M.resize(function () {
                    H()
                })), a.fn.doubleTapToGo = function (c) {
                    return !!("ontouchstart" in b || navigator.msMaxTouchPoints || navigator.userAgent.toLowerCase().match(/windows phone os 7/i)) && (this.each(function () {
                        var b = !1;
                        a(this).on("click", function (c) {
                            var d = a(this);
                            d[0] != b[0] && (c.preventDefault(), b = d)
                        }), a(document).on("click touchstart MSPointerDown", function (c) {
                            for (var d = !0, e = a(c.target).parents(), f = 0; f < e.length; f++) e[f] == b[0] && (d = !1);
                            d && (b = !1)
                        })
                    }), this)
                }, a("body").hasClass("boxed") && a("body").hasClass("tablet") && a("#nav-menu > ul > li:has(ul)").doubleTapToGo(),
                a(document).on("heartbeat-tick.bb_notification_count", function (b, c) {
                    C(), c.hasOwnProperty("bb_notification_count") && (c = c.bb_notification_count, c.notification > 0 ? (jQuery("#ab-pending-notifications").text(c.notification).removeClass("no-alert"), jQuery("#ab-pending-notifications-mobile").text(c.notification).removeClass("no-alert"), jQuery("#wp-admin-bar-my-account-notifications .ab-item[href*='/notifications/']").each(function () {
                        jQuery(this).append("<span class='count'>" + c.notification + "</span>"), jQuery(this).find(".count").length > 1 && jQuery(this).find(".count").first().remove()
                    })) : (jQuery("#ab-pending-notifications").text(c.notification).addClass("no-alert"), jQuery("#ab-pending-notifications-mobile").text(c.notification).addClass("no-alert"), jQuery("#wp-admin-bar-my-account-notifications .ab-item[href*='/notifications/']").each(function () {
                        jQuery(this).find(".count").remove()
                    })), jQuery(".mobile #wp-admin-bar-my-account-notifications-read, #adminbar-links #wp-admin-bar-my-account-notifications-read").each(function () {
                        a(this).find("a").find(".count").remove()
                    }), c.unread_message > 0 ? (jQuery("#user-messages").find("span").html("<b>" + c.unread_message + "</b>").removeClass("no-alert"), jQuery("#user-messages").find("span").text(c.unread_message), jQuery(".ab-item[href*='/messages/']").each(function () {
                        jQuery(this).append("<span class='count'>" + c.unread_message + "</span>"), jQuery(this).find(".count").length > 1 && jQuery(this).find(".count").first().remove()
                    })) : (jQuery("#user-messages").find("span").html("<b>" + c.unread_message + "</b>").addClass("no-alert"), jQuery("#user-messages").find("span").text(c.unread_message), jQuery(".ab-item[href*='/messages/']").each(function () {
                        jQuery(this).find(".count").remove()
                    })), jQuery(".mobile #wp-admin-bar-my-account-messages-default, #adminbar-links #wp-admin-bar-my-account-messages-default").find("li:not('#wp-admin-bar-my-account-messages-inbox')").each(function () {
                        jQuery(this).find("span").remove()
                    }), c.friend_request > 0 ? jQuery(".ab-item[href*='/friends/']").each(function () {
                        jQuery(this).append("<span class='count'>" + c.friend_request + "</span>"), jQuery(this).find(".count").length > 1 && jQuery(this).find(".count").first().remove()
                    }) : jQuery(".ab-item[href*='/friends/']").each(function () {
                        jQuery(this).find(".count").remove()
                    }), jQuery(".mobile #wp-admin-bar-my-account-friends-default, #adminbar-links #wp-admin-bar-my-account-friends-default").find("li:not('#wp-admin-bar-my-account-friends-requests')").each(function () {
                        jQuery(this).find("span").remove()
                    }), c.notification_content && 0 < c.notification_content.length && jQuery(".header-notifications.all-notifications .pop").html(c.notification_content), c.message_content && 0 < c.message_content.length && jQuery(".header-notifications.user-messages .pop-links-inner").html(c.message_content))
                }), a(document).on("heartbeat-send", function (b, c) {
                    var d = +a("#ab-pending-notifications").text(),
                        e = +a(".header-notifications #user-messages > .count").text();
                    c.unread_notifications = d, c.unread_messages = e
                })
        }, g.init = function () {
            g.injected = !1, d.$document.ready(g.domReady)
        }, g.domReady = function () {
            g.check()
        }, g.check = function () {
            !g.injected && d.body.hasClass("buddypress") && 0 == d.$buddypress.length && g.inject()
        }, buddyboss_cover_photo = function (b) {
            $bb_cover_photo = a("#page .bb-cover-photo:last"), object = $bb_cover_photo.data("obj"), object_id = $bb_cover_photo.data("objid"), nonce = $bb_cover_photo.data("nonce"), $refresh_button = a("#refresh-cover-photo-btn"), rebind_refresh_cover_events = function () {
                $refresh_button.click(function () {
                    a(".bb-cover-photo #growls").remove(), a("#update-cover-photo-btn").prop("disabled", !0).removeClass("uploaded").addClass("disabled").find("i").fadeIn(), $refresh_button.prop("disabled", !0).removeClass("uploaded").addClass("disabled").find("i").fadeIn(), a.ajax({
                        type: "POST",
                        url: ajaxurl,
                        data: {
                            action: "buddyboss_cover_photo_refresh",
                            object: object,
                            object_id: object_id,
                            nonce: b.nonce,
                            routine: $refresh_button.data("routine")
                        },
                        success: function (b) {
                            var c = a.parseJSON(b);
                            a("#update-cover-photo-btn").prop("disabled", !1).removeClass("disabled").addClass("uploaded").find("i.fa-spin").fadeOut(), $refresh_button.prop("disabled", !1).removeClass("disabled").addClass("uploaded").find("i.fa-spin").fadeOut(), c || a.growl.error({
                                title: "",
                                message: BuddyBossOptions.bb_cover_photo_failed_refresh
                            }), c.error ? a.growl.error({
                                title: "",
                                message: c.error
                            }) : ($bb_cover_photo.find(".holder").remove(), image = c.image, $bb_cover_photo.append('<div class="holder"></div>'), $bb_cover_photo.find(".holder").css("background-image", "url(" + image + ")"), "refresh" == $refresh_button.data("routine") ? ($refresh_button.parent().toggleClass("no-photo"), $refresh_button.find(".fa-refresh").removeClass("fa-refresh").addClass("fa-times"), $refresh_button.find(">div").html(BuddyBossOptions.bb_cover_photo_remove_title + '<i class="fa fa-spinner fa-spin" style="display: none;"></i>'), $refresh_button.attr("title", BuddyBossOptions.bb_cover_photo_remove_title), $refresh_button.data("routine", "remove")) : ($refresh_button.parent().toggleClass("no-photo"), $refresh_button.find(".fa-times").removeClass("fa-times").addClass("fa-refresh"), $refresh_button.find(">div").html(BuddyBossOptions.bb_cover_photo_refresh_title + '<i class="fa fa-spinner fa-spin" style="display: none;"></i>'), $refresh_button.attr("title", BuddyBossOptions.bb_cover_photo_refresh_title), $refresh_button.data("routine", "refresh")), a.growl.notice({
                                title: "",
                                message: c.success
                            }))
                        },
                        error: function () {
                            $bb_cover_photo.find(".progress").hide().find("span").css("width", "0%"), a.growl.error({
                                message: "Error"
                            })
                        }
                    })
                })
            }, $refresh_button.length > 0 && rebind_refresh_cover_events()
        }, g.init = function () {
            g.injected = !1, d.$document.ready(g.domReady)
        }, g.domReady = function () {
            g.check()
        }, g.check = function () {
            !g.injected && d.body.hasClass("buddypress") && 0 == d.$buddypress.length && g.inject()
        }, g.inject = function () {
            g.injected = !0;
            var b, c, e = a("#secondary"),
                f = !1,
                h = a("#content"),
                i = h.find(".padder").first(),
                f = !1,
                j = h.children("article").first();
            e.length && (e.prop("id", "secondary").addClass("bp-legacy"), f = !0), i.length ? (i.prop("id", "buddypress").addClass("bp-legacy entry-content"), f = !0) : h.length && (h.wrapInner('<div class="bp-legacy entry-content" id="buddypress"/>'), f = !0), f && (d.$buddypress = a("#buddypress"), b = a(".buddyboss-bp-legacy.page-title"), c = a(".buddyboss-bp-legacy.item-header"), 0 === j.length && (h.wrapInner("<article/>"), j = a(h.find("article").first())), 0 !== h.find(".entry-header").length && 0 !== h.find(".entry-title").length || (b.prependTo(j).show(), b.children().unwrap()), 0 === h.find("#item-header-avatar").length && d.$buddypress.find("#item-header").length && (c.prependTo(d.$buddypress.find("#item-header")).show(), c.children().unwrap()))
        }, g.inject = function () {
            g.injected = !0;
            var b, c, e = a("#secondary"),
                f = !1,
                h = a("#content"),
                i = h.find(".padder").first(),
                f = !1,
                j = h.children("article").first();
            e.length && (e.prop("id", "secondary").addClass("bp-legacy"), f = !0), i.length ? (i.prop("id", "buddypress").addClass("bp-legacy entry-content"), f = !0) : h.length && (h.wrapInner('<div class="bp-legacy entry-content" id="buddypress"/>'), f = !0), f && (d.$buddypress = a("#buddypress"), b = a(".buddyboss-bp-legacy.page-title"), c = a(".buddyboss-bp-legacy.item-header"), 0 === j.length && (h.wrapInner("<article/>"), j = a(h.find("article").first())), 0 !== h.find(".entry-header").length && 0 !== h.find(".entry-title").length || (b.prependTo(j).show(), b.children().unwrap()), 0 === h.find("#item-header-avatar").length && d.$buddypress.find("#item-header").length && (c.prependTo(d.$buddypress.find("#item-header")).show(), c.children().unwrap()))
        }, jQuery(document).ready(function () {
            e.init()
        })
    }(jQuery, window);
! function (a) {
    a.fn.jRMenuMore = function (b) {
        a(this).each(function () {
            function c(c) {
                var d = 0,
                    e = a(c).width() - b,
                    f = -1,
                    g = "";
                jQuery.each(a(c).children(), function () {
                    f++, d += a(this).outerWidth(!0), e < d && (g += a("<div>").append(a(this).clone()).html(), a(this).remove())
                }), a(c).append('<li class="hideshow"><a href="#"><i class="fa fa-ellipsis-h"></i></a><ul>' + g + "</ul></li>"), a(c).children("li.hideshow ul").css("top", a(c).children("li.hideshow").outerHeight(!0) + "px"), a(c).find("li.hideshow > a").click(function (b) {
                    b.preventDefault();
                    var c = a(this).parent("li.hideshow").children("ul");
                    c.toggle(), a(this).parent("li.hideshow").parent("ul").toggleClass("open");
                    var d = a("#members-directory-form div.item-list-tabs ul:first-child");
                    if (0 < d.length) {
                        c.is(":visible") ? c.css("display", "block") : c.css("display", "none");
                        var e = a("div.item-list-tabs .horizontal-responsive-menu"),
                            f = a(window).width() - (e.offset().left + e.outerWidth());
                        a("div.item-list-tabs li.hideshow > ul").css({
                            right: f
                        })
                    }
                }), a(document).mouseup(function (b) {
                    var c = a("li.hideshow");
                    c.is(b.target) || 0 !== c.has(b.target).length || (c.children("ul").hide(), c.parent("ul").removeClass("open"))
                }), a(c).find("li.hideshow").find("li").length > 0 ? a(c).find("li.hideshow").show() : a(c).find("li.hideshow").hide()
            }
            a(this).addClass("horizontal-responsive-menu"), c(this);
            var d = this;
            a("#right-panel-inner").resize(function () {
                a(d).append(a(a(a(d).children("li.hideshow")).children("ul")).html()), a(d).children("li.hideshow").remove(), c(d)
            })
        })
    }
}(jQuery),
function (a) {
    "use strict";
    window.Plugins = {
        init: function () {
            this.groupHierarchy(), this.hideActionWrap(), this.onAjaxComplete(), this.fixQuizScroll()
        },
        groupHierarchy: function () {
            a("body").on("click", ".item-subitem-indicator a", function () {
                a(this).parent().toggleClass("bb-subitem-open")
            })
        },
        onAjaxComplete: function () {
            a(document).ajaxComplete(function () {
                a(".directory.groups #primary #buddypress .item-list li .action .action-wrap").each(function () {
                    var b = a(this);
                    "" === a.trim(b.html()) && (b.parent().hasClass("bb-hide-elem") || b.parent().addClass("bb-hide-elem"))
                })
            })
        },
        hideActionWrap: function () {
            a(".directory.groups #primary #buddypress .item-list li .action .action-wrap").each(function () {
                var b = a(this);
                "" === a.trim(b.html()) && (b.parent().hasClass("bb-hide-elem") || b.parent().addClass("bb-hide-elem"))
            })
        },
        fixQuizScroll: function () {
            a(".wpProQuiz_matrixSortString").length > 0 && a("html").addClass("quiz-sort")
        }
    }, a(document).on("ready", function () {
        Plugins.init()
    })
}(jQuery),

function (a) {
    function b() {
        var b = this;
        if (b.files && b.files[0]) {
            var c = new FileReader;
            c.onload = function (b) {
                a("#event-image-preview").attr("src", b.target.result)
            }, c.readAsDataURL(b.files[0])
        }
    }
    var c = a("#event-image");
    c.length && (c.wrap('<div class="event-upload-container"></div>'), c.after('<img id="event-image-preview" src="' + BuddyBossOptions.tpl_url + '/images/image-placeholder.png" />'), c.on("click", function () {
        a("#event-image-preview").attr("src", BuddyBossOptions.tpl_url + "/images/image-placeholder.png")
    }), c.on("change", b));
    var d = a("#em-tickets-form .form-table th");
    a("#em-tickets-form .form-table tbody").each(function () {
        var b = -1,
            c = !1;
        a(this).find("td").each(function () {
            if (c) {
                var e = a(d[b]).text();
                a(this).attr("data-th", e)
            }
            c = !0, b++
        })
    });
    var e = BuddyBossOptions.days;
    a(".em-calendar.fullcalendar tbody tr td").each(function (b) {
        a(this).children("a").attr("data-day", e[b % 7] + " ")
    }), a("#events-switch-layout a").click(function (b) {
        b.preventDefault(), a(this).hasClass("active") || (a.cookie("events_layout", a(this).attr("id"), {
            path: "/"
        }), a("#events-switch-layout a").removeClass("active"), a(this).addClass("active"), window.location.reload())
    });
    var f = a("#posts-filter");
    f.length && a(".em-button.add-new-h2").insertBefore(f)
}(jQuery);