jQuery.fn.exists = function(){return this.length>0;}

var tmp = $.fn.popover.Constructor.prototype.show;
$.fn.popover.Constructor.prototype.show = function() {
    tmp.call(this); if (this.options.callback) {
        this.options.callback();
    }
}

/* Add _token for automatic ajax variable needed for Laravel to function */

$( window ).load(function() {

    /* Uncheck Login Privacy Statement Checkboxes by default */
    $('#login-form input[type=checkbox]').removeAttr('checked');

    $('body').on('hidden.bs.modal', '.modal', function () {
        $(this).removeData('bs.modal');
    });

    /* Do not submit empty/hashy HREFs */
    $('a[href=#]').click(function(e) {
        e.preventDefault;
    });

    $('.progress .progress-bar').progressbar({
        display_text: 'fill'
        //display_text: 'center'
        //,refresh_speed: 200
    });

    $('.dropdown-toggle').dropdown();

    $("input.slider").slider({
        tooltip: 'hide'
    });

    $("input.slider").on("slide", function( slideEvt )
    {
        $(this).parent().next('span.slider-value').html(slideEvt.value);
    });

    $("input.slider-range").slider({
        tooltip: 'hide'
    });

    $("input.slider-range").on("slide", function( slideEvt )
    {
        $(this).parent().siblings('input.slider-range-input-alpha').val(slideEvt.value[0]).next('input.slider-range-input-omega').val(slideEvt.value[1]);
        $(this).parent().siblings('span.slider-range-display-alpha').html(slideEvt.value[0]).next('span.slider-range-display-omega').html(slideEvt.value[1]);
    });




    /* ??? */
    /*
    $('a[href*=#]:not([href=#])').click(function() {
        if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
            var target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
            if (target.length) {
                $('html,body').animate({
                    scrollTop: target.offset().top
                }, 1000);
                return false;
            }
        }
    });
    */

    /* jQueryUI Datepicker */
    $.datepicker.regional['de'] = {clearText: 'löschen', clearStatus: 'aktuelles Datum löschen',
        closeText: 'schließen', closeStatus: 'ohne Änderungen schließen',
        prevText: 'Zurück', prevStatus: 'letzten Monat zeigen',
        nextText: 'Vor', nextStatus: 'nächsten Monat zeigen',
        currentText: 'heute', currentStatus: '',
        monthNames: ['Januar','Februar','März','April','Mai','Juni',
            'Juli','August','September','Oktober','November','Dezember'],
        monthNamesShort: ['Jan','Feb','Mär','Apr','Mai','Jun',
            'Jul','Aug','Sep','Okt','Nov','Dez'],
        monthStatus: 'anderen Monat anzeigen', yearStatus: 'anderes Jahr anzeigen',
        weekHeader: 'Wo', weekStatus: 'Woche des Monats',
        dayNames: ['Sonntag','Montag','Dienstag','Mittwoch','Donnerstag','Freitag','Samstag'],
        dayNamesShort: ['So','Mo','Di','Mi','Do','Fr','Sa'],
        dayNamesMin: ['So','Mo','Di','Mi','Do','Fr','Sa'],
        dayStatus: 'Setze DD als ersten Wochentag', dateStatus: 'Wähle D, M d',
        dateFormat: 'dd.mm.yy', firstDay: 1,
        initStatus: 'Wähle ein Datum', isRTL: false};

    $.datepicker.setDefaults($.datepicker.regional['en']);

    $('.question-date, .question-daterange').datepicker(
        {
            /*dateFormat: 'dd.mm.yy',*/
            dateFormat: 'yy/mm/dd',
            changeMonth: true,
            changeYear: true,
            //yearRange: '1972:2011',
            yearRange: new Date().getFullYear() + 'c:+10'
        }
    );
});