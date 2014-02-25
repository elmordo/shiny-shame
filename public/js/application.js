function application() {
    
}

application.prototype.activeFrame = null;

application.prototype.framePlayer = (function ($) {
    
    /*
     * trida pro kontrolu 
     * @returns {undefined}
     */
    function Director(player) {
        this._player = player;
    }
    
    // snimkovy prehravac
    Director.prototype._player=$;
    
    /*
     * vygeneruje ovladaci prvky
     */
    Director.prototype.generateControls = function () {
        throw "GenerateControls method was not implemented yet";
    };
    
    /*
     * zapne prehravani
     */
    Director.prototype.play = function () {
        throw "Play method was not implemented yet";
    };
    
    /*
     * zastavi prehravani
     */
    Director.prototype.pause = function () {
        throw "Play method was not implemented yet";
    };
    
    function LinearDirector(player) {
        this._player = player;
    }
    
    LinearDirector.prototype = new Director();
    
    LinearDirector.prototype._pause = jQuery;
    LinearDirector.prototype._play = jQuery;
    LinearDirector.prototype._frame = jQuery;
    LinearDirector.prototype._timer = null;
    
    LinearDirector.prototype.generateControls = function () {
        // vycisteni starych dat
        this._player._cc.children().remove();
        
        // nova data
        var timeFrameLab = $("<label />").text("Time per frame: ");
        var timeFrame = $("<input type='text' name='time-frame'>").val(1);
        
        var playButton = $("<button type='button' name='play' />").text("Play").click(this._playEvent(this));
        var pauseButton = $("<button type='button' name='pause' />").text("Pause").attr("disabled", "disabled").click(this._pauseEvent(this));
        
        timeFrameLab.append(timeFrame).appendTo(this._player._cc);
        
        this._player._cc.append(playButton).append(pauseButton);
        
        this._play = playButton;
        this._pause = pauseButton;
        this._frame = timeFrame;
    };
    
    LinearDirector.prototype._pauseEvent = function(context) {
        return function () {
            window.clearInterval(context._timer);
            context._play.removeAttr("disabled");
            context._pause.attr("disabled", "disabled");
        };
    };
    
    LinearDirector.prototype._playEvent = function(context) {
        return function () {
            var interval = Number(context._frame.val()) * 1000;
            context._timer = window.setInterval(context._nextEvent, interval, context);
            context._play.attr("disabled", "disabled");
            context._pause.removeAttr("disabled");
        };
    };
    
    LinearDirector.prototype._nextEvent = function(context) {
        // kontrola poctu snimku
        var next = window.APPLICATION.activeFrame.next();
        if (next.length == 0) {
            // vycisteni intervalu
            context._pause.click();
            return;
        }
        
        // aktivace noveho snimku
        next.find(">a").click();
    };
    
    function FramePlayer(options) {
        // rozsireni dat
        options = $.extend({
            source : null,
            controlContainer : null,
            director: LinearDirector
        }, options);
        
        this._cc = options.controlContainer;
        this._source = options.source;
        
        // vygenerovani ovladacich prvku
        this._director = new options.director(this);
        this._director.generateControls();
    };
    
    // kontejner pro ovladaci prvky
    FramePlayer.prototype._cc = $;
    FramePlayer.prototype._source = $;
    FramePlayer.prototype._director = Director();
    
    return FramePlayer;
})(jQuery);

/*
 * inicializuje dokument nebo jeho cast
 */
application.prototype.init = function (content) {
    
    var applicationContext = this;
    
    function toggleFullFrame() {
        // vymena aktivniho snimku
        applicationContext.activeFrame.removeClass("active");
        applicationContext.activeFrame = $(this).parents("li:first").addClass("active");
        
        // nastaveni cesty
        var path = $(this).attr("href");
        
        $("#big-frame img").attr("src", path);
        
        return false;
    }
    
    function openInDialog() {
        var url = $(this).attr("href") + ".part";
        
        $.remoteDialog(url);
        
        return false;
    }
    
    // vytvoreni globalnich prvku
    content.find(".tabs").tabs();
    
    content.find("a.dialog").click(openInDialog);
    content.find("#frames li>a").click(toggleFullFrame);
    this.activeFrame = content.find("#frames li:first").addClass("active");
    
    new this.framePlayer({
        "controlContainer" : content.find("#frame-director-controls"),
        "source" : content.find("#frames li")
    });
};

/*
 * inicializuje cely dokument po nacteni stranky
 */
application.prototype.start = function () {
    window.APPLICATION.init($("body"));
};

window.APPLICATION = new application();

$(window.APPLICATION.start);