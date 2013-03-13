//<![CDATA[
/**
 * Section
 * JavaScript Section
 * ----------------------------------------------------------------
 * Author      : Connect Duo
 * Contact     : ti[at]cntd.com.br/ +55 11 98475-9151
 * ----------------------------------------------------------------
 */


var _main                 = {

    init          : function() {
        this.before();
    },

    before        : function() {
        libraries.example.init    = true;
        _loader.core(); // default
    },

    after         : function() {
        functionExample.init();
    }
};


// Function example
var functionExample    = {

    init    : function() {
        if (this.check())  this.core();
    },

    def     : {
        container       : '.class'
    },

    check   : function() {
        return (_exists(functionExample.def.container)) ? true : false;
    },

    core    : function() {


    }
};


_main.init();

//]]>