//<![CDATA[
/**
 * LOADER
 * JavaScript libraries loader
 * ----------------------------------------------------------------
 * Author      : Connect Duo
 * Contact     : ti[at]cntd.com.br/ +55 11 98475-9151
 * ----------------------------------------------------------------
 */


var _loader         = {
    init          : function() {
        _loader.core();
    },
    core          : function() {
        var i;
        for (i in libraries) {
            if (libraries[i].init && libraries[i].before) {
                this.array.before.push(libraries[i].url);
            } else if( libraries[i].init && !libraries[i].before) {
                this.array.after.push(libraries[i].url);
            }
            libraries[i].init    = false;
        }
        this.require(this.array.before);
        this.array.before = new Array();
    },
    array         : {
        before    : [],
        after     : []
    },
    require       : function(libs) {
        var i     = 0;
        var limit = libs.length;
        var html  = ''
        for (i; i < limit; i++) {
            html  += '<script src="' + libs[i] + '" type="text/javascript"></script>';
        }
        document.write(html);
    },
    after         : function() {
        _loader.require(_loader.array.after);
        this.array.after         = new Array();
    }
};


var def             = {
    project         : {
        name        : 'project',
        version     : '1.0.0',
        sitePath    : '/wp-content/themes/name-theme/_/',
        path        : {
            js      : 'js',
            css     : 'css',
            swf     : 'swf',
            flv     : 'flv',
            img     : 'img',
            xml     : 'xml'
        }
    },
    init            : function() {
        var i;
        for (i in def.project.path) {
            def.project.path[i] = def.project.sitePath + def.project.path[i] + '/';
        }
    }
};


def.init();


var libraries       = {

    //Functions generic
    core            : {
        init        : true,
        before      : false,
        url         : def.project.path.js + 'common/core.js?v=' + def.project.version
    },

    //Framework jquery
    jQuery          : {
        init        : true,
        before      : false,
        url         : def.project.path.js + 'libs/jquery-1.8.3.min.js?v=' + def.project.version
    },

    //Google Analytics
    gAnalytics      : {
        init        : false,
        before      : false,
        url         : 'https:' == document.location.protocol ? 'https://ssl.google-analytics.com/ga.js' : 'http://www.google-analytics.com/ga.js',
        code        : 'UA-2039129-7', // code analytcs
        domain      : '.site.com.br'
    }

};


_loader.init();
//]]>