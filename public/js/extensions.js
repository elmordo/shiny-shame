/*
 * otevira dialogy s formulari nacitanymi ze serveru
 */
(function ($) {
    // seznam jiz nactenych dialogu
    var CACHE = {};
    
    /*
     * zobrazi cachovany dialog
     */
    function openDialog(url) {
        CACHE[url].dialog("open");
    }
    
    /*
     * pri zavreni se dialog pouze odpouta, ale neznici
     */
    function closeDialog() {
        $(this).dialog();
    }
    
    function saveHandler(url) {
        return function (response) {
            // prevedeni obsahu a vytvoreni dialogu
            var content = $(response);
            var hiddens = content.children("input[type='hidden']");
            var width = Number(hiddens.filter("[name='width']").val());
            var height = Number(hiddens.filter("[name='height']").val());
            
            if (!height) heigh = 500;
            if (!width) width = 800;
            
            content.dialog({
                "modal" : true,
                "autoOpen" : false,
                "height" : height,
                "width" : width
            })
            
            // zapis do cache
            CACHE[url] = content;
            
            // otevreni dialogu
            openDialog(url);
        }
    }
    
    $.remoteDialog = function(url, options) {
        // vychozi hodnoty
        options = $.extend({
            useCache : true
        }, options);
        
        // kontrola zda pouzit cache a jestli je stranka nactena
        if (options.useCache && CACHE.hasOwnProperty(url)) {
            openDialog(url);
            return;
        }
        
        $.get(url, {}, saveHandler(url), "html");
    }
})(jQuery)
