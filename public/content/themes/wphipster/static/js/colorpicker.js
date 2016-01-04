function init() {
    "use strict";


    var colors = [
            "red",
            "pink",
            "purple",
            "deep-purple",
            "indigo",
            "blue",
            "light-blue",
            "cyan",
            "teal",
            "green",
            "light-green",
            "lime",
            "yellow",
            "amber",
            "orange",
            "deep-orange",
            "brown",
            "blue-grey",
            "grey"
        ],
    //var colors = ["Cyan", "Teal", "Green", "Light Green", "Lime", "Yellow", "Amber", "Orange", "Brown", "Blue Grey", "Grey", "Deep Orange", "Red", "Pink", "Purple", "Deep Purple", "Indigo", "Blue", "Light Blue"],
        forbiddenAccents = ["blue-grey", "brown", "grey"],
        paletteIndices = ["red", "pink", "purple", "deep-purple", "indigo", "blue", "light-blue", "cyan", "teal", "green", "light-green", "lime", "yellow", "amber", "orange", "deep-orange", "brown", "grey", "blue-grey"],
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
        ];

    var primarySelectedCallback = function (colorName) {
        console.log('callback');
        var element = document.getElementById('primary_color');
        element.setAttribute('value', colorName);
    };

    var secondarySelectedCallback = function (colorName) {
        var element = document.getElementById('secondary_color');
        element.setAttribute('value', colorName);
    };

    var neutralColorSelectedCallback = function (colorName) {
        var element = document.getElementById('neutral_color');
        element.setAttribute('value', colorName);
    };
    var callbacks = [];
    callbacks.push(primarySelectedCallback);
    callbacks.push(secondarySelectedCallback);
    //callbacks.push(neutralColorSelectedCallback);
    var svg = document.querySelector("#wheel > svg"),
        materialCustomizer = new MaterialCustomizer(svg, colors, forbiddenAccents, paletteIndices, lightnessIndices,
            palettes, callbacks, 2);
}

var MaterialCustomizer = function (element, colors, forbiddenAccents, paletteIndices, lightnessIndices, palettes
    , callbacks, numOfColors) {
    this.svgE = element;
    this.colors = colors;
    this.forbiddenAccents = forbiddenAccents;
    this.paletteIndices = paletteIndices;
    this.lightnessIndices = lightnessIndices;
    this.palettes = palettes;
    this.callbacks = callbacks;
    this.numOfColors = numOfColors;
    this._init();
};

MaterialCustomizer.prototype._init = function () {
    this.config = {
        width: 650,
        height: 650,
        r: 250, // poluprecnik spoljasnjeg
        ri: 100, // poluprecnik unutrasnjeg
        hd: 40, // poluprecnik tamnijeg od unutrasnjeg
        c: 40, // selectors radius (height)
        mrs: .5, // selectors width
        alphaIncr: .005, // width of node (transform)
        colors: this.colors
    };
    //this.config = {
    //    width: 650,
    //    height: 650,
    //    r: 250,
    //    ri: 100,
    //    hd: 40,
    //    c: 40,
    //    mrs: .5,
    //    alphaIncr: .005,
    //    colors: this.colors
    //};
    this.calculateValues_();
    this.svgE && this.buildSvg();
};

MaterialCustomizer.prototype.calculateValues_ = function () {
    var config = this.config;
    config.alphaDeg = 360 / config.colors.length;
    config.alphaRad = config.alphaDeg * Math.PI / 180;
    config.rs = (config.c + config.r) * Math.sin(config.alphaRad / 2);
    config.rs *= config.mrs;
    config.selectorAlphaRad = 2 * Math.atan(config.rs / config.c);
    config.gamma1 = config.alphaRad / 2 - config.selectorAlphaRad / 2;
    config.gamma2 = config.alphaRad / 2 + config.selectorAlphaRad / 2;
    config.cx = (config.c + config.r) * Math.sin(config.alphaRad) / 2;
    config.cy = -(config.c + config.r) * (1 + Math.cos(config.alphaRad)) / 2;
    this.config = config;
};

MaterialCustomizer.prototype.buildSvg = function () {
    var config = this.config,
        containerElement = this.svgE.querySelector("g.wheel--maing");

    this.svgE.setAttribute("viewBox", "0 0 " + this.config.width + " " + this.config.height);
    this.svgE.setAttribute("preserveAspectRatio", "xMidYMid meet");
    this.svgE.setAttribute("width", this.config.width);
    this.svgE.setAttribute("height", this.config.height);

    var gColorElement = this.generateFieldTemplate_(),
        namespace = "http://www.w3.org/2000/svg";

    config.colors.forEach(function (color, i) {
        for (var gColorElementCloned = gColorElement.cloneNode(true), o = 1; this.numOfColors >= o; o++) {
            var gSelectorE = document.createElementNS(namespace, "g"),
                selectorTextE = document.createElementNS(namespace, "text");
            selectorTextE.setAttribute("class", "label label--" + o);
            selectorTextE.setAttribute("transform", "rotate(" + -config.alphaDeg * i + ")");
            selectorTextE.setAttribute("dy", "0.5ex");
            selectorTextE.textContent = "" + o;
            gSelectorE.appendChild(selectorTextE);
            gSelectorE.setAttribute("transform", "translate(" + config.cx + "," + config.cy + ")");
            gColorElementCloned.appendChild(gSelectorE);
        }
        gColorElementCloned.setAttribute("data-color", color);
        gColorElementCloned.querySelector(".polygons > *:nth-child(1)").style.fill = "rgb(" + this.getColor(color, "500") + ")";
        gColorElementCloned.querySelector(".polygons > *:nth-child(2)").style.fill = "rgb(" + this.getColor(color, "700") + ")";
        gColorElementCloned.querySelector(".polygons")
            .addEventListener("click", this.fieldClicked_.bind(this));
        gColorElementCloned.setAttribute("transform", "rotate(" + config.alphaDeg * i + ")");
        containerElement.appendChild(gColorElementCloned);
    }.bind(this));

    containerElement.setAttribute("transform", "translate(" + config.width / 2 + "," + config.height / 2 + ")")
};

MaterialCustomizer.prototype.generateFieldTemplate_ = function () {
    var namespace = "http://www.w3.org/2000/svg",
        config = this.config,
        gColorElement = document.createElementNS(namespace, "g"),
        gPolygonsE = document.createElementNS(namespace, "g"),
        polygonBigE = document.createElementNS(namespace, "polygon");
    polygonBigE.setAttribute("points",
        [
            [config.ri * Math.sin(config.alphaRad + config.alphaIncr), -config.ri * Math.cos(config.alphaRad + config.alphaIncr)].join(","),
            [config.r * Math.sin(config.alphaRad + config.alphaIncr), -config.r * Math.cos(config.alphaRad + config.alphaIncr)].join(","),
            [0, -config.r].join(","),
            [0, -(config.ri + config.hd)].join(",")
        ].join(" ")
    );
    var polygonSmallE = document.createElementNS(namespace, "polygon");
    polygonSmallE.setAttribute("points",
        [
            [config.ri * Math.sin(config.alphaRad + config.alphaIncr), -config.ri * Math.cos(config.alphaRad + config.alphaIncr)].join(","),
            [(config.ri + config.hd) * Math.sin(config.alphaRad + config.alphaIncr), -(config.ri + config.hd) * Math.cos(config.alphaRad + config.alphaIncr)].join(","),
            [0, -(config.ri + config.hd)].join(","),
            [0, -config.ri].join(",")
        ].join(" "));
    gPolygonsE.appendChild(polygonBigE);
    gPolygonsE.appendChild(polygonSmallE);
    gPolygonsE.setAttribute("class", "polygons");
    gColorElement.appendChild(gPolygonsE);
    var pathSelectorE = document.createElementNS(namespace, "path");
    pathSelectorE.setAttribute("class", "selector");
    pathSelectorE.setAttribute("d",
        " M " + config.r * Math.sin(config.alphaRad) / 2 +
        " " + -(config.r * (1 + Math.cos(config.alphaRad)) / 2) +
        " L " + (config.cx - config.rs * Math.cos(config.gamma1)) +
        " " + (config.cy - config.rs * Math.sin(config.gamma1)) +
        " A " + config.rs + " " + config.rs + " " + config.alphaDeg + " 1 1 " +
        (config.cx + config.rs * Math.cos(config.gamma2)) + " " + (config.cy + config.rs * Math.sin(config.gamma2)) + " z ");
    gColorElement.appendChild(pathSelectorE);
    return gColorElement

};

MaterialCustomizer.prototype.getColor = function (color, lightness) {
    var palletRow = this.palettes[this.paletteIndices.indexOf(color)];
    return palletRow ? palletRow[this.lightnessIndices.indexOf(lightness)] : null
};

MaterialCustomizer.prototype.hideForbiddenAccents = function (opacity) {
    Array.prototype.forEach.call(this.forbiddenAccents, function (colorName) {
        var element = document.querySelector('#wheel svg.hide-nonaccents g[data-color="' + colorName + '"]:not(.selected)');
        if (element !== null) {
            element.style.opacity = opacity;
        }
    });
};

MaterialCustomizer.prototype.fieldClicked_ = function (event) {
    var gColorElement = getSelectedNode(getSelectedNode(event.target)),
        colorName = gColorElement.getAttribute("data-color"),
        n = this.getNumSelected();
    //if (-1 === (gColorElement.getAttribute("class") || "").indexOf("selected--1") || 1 !== n)
    //for (var o = 0; o < this.numOfColors; o++) {
    if (n !== 1 && n !== this.numOfColors && n !== 0) {
        if (this.callbacks.length > n) {
            this.callbacks[n].call(this, colorName);
        }
        this.highlightField(gColorElement.getAttribute("data-color"), n);
        return;
    }

    if (n === this.numOfColors) {
        this.resetLabels();
        if (this.callbacks.length > (this.numOfColors)) {
            this.callbacks[this.numOfColors].call(this, colorName);
        }
        Array.prototype.forEach.call(this.svgE.querySelector("g.wheel--maing").childNodes, function (e) {
            e.setAttribute("class", "");
            e.querySelector(".polygons").setAttribute("filter", "");
        });
        n = 0;
    }
    if (n === 0) {
        console.log(this.callbacks.length);
        if (this.callbacks.length > 0) {
            this.callbacks[0].call(this, colorName);
        }
        this.highlightField(gColorElement.getAttribute("data-color"), 0);
        window.requestAnimationFrame(function () {
            this.svgE.setAttribute("class", "hide-nonaccents");
            this.hideForbiddenAccents(.12);
        }.bind(this));
        return;
    }

    if (n === 1) {
        if (-1 !== this.forbiddenAccents.indexOf(colorName)) return;
        //this.secondarySelectedCallback(colorName);
        if (this.callbacks.length > 1) {
            this.callbacks[1].call(this, colorName);
        }
        this.hideForbiddenAccents(1);
        this.highlightField(gColorElement.getAttribute("data-color"), n);
        this.svgE.setAttribute("class", "");
        return;
    }


    //}
    //switch (n) {
    //    case 1:
    //        //console.log(this.forbiddenAccents.indexOf(colorName));
    //        if (-1 !== this.forbiddenAccents.indexOf(colorName)) return;
    //        //this.secondarySelectedCallback(colorName);
    //        this.highlightField(gColorElement.getAttribute("data-color"), n);
    //        this.svgE.setAttribute("class", "");
    //        break;
    //    case 2:
    //        //this.primarySelectedCallback(colorName);
    //        this.highlightField(gColorElement.getAttribute("data-color"), n);
    //        break;
    //    case 3:
    //        //this.onResetCallback();
    //        Array.prototype.forEach.call(this.svgE.querySelector("g.wheel--maing").childNodes, function (e) {
    //            e.setAttribute("class", "");
    //            e.querySelector(".polygons").setAttribute("filter", "");
    //        });
    //        this.resetLabels();
    //    case 0:
    //        //this.primarySelectedCallback(colorName);
    //        this.highlightField(gColorElement.getAttribute("data-color"), 0);
    //        window.requestAnimationFrame(function () {
    //            this.svgE.setAttribute("class", "hide-nonaccents")
    //        }.bind(this))
    //}
};
MaterialCustomizer.prototype.resetLabels = function () {
    var labels = this.svgE.querySelectorAll("g.wheel--maing .label");
    Array.prototype.forEach.call(labels, function (label) {
        label.style.opacity = 0;
    });
    //return this.svgE.querySelector(".selected--2") ? 2 : this.svgE.querySelector(".selected--1") ? 1 : 0
};

MaterialCustomizer.prototype.getNumSelected = function () {
    for (var i = this.numOfColors; i > 0; i--) {
        if (this.svgE.querySelector(".selected--" + i)) {
            return i;
        }
    }
    return 0;
    //return this.svgE.querySelector(".selected--2") ? 2 : this.svgE.querySelector(".selected--1") ? 1 : 0
};

MaterialCustomizer.prototype.highlightField = function (colorName, i) {
    var element = this.svgE.querySelector('[data-color="' + colorName + '"]'),
        parent = getSelectedNode(element);
    parent.removeChild(element);
    parent.appendChild(element);
    element.setAttribute("class", "selected selected--" + (this.getNumSelected() + 1));

    var labels = element.querySelectorAll(".label");
    console.log(labels);
    console.log(i);
    labels[i].style.opacity = 1;
    var n = window.navigator.msPointerEnabled;
    n || element.querySelector(".polygons").setAttribute("filter", "url(#drop-shadow)")
};

function getSelectedNode(node) {
    return node.parentElement || node.parentNode;
}

init();
