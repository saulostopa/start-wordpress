//<![CDATA[
/**
 * CORE
 * JavaScript general methods
 * ----------------------------------------------------------------
 * Author      : Connect Duo
 * Contact     : ti[at]cntd.com.br/ +55 11 98475-9151
 * ----------------------------------------------------------------
 */

var _core              = {

    init    : function() {
        this.before();
    },

    before  : function() {
        //
    },

    after   : function() {
        $(document).ready(function() {
            _internal.init();
            defaultValue.init();
            // google.analytics.init();
        });
    }
};


var _exists     = function(obj) {
    return ( $(obj).length  > 0 ) ? true : false;
};


var _internal          = {
    init    : function() {
        if ( this.check() ) {
            this.core();
        }
    },

    check   : function() {
        return (typeof _main == 'object') ? true : false;
    },

    core    : function() {
        _main.after();

    }
};


/* Defaul value */
var defaultValue       = {

    init    : function() {
        if (this.check())  this.core();
    },

    check   : function() {
        return true;
    },

    core    : function() {

        if(!Modernizr.input.placeholder){
            $('[placeholder]').focus(function() {
                var input = $(this);
                if (input.val() == input.attr('placeholder')) {
                    input.val('');
                    input.removeClass('placeholder');
                }
            }).blur(function() {
                var input = $(this);
                if (input.val() == '' || input.val() == input.attr('placeholder')) {
                    input.addClass('placeholder');
                    input.val(input.attr('placeholder'));
                }
            }).blur();
            $('[placeholder]').parents('form').submit(function() {
                $(this).find('[placeholder]').each(function() {
                    var input = $(this);
                        if (input.val() == input.attr('placeholder')) {
                        input.val('');
                    }
                })
            });
        }
    }
};


/*  Google Analytics  */
var pageTracker = '';
var google             = {

    analytics   : {

        init    : function() {

            if (this.check()){ this.core();}
        },

        check   : function() {

            if ( typeof _gat == 'object' ) this.core();
        },

        core    : function() {
            try {
                pageTracker = _gat._getTracker(libraries.gAnalytics.code);
                pageTracker._setDomainName(libraries.gAnalytics.domain);
                pageTracker._trackPageview();
            } catch (err) { }
        }
    }
};


_core.init();
//]]>