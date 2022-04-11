jQuery(document).on('ready', sm_init_all);
var sidebars_home_max_height = 0;
var _smIsIE7 = (document.all && !document.querySelector);
var _smIsIE8 = (document.all && document.querySelector && !document.addEventListener);
var pg_action_ajax = null;
var id_panel_pg_ajax = null;
var scAttrs = {};

/**
 * Refresh styles in the modal window
 * http://spotmassage.smadit.com/my-events/ (Logen in Uset type Client)
 ***/
function init_ajax_status() {
    var document_ajaxStart = function() {
        
    };
    var document_ajaxStop = function() {
        jQuery(document).trigger('refresh_page_ajax');
    };
    jQuery(document).ajaxStart(document_ajaxStart);
    jQuery(document).ajaxStop(document_ajaxStop);
}
 function add_class_buttons() {
    var each_add_class_buttons = function(index, domEle){
        jQuery(domEle).addClass('btn');
    };
    jQuery('#sm_body input[type="submit"],#sm_body button').each(each_add_class_buttons);
}


function sm_init_all() {
    
    execute_tg_smenable();
    
    init_ajax_status();
    
    add_class_buttons();

    changeDropdownMonth('gfield_date_dropdown_month');
    
    if(typeof(sM.gfInitDate) != 'undefined') {
        gf_set_date_to_current();
    }
    jQuery('#sm_body .gform_wrapper .gfield select').each(function(index, domEle){
        jQuery(domEle).on('change', sm_change_dropdown);
    });
    var adm_bar = jQuery('#wpadminbar');
    if(adm_bar.length > 0) {
        jQuery('#sm_html body').css('padding-top', adm_bar.height()+'px');
    }
    
    var _columns = jQuery('.sidebars-content .sidebars-home').children('.column');
    if(_columns.length > 0) {
        sidebars_home_max_height = 0;
        _columns.each(each_columns_sidebars_home);
        _columns.each(function(index, domElement){
            jQuery(domElement).css('min-height', sidebars_home_max_height+'px');
        });
    }
    var _listool = jQuery('.gform_body .sm_tooltip');
    var road_listool = function(idx, domElemt) {
        var _this = jQuery(domElemt);
        if( !_this.hasClass('added-tooltip') ) {
            _this.addClass('added-tooltip');
            var _texttool = _this.children('.gfield_description').text();
            _this.children('.gfield_label').append('&nbsp;<i class="icon-info-sign"></i>').attr('data-placement', 'right').attr('data-original-title', _texttool).tooltip();
        }
    };
    _listool.each(road_listool);

    var _listshowlabel = jQuery('.gform_body .gf_show_label');
    var road_listshowlabel = function(idx, domElemt) {
        var _this = jQuery(domElemt);
        if( _this.hasClass('gplaceholder') ) {
            _this.children('.gfield_label').css('display', 'inline-block');
        }
    };
    _listshowlabel.each(road_listshowlabel);

    var _listaddress2col = jQuery('.gform_body .gf_address_2col .ginput_container').children().not('.gform_hidden, .gf_clear');
    var road_listaddress2col = function(idx, domElemt) {
        var clas = idx%2 === 0 ? 'ginput_left' : 'ginput_right';
        jQuery(domElemt).removeClass('ginput_full').removeClass('ginput_left').removeClass('ginput_right').addClass(clas);
        
    };
    _listaddress2col.each(road_listaddress2col);
    
    
}
function gf_set_date_to_current() {
    var loop_current_date = function(current_val) {
        return function(index, domElem) {
            var element = jQuery(domElem);
            if(element.val() == current_val) {
                element.attr('selected', 'selected');
            }
        };
    };
    
    var _selects = jQuery('.'+sM.gfInitDate+' .gfield_date_dropdown_day > select').on('change', sm_change_dropdown);
    var opts_days = _selects.children('option');
    var loop_days = loop_current_date(sM.cDay);
    opts_days.each(loop_days);
    _selects.trigger('change');
    
    _selects = jQuery('.'+sM.gfInitDate+' .gfield_date_dropdown_month > select').on('change', sm_change_dropdown);
    var opts_months =_selects.children('option');
    var loop_months = loop_current_date(sM.cMonth);
    opts_months.each(loop_months);
    _selects.trigger('change');
    
    _selects = jQuery('.'+sM.gfInitDate+' .gfield_date_dropdown_year > select').on('change', sm_change_dropdown);
    
    var copy_opts_years = _selects.children('option').first().clone();
    _selects.html('');
    _selects.append(copy_opts_years);
    var max_year = parseInt(sM.cYear, 10)+2;
    for(var i = sM.cYear; i <= max_year; i++) {
        _selects.append('<option value="'+i+'">'+i+'</option>');
    }

    var opts_years = _selects.children('option');
    var loop_years = loop_current_date(sM.cYear);
    opts_years.each(loop_years);

    _selects.trigger('change');
    
}
function changeDropdownMonth(_class) {
     var _lis_month = jQuery('.'+_class);
     
     _lis_month.each(each_lis_month);
}
var each_lis_month = function(index, domElement){
    var _li = jQuery(domElement);
    if(!_li.hasClass('changed-month')) {
        
        _li.addClass('changed-month');
        var select = _li.children('select');
        var options = select.children('option');
        options.each(changedOptionsMonth);
    }

};
var changedOptionsMonth = function(index, element){
    var opt = jQuery(element);
    var val = jQuery.trim(opt.text());
    var pos = '';
    if( val.length <= 2 ) {
        if(val.length == 1) {
            pos = '0'+val;
        } else {
            pos = val;
        }
        opt.text(pos+' - '+sM.short_months[pos]);
    }
};
function each_columns_sidebars_home(index, domElement) {
    var _height = jQuery(domElement).height();
    if(_height > sidebars_home_max_height) {
        sidebars_home_max_height = _height;
    }
}

function sm_change_dropdown(){
    var args = arguments;
    var _sel;
    if(args.length >= 1 && args[1] == 'smObj') {
        _sel = args[0];
    } else {
        _sel = this;
    }
    _sel = jQuery(_sel);
    
    var _v = _sel.val();
    if(jQuery.trim(_v).length <= 0) {
        _sel.css('color', '');
    } else {
        _sel.css('color', 'black');
    }
}

/**
 * Function to reload page
 ***/
function smreload() {

    var href = window.location.href, i;

    var testing = /^.*\/page\/\d+\/$/;
    if( !testing.test(href) && sM.paged !== null ) {
        var url;
        if( sM.permalink_structure.length <= 0 ) {
            url = href+'&paged='+sM.paged;
        } else {
            url = href.substring(href.length-1,href.length) == '/' ? href+'page/'+sM.paged+'/' : href+'/page/'+sM.paged+'/';
        }
        window.location.href = url;
        return;
    } else {

        if(sM.permalink_structure.length <= 0) {

            if( sM.paged !== null && href.indexOf('paged='+sM.paged) == -1 ) {
                i = href.indexOf('paged=');

                href = href.substring(0,i);
                href = href+'paged='+sM.paged;
                window.location.href = href;
                return;
            }

        } else {
            if( sM.paged !== null && href.indexOf('/page/'+sM.paged) == -1 ) {
                i = href.indexOf('/page/');

                href = href.substring(0,i);
                href = href+'/page/'+sM.paged+'/';
                window.location.href = href;
                return;
            }
        }

        

    }
    window.location.reload();
}
/**
 * Slider range
 ***/
function smslider(mytimes,ranges,reserved,sli,steping/* minutes */,sli_t1,sli_t2) {
    
    var convert_minutes = function(st_hour) {
        var parts = st_hour.split(':');
        return window.parseInt(parts[0])*60+window.parseInt(parts[1]);
    };
    var getStringTime = function(_d, m, format, cut, cm, ch) {
        if(!format) {
            format = '24hrs';
        }
        if(!cut) {
            cut = 0;
        }
        
        var t, r, h, min;
        t = new Date(_d[0],_d[1]-1,_d[2],Math.floor(m/60),m%60,0,0);
        h = t.getHours();
        min = t.getMinutes();

        if(cm) {
            min = min < 10 ? '0'+min : min;
        }
        

        if(format != '24hrs') {
            if(h == 12) {
                h++;
            }
            h = h%12;
        }
        if(ch) {
            h = h < 10 ? '0'+h : h;
        }
        r = h+':'+min+':00';
        return r.substring(0,r.length-cut);
    };
    var gwTime = function(_d, m) {
        var t = new Date(_d[0],_d[1]-1,_d[2],Math.floor(m/60),m%60,0,0);
        return t.getHours() >= 12 ? 'pm' : 'am';
    };
    var start = convert_minutes(ranges.start);
    var end = convert_minutes(ranges.end);
    
    var total_diff = end-start;
    var insert = function(rang) {
        
        var rS = convert_minutes(rang.start);
        var diff_range = convert_minutes(rang.end)-rS;

        var diff_left = rS-start;

        var _obj = jQuery('<div class="time-reserved progress progress-danger progress-striped">');
        
        _obj.html('<div class="bar w100"></div>');

        var total_width = sli.width();

        var left = (total_width/total_diff)*diff_left;
        var w = (total_width/total_diff)*diff_range;

        _obj.css('width',w).css('left', left);

        sli.prepend(_obj);
    };

    var val1, val2, _date, _disabled, tm, gw, current_date, mytime;


    if( typeof(mytimes.start) == 'undefined') {
        val1 = start;
        val2 = start;
    } else {
        val1 = mytimes.start;
        val2 = mytimes.end;
    }
    _date = mytimes.date.split('-');

    current_date = Math.floor(new Date(sM.servertime*1000).getTime()/1000);

    mytime = Math.floor(new Date(_date[0],_date[1]-1,_date[2],Math.floor(start/60),start%60,0,0).getTime()/1000);

    _disabled = (current_date >= mytime);


    if( !isNaN(val1) ) {
        tm = getStringTime(_date,val1,'12hrs',3,true,false);
        gw = gwTime(_date,val1);
        sli_t1.html(tm+' '+gw);
    } else {
        sli_t1.html('00:00');
        val1 = start = 0;
    }

    if( !isNaN(val2) ) {
        tm = getStringTime(_date,val2,'12hrs',3,true,false);
        gw = gwTime(_date,val2);
        sli_t2.html(tm+' '+gw);
    } else {
        sli_t2.html('00:00');
        val2 = end = 0;
    }
    

    sli.slider({
        range: true,
        min: parseFloat(start),
        max: parseFloat(end),
        disabled: _disabled,
        step: steping,
        values: [val1,val2],
        create: function( event, ui ) {
            var idx;
            for(idx in reserved) {
                insert(reserved[idx]);
            }
        },
        slide: function( event, ui ) {
            
            tm = getStringTime(_date,ui.values[0],'12hrs',3,true,false);
            gw = gwTime(_date,ui.values[0]);
            sli_t1.html(tm + ' ' + gw);

            tm = getStringTime(_date,ui.values[1],'12hrs',3,true,false);
            gw = gwTime(_date,ui.values[1]);
            sli_t2.html(tm + ' ' + gw);
        }
    });
}
/**
 * END slide range
 *******/


/**
 * funcion para mostrar un ventana modal (para no usar la funcion alert() de javascript)
 ***/
function smalert(message) {
    var html_modal = '<div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button><h3 id="my-modal-alert-label">'+sM.textAlertMessage+'</h3></div><div class="modal-body"><div id="alert_content">'+message+'</div></div><div class="modal-footer"><button class="btn" data-dismiss="modal" aria-hidden="true">'+sM.textOk+'</button></div>';

    var dialog = jQuery('#modal-alert');

    if(dialog.length <= 0) {
        dialog = jQuery('<div id="modal-alert" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-alert-label" aria-hidden="true">').html(html_modal);

        dialog.appendTo( jQuery(document.body) );
    } else {
        dialog.find('#alert_content').html(message);
    }

    dialog.modal('show');
}

/**
 * Ajax Pagination
 ***/
function goPage(num_page) {
    var params = {
        action: pg_action_ajax,
        paged: num_page,
        attrs: scAttrs,
        search: scAttrs.filter_search
    };
    sM.paged = num_page;
    var panel = jQuery(id_panel_pg_ajax);
    var success_func = function(response) {
        panel.children('.panel-content').html(response);
        panel.smenable();
        panel.find('.cbox-view').colorbox({transition:"fade",width:false,height:false,innerWidth:false,innerHeight:false,initialWidth:"600px",initialHeight:"600px",maxWidth:"900px",maxHeight:"600px",scalePhotos:false,opacity:0.3,preloading:false,current:" {current}  {total}",previous:"",next:"",close:"",overlayClose:false,loop:false,escKey:false,arrowKey:false,top:false,right:false,bottom:false,left:false});
    };
    var error_func = function (xhr, ajaxOptions, thrownError){
        window.location.reload();
    };
    
    panel.smdisable();
    jQuery.ajax({
        url: window.location.protocol+'//'+window.location.host+'/wp-admin/admin-ajax.php',
        type: 'post',
        data: params,
        success: success_func,
        error: error_func
    });
}
/** End Ajax Pagination **/

function execute_tg_smenable() {
    jQuery('.sm-tooltip').tooltip();
}
jQuery(document).on('tg_smenable',execute_tg_smenable);

(function ( $ ) {
 
    $.fn.smdisable = function(options) {
        jQuery(document).trigger('tg_smdisable');
        var settings = $.extend({
            clas: ''
        }, options );
        this.addClass('sm-disabled');
        var di_div = this.children('.div-disabled');
        var exist_disabled_div = di_div.length > 0;
        if(!exist_disabled_div) {
            di_div = $('<div>');
            this.append(di_div);
        }
        di_div.addClass('div-disabled '+settings.clas).css('background-color', 'white').animate({opacity: 0.5}, 10);
        di_div.fadeIn('fast');
        return this;
    };

    $.fn.smenable = function() {
        var di_div = this.children('.div-disabled');
        var exist_disabled_div = di_div.length > 0;
        if(exist_disabled_div) {
            di_div.fadeOut('fast');
        }
        var _this = this;
        di_div.css('background-color', '').animate({opacity: 1}, 10, function(){
            _this.removeClass('sm-disabled');
        });
        jQuery(document).trigger('tg_smenable');
        return this;
    };

}( jQuery ));