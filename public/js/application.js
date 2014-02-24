function application() {
    
}

/*
 * inicializuje dokument nebo jeho cast
 */
application.prototype.init = function (content) {
    
    function openInDialog() {
        var url = $(this).attr("href") + ".part";
        
        $.remoteDialog(url);
        
        return false;
    }
    
    // vytvoreni globalnich prvku
    content.find(".tabs").tabs()
    
    content.find("a.dialog").click(openInDialog)
}

/*
 * inicializuje cely dokument po nacteni stranky
 */
application.prototype.start = function () {
    window.APPLICATION.init($("body"))
}

window.APPLICATION = new application();

$(window.APPLICATION.start);