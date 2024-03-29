function init() {
    "use strict";
    var svg = document.querySelector("#wheel > svg"),
        materialCustomizer = new MaterialCustomizer(svg);
}
MaterialCustomizer = function () {
    "use strict";

    function e(e) {
        return e.parentElement || e.parentNode;
    }

    var colors = ["Cyan", "Teal", "Green", "Light Green", "Lime", "Yellow", "Amber", "Orange", "Brown", "Blue Grey", "Grey", "Deep Orange", "Red", "Pink", "Purple", "Deep Purple", "Indigo", "Blue", "Light Blue"],
        forbiddenAccents = ["Blue Grey", "Brown", "Grey"],
        paletteIndices = ["Red", "Pink", "Purple", "Deep Purple", "Indigo", "Blue", "Light Blue", "Cyan", "Teal", "Green", "Light Green", "Lime", "Yellow", "Amber", "Orange", "Deep Orange", "Brown", "Grey", "Blue Grey"],
        lightnessIndices = ["50", "100", "200", "300", "400", "500", "600", "700", "800", "900", "A100", "A200", "A400", "A700"],
        palettes = [
            ["255,235,238", "255,205,210", "239,154,154", "229,115,115", "239,83,80", "244,67,54", "229,57,53", "211,47,47", "198,40,40", "183,28,28", "255,138,128", "255,82,82", "255,23,68", "213,0,0"],
            ["252,228,236", "248,187,208", "244,143,177", "240,98,146", "236,64,122", "233,30,99", "216,27,96", "194,24,91", "173,20,87", "136,14,79", "255,128,171", "255,64,129", "245,0,87", "197,17,98"],
            ["243,229,245", "225,190,231", "206,147,216", "186,104,200", "171,71,188", "156,39,176", "142,36,170", "123,31,162", "106,27,154", "74,20,140", "234,128,252", "224,64,251", "213,0,249", "170,0,255"],
            ["237,231,246", "209,196,233", "179,157,219", "149,117,205", "126,87,194", "103,58,183", "94,53,177", "81,45,168", "69,39,160", "49,27,146", "179,136,255", "124,77,255", "101,31,255", "98,0,234"],
            ["232,234,246", "197,202,233", "159,168,218", "121,134,203", "92,107,192", "63,81,181", "57,73,171", "48,63,159", "40,53,147", "26,35,126", "140,158,255", "83,109,254", "61,90,254", "48,79,254"],
            ["227,242,253", "187,222,251", "144,202,249", "100,181,246", "66,165,245", "33,150,243", "30,136,229", "25,118,210", "21,101,192", "13,71,161", "130,177,255", "68,138,255", "41,121,255", "41,98,255"],
            ["225,245,254", "179,229,252", "129,212,250", "79,195,247", "41,182,246", "3,169,244", "3,155,229", "2,136,209", "2,119,189", "1,87,155", "128,216,255", "64,196,255", "0,176,255", "0,145,234"],
            ["224,247,250", "178,235,242", "128,222,234", "77,208,225", "38,198,218", "0,188,212", "0,172,193", "0,151,167", "0,131,143", "0,96,100", "132,255,255", "24,255,255", "0,229,255", "0,184,212"],
            ["224,242,241", "178,223,219", "128,203,196", "77,182,172", "38,166,154", "0,150,136", "0,137,123", "0,121,107", "0,105,92", "0,77,64", "167,255,235", "100,255,218", "29,233,182", "0,191,165"],
            ["232,245,233", "200,230,201", "165,214,167", "129,199,132", "102,187,106", "76,175,80", "67,160,71", "56,142,60", "46,125,50", "27,94,32", "185,246,202", "105,240,174", "0,230,118", "0,200,83"],
            ["241,248,233", "220,237,200", "197,225,165", "174,213,129", "156,204,101", "139,195,74", "124,179,66", "104,159,56", "85,139,47", "51,105,30", "204,255,144", "178,255,89", "118,255,3", "100,221,23"],
            ["249,251,231", "240,244,195", "230,238,156", "220,231,117", "212,225,87", "205,220,57", "192,202,51", "175,180,43", "158,157,36", "130,119,23", "244,255,129", "238,255,65", "198,255,0", "174,234,0"],
            ["255,253,231", "255,249,196", "255,245,157", "255,241,118", "255,238,88", "255,235,59", "253,216,53", "251,192,45", "249,168,37", "245,127,23", "255,255,141", "255,255,0", "255,234,0", "255,214,0"],
            ["255,248,225", "255,236,179", "255,224,130", "255,213,79", "255,202,40", "255,193,7", "255,179,0", "255,160,0", "255,143,0", "255,111,0", "255,229,127", "255,215,64", "255,196,0", "255,171,0"],
            ["255,243,224", "255,224,178", "255,204,128", "255,183,77", "255,167,38", "255,152,0", "251,140,0", "245,124,0", "239,108,0", "230,81,0", "255,209,128", "255,171,64", "255,145,0", "255,109,0"],
            ["251,233,231", "255,204,188", "255,171,145", "255,138,101", "255,112,67", "255,87,34", "244,81,30", "230,74,25", "216,67,21", "191,54,12", "255,158,128", "255,110,64", "255,61,0", "221,44,0"],
            ["239,235,233", "215,204,200", "188,170,164", "161,136,127", "141,110,99", "121,85,72", "109,76,65", "93,64,55", "78,52,46", "62,39,35"],
            ["250,250,250", "245,245,245", "238,238,238", "224,224,224", "189,189,189", "158,158,158", "117,117,117", "97,97,97", "66,66,66", "33,33,33"],
            ["236,239,241", "207,216,220", "176,190,197", "144,164,174", "120,144,156", "96,125,139", "84,110,122", "69,90,100", "55,71,79", "38,50,56"]
        ],
        l = function (wheel) {
            this.svgE = wheel;
            this.paletteIndices = paletteIndices;
            this.lightnessIndices = lightnessIndices;
            this.palettes = palettes;
            this.init_();
        };
    return l.prototype.init_ = function () {
        this.config = {
            width: 650,
            height: 650,
            r: 250,
            ri: 100,
            hd: 40,
            c: 40,
            mrs: .5,
            alphaIncr: .005,
            colors: colors
        };
        this.forbiddenAccents = forbiddenAccents;
        this.calculateValues_();
        this.svgE && this.buildSvg()
    }, l.prototype.calculateValues_ = function () {
        var config = this.config;
        config.alphaDeg = 360 / config.colors.length, config.alphaRad = config.alphaDeg * Math.PI / 180, config.rs = (config.c + config.r) * Math.sin(config.alphaRad / 2), config.rs *= config.mrs, config.selectorAlphaRad = 2 * Math.atan(config.rs / config.c), config.gamma1 = config.alphaRad / 2 - config.selectorAlphaRad / 2, config.gamma2 = config.alphaRad / 2 + config.selectorAlphaRad / 2, config.cx = (config.c + config.r) * Math.sin(config.alphaRad) / 2, config.cy = -(config.c + config.r) * (1 + Math.cos(config.alphaRad)) / 2, this.config = config
    }, l.prototype.buildSvg = function () {
        var e = this.config,
            t = this.svgE.querySelector("g.wheel--maing");
        this.svgE.setAttribute("viewBox", "0 0 " + this.config.width + " " + this.config.height), this.svgE.setAttribute("preserveAspectRatio", "xMidYMid meet"), this.svgE.setAttribute("width", this.config.width), this.svgE.setAttribute("height", this.config.height);
        var a = this.generateFieldTemplate_(),
            r = "http://www.w3.org/2000/svg";
        e.colors.forEach(function (n, i) {
            for (var l = a.cloneNode(!0), o = 1; 2 >= o; o++) {
                var s = document.createElementNS(r, "g"),
                    c = document.createElementNS(r, "text");
                c.setAttribute("class", "label label--" + o), c.setAttribute("transform", "rotate(" + -e.alphaDeg * i + ")"), c.setAttribute("dy", "0.5ex"), c.textContent = "" + o, s.appendChild(c), s.setAttribute("transform", "translate(" + e.cx + "," + e.cy + ")"), l.appendChild(s)
            }
            l.setAttribute("data-color", n), l.querySelector(".polygons > *:nth-child(1)").style.fill = "rgb(" + this.getColor(n, "500") + ")", l.querySelector(".polygons > *:nth-child(2)").style.fill = "rgb(" + this.getColor(n, "700") + ")", l.querySelector(".polygons").addEventListener("click", this.fieldClicked_.bind(this)), l.setAttribute("transform", "rotate(" + e.alphaDeg * i + ")"), t.appendChild(l)
        }.bind(this)), t.setAttribute("transform", "translate(" + e.width / 2 + "," + e.height / 2 + ")")
    }, l.prototype.generateFieldTemplate_ = function () {
        var e = "http://www.w3.org/2000/svg",
            t = this.config,
            a = document.createElementNS(e, "g"),
            r = document.createElementNS(e, "g"),
            n = document.createElementNS(e, "polygon");
        n.setAttribute("points", [
            [t.ri * Math.sin(t.alphaRad + t.alphaIncr), -t.ri * Math.cos(t.alphaRad + t.alphaIncr)].join(","), [t.r * Math.sin(t.alphaRad + t.alphaIncr), -t.r * Math.cos(t.alphaRad + t.alphaIncr)].join(","), [0, -t.r].join(","), [0, -(t.ri + t.hd)].join(",")
        ].join(" "));
        var i = document.createElementNS(e, "polygon");
        i.setAttribute("points", [
            [t.ri * Math.sin(t.alphaRad + t.alphaIncr), -t.ri * Math.cos(t.alphaRad + t.alphaIncr)].join(","), [(t.ri + t.hd) * Math.sin(t.alphaRad + t.alphaIncr), -(t.ri + t.hd) * Math.cos(t.alphaRad + t.alphaIncr)].join(","), [0, -(t.ri + t.hd)].join(","), [0, -t.ri].join(",")
        ].join(" ")), r.appendChild(n), r.appendChild(i), r.setAttribute("class", "polygons"), a.appendChild(r);
        var l = document.createElementNS(e, "path");
        return l.setAttribute("class", "selector"), l.setAttribute("d", " M " + t.r * Math.sin(t.alphaRad) / 2 + " " + -(t.r * (1 + Math.cos(t.alphaRad)) / 2) + " L " + (t.cx - t.rs * Math.cos(t.gamma1)) + " " + (t.cy - t.rs * Math.sin(t.gamma1)) + " A " + t.rs + " " + t.rs + " " + t.alphaDeg + " 1 1 " + (t.cx + t.rs * Math.cos(t.gamma2)) + " " + (t.cy + t.rs * Math.sin(t.gamma2)) + " z "), a.appendChild(l), a
    }, l.prototype.getNumSelected = function () {
        return this.svgE.querySelector(".selected--2") ? 2 : this.svgE.querySelector(".selected--1") ? 1 : 0
    }, l.prototype.fieldClicked_ = function (t) {
        var a = e(e(t.target)),
            r = a.getAttribute("data-color"),
            n = this.getNumSelected();
        console.log(a);
        if (-1 === (a.getAttribute("class") || "").indexOf("selected--1") || 1 !== n) switch (n) {
            case 1:
                if (-1 !== this.forbiddenAccents.indexOf(r)) return;
                this.highlightField(a.getAttribute("data-color")), this.svgE.setAttribute("class", ""), window.requestAnimationFrame(function () {
                    this.updateStylesheet()
                }.bind(this));
                break;
            case 2:
                Array.prototype.forEach.call(this.svgE.querySelector("g.wheel--maing").childNodes, function (e) {
                    e.setAttribute("class", ""), e.querySelector(".polygons").setAttribute("filter", "")
                });
            case 0:
                this.highlightField(a.getAttribute("data-color")), window.requestAnimationFrame(function () {
                    this.svgE.setAttribute("class", "hide-nonaccents")
                }.bind(this))
        }
    }, l.prototype.replaceDict = function (e, t) {
        //for (var a in t) e = e.replace(new RegExp(a, "g"), t[a]);
        return e
    }, l.prototype.urlsafeName = function (e) {
        return e.toLowerCase().replace(" ", "_")
    }, l.prototype.getSelectedPrimary = function () {
        return this.svgE.querySelector(".selected--1").getAttribute("data-color")
    }, l.prototype.getSelectedSecondary = function () {
        return this.svgE.querySelector(".selected--2").getAttribute("data-color")
    }, l.prototype.highlightField = function (t) {
        var a = this.svgE.querySelector('[data-color="' + t + '"]'),
            r = e(a);
        r.removeChild(a), r.appendChild(a), a.setAttribute("class", "selected selected--" + (this.getNumSelected() + 1));
        var n = window.navigator.msPointerEnabled;
        n || a.querySelector(".polygons").setAttribute("filter", "url(#drop-shadow)")
    }, l.prototype.getColor = function (e, t) {
        var a = this.palettes[this.paletteIndices.indexOf(e)];
        return a ? a[this.lightnessIndices.indexOf(t)] : null
    }, l.prototype.processTemplate = function (e, t) {
        var a = this.getColor(e, "500"),
            r = this.getColor(e, "700"),
            n = this.getColor(t, "A200");
        return this.replaceDict(this.template, {
            "\\$color-primary-dark": r,
            "\\$color-primary-contrast": this.calculateTextColor(a),
            "\\$color-accent-contrast": this.calculateTextColor(n),
            "\\$color-primary": a,
            "\\$color-accent": n
        })
    }, l.prototype.calculateChannel = function (e) {
        return e /= 255, .03928 > e ? e / 12.92 : Math.pow((e + .055) / 1.055, 2.4)
    }, l.prototype.calculateLuminance = function (e) {
        var t = e.split(","),
            a = this.calculateChannel(parseInt(t[0])),
            r = this.calculateChannel(parseInt(t[1])),
            n = this.calculateChannel(parseInt(t[2]));
        return .2126 * a + .7152 * r + .0722 * n
    }, l.prototype.calculateContrast = function (e, t) {
        var a = this.calculateLuminance(e) + .05,
            r = this.calculateLuminance(t) + .05;
        return Math.max(a, r) / Math.min(a, r)
    }, l.prototype.calculateTextColor = function (e) {
        var t = 3.1,
            a = "255,255,255",
            r = "66,66,66",
            n = this.calculateContrast(e, a);
        if (n >= t) return a;
        var i = this.calculateContrast(e, r);
        return i > n ? r : a
    }, l.prototype.replaceKeyword = function (e, t, a) {
        return e.replace(new RegExp(t, "g"), a)
    }, l.prototype.updateStylesheet = function () {
        var e = document.getElementById("main-stylesheet"),
            t = document.createElement("style");
        t.id = "main-stylesheet";
        var a = this.processTemplate(this.getSelectedPrimary(), this.getSelectedSecondary());
        e && e.parentNode && e.parentNode.removeChild(e), t.textContent = a, document.head.appendChild(t)
    }, l
}(), "undefined" != typeof module && (module.exports = MaterialCustomizer);
init();