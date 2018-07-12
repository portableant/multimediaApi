$(document).ready(function () {
    var cookieName = 'cookiePolicyMyWeb';
    var message = 'This site uses cookies to help us to improve.';
    var messageButton = 'Accept';
    var days = 10;
    var moreInfoRoute = 'http://www.britishmuseum.org/about_this_site/terms_of_use/cookies.aspx';
    var moreInfoText = 'More info..';
    //bottom or top
    var cookieBarStyle = 'bottom';

    $.fn.cookieBar(cookieName, message, messageButton, moreInfoRoute, moreInfoText, cookieBarStyle);

    $("#cookiebar-button").click(function () {
        $.fn.createCookie(days);
    });
});/**
 * Created by danielpett on 23/11/2015.
 */
