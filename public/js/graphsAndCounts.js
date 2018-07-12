/**
 * Created by danielpett on 20/11/2015.
 * This script produces the graphs and counts needed for the application.
 */
var cultureAreas = [];
cultureAreas.push({area: "Africa", count: $('.5M05LIBPa0ySo2AAk4ASYs').length, colour: "#c60751"});
cultureAreas.push({area: "Americas", count: $('.6DHRv0dwWcwMkEOM0ikSG6').length, colour: "#b71a8b"});
cultureAreas.push({area: "Ancient Egypt", count: $('.47SjJjgpwQiQuAW2SeSO4m').length, colour: "#E8A713"});
cultureAreas.push({area: "Ancient Greece and Rome", count: $('.3fFLux3Et22IcSsgqS6uIm').length, colour: "#006c68"});
cultureAreas.push({area: "Asia", count: $('.139H4DnjyGi2miEOUgYCUC').length, colour: "#f47321"});
cultureAreas.push({area: "Clocks and Watches", count: $('.6257g9ngnS2umUGG8Syke8').length, colour: "#005695"});
cultureAreas.push({area: "Collecting the world", count: $('.1bnk7yDR9KKACOOYweOWkS').length, colour: "#005695"});
cultureAreas.push({area: "Europe", count: $('.3sCGLHqhoAG6UEWGWsgQy2').length, colour: "#6d8d23"});
cultureAreas.push({area: "Living and Dying", count: $('.6IVidvN8GI4KyOocm8K2sA').length, colour: "#005695"});
cultureAreas.push({area: "Money", count: $('.36zXI0owkUosqauOAaGagW').length, colour: "#005695"});
cultureAreas.push({area: "Middle East", count: $('.2ZMnZhHmNi22Wkg0Y2yKye').length, colour: "#532380"});
cultureAreas.push({area: "Prints and Drawings", count: $('.2UPfQDdau4Ogq6C0mIy8ca').length, colour: "#b07761"});
cultureAreas.push({area: "The Enlightenment", count: $('.76kbND7eucQyQOUOIiOGme').length, colour: "#005695"});


cultureAreas.sort(function (obj1, obj2) {
    return obj2.count - obj1.count;
});

var top5 = cultureAreas.slice(0, 5);

var topArea = cultureAreas.slice(0, 1);
var area = '';
var colorTop = '';
for (var key in topArea) {
    if (topArea.hasOwnProperty(key)) {
        area = topArea[key]["area"];
        colorTop = topArea[key]["colour"];
    }
}
$('#topArea').text(area).css({"color": colorTop});
top5Count = [];
for (var key in top5) {
    if (top5.hasOwnProperty(key)) {
        top5Count.push(top5[key]["count"]);
    }
}

colours = [];
for (var key in cultureAreas) {
    if (cultureAreas.hasOwnProperty(key)) {
        colours.push(cultureAreas[key]["colour"]);
    }
}

var totals = []
for (var key in cultureAreas) {
    if (cultureAreas.hasOwnProperty(key)) {
        totals.push(cultureAreas[key]["count"]);
    }
}
var labels = []
for (var key in cultureAreas) {
    if (cultureAreas.hasOwnProperty(key)) {
        labels.push(cultureAreas[key]["area"]);
    }
}

$('.bar').text(top5Count.toString());
$('.donut').text(totals.toString());
$('.numberObjects').text($('.thumbnail').length);
var width = $('#donutPlaceholder').width();
var widthBar = $('#bar').width();

$.fn.peity.defaults.donut = {
    delimiter: null,
    fill: colours,
    innerRadius: 75,
    radius: 8,
    width: width,
    height: 200
}
$('.donut').peity('donut');

$.fn.peity.defaults.bar = {
    delimiter: ",",
    fill: colours,
    height: 200,
    max: null,
    min: 0,
    padding: 0.1,
    width: widthBar
}
$(".bar").peity("bar");

//$('a.modalButton').on('shown.bs.modal', function(e) {
//
//    resizeMap($(e.relatedTarget).data('center'));
//
//});

//$('a.modalButton').on('click', function (e) {
//    var src = $(this).attr('data-src');
//    console.log(src);
//    $('#modalStreet').attr('src', src);
//});
$("img.lazy").lazyload({
    effect: "fadeIn"
});

function resizeMap(center) {

    if(typeof map =="undefined") return;
    google.maps.event.trigger(map, "resize");
    map.setCenter(center);

}
var $container = jQuery('#donut');

var barcolors      = colours,
    highlightcolor = colorTop,
    lengendlabels  = labels,
    data           = totals;

var pheight = 400,
    pwidth  = width,
    radius  = pwidth < pheight ? pwidth/3 : pheight/3;
bgcolor = jQuery('body').css('background-color');

var paper = new Raphael($container[0], pwidth, pheight);

// draw the piechart
var pie = paper.piechart(pwidth/2, pheight/2, radius, data, {
    legend: lengendlabels,
    legendpos: 'east',
    legendcolor: '#000',
    stroke: bgcolor,
    strokewidth: 1,
    colors: barcolors
});

var message = $('.thumbnail').length + '\n' + ' objects seen today';
// assign the hover in/out functions
pie.hover(function () {
    this.sector.stop();
    this.sector.scale(1.1, 1.1, this.cx, this.cy);
    this.sector.animate({ 'stroke': highlightcolor }, 400);
    this.sector.animate({ 'stroke-width': 1 }, 500, 'bounce');
    if (this.label) {
        this.label[0].stop();
        this.label[0].attr({ r: 8.5 });
        this.label[1].attr({ 'font-weight': 400 });
        center_label.attr('text', this.value.value + ' stops');
        center_label.animate({ 'opacity': 1 }, 200);
    }
}, function () {
    this.sector.animate({ transform: 's1 1 ' + this.cx + ' ' + this.cy }, 500, "bounce");
    this.sector.animate({ 'stroke': bgcolor }, 400);
    if (this.label) {
        this.label[0].stop();
        this.label[0].attr({ r: 8.5 });
        this.label[1].attr({ 'font-weight': 400 });
        center_label.attr('text', message);
        center_label.animate({ 'opacity': 1 }, 200);
    }
});
// blank circle in center to create donut hole effect
paper.circle(pwidth/2, pheight/2, radius*0.6)
    .attr({'fill': bgcolor, 'stroke': bgcolor});

var center_label = paper.text(pwidth/2, pheight/2, '')
    .attr({'fill': '#000', 'font-size': '16', 'opacity': 1})
    .attr('text', message);