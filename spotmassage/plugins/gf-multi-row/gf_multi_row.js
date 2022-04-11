/*
<a href="javascript::void(0);" onclick="gformAddListItem(this, 0);">Add Job</a>
<a href="javascript::void(0);" onclick="gformDeleteListItem(this, 0);">Remove Job</a>
*/
var gf_format_date = smGf.gf_format_date;
var gf_multi_dates = {};
var gf_position_dates = {};

var _base_fields = [];
var gf_finish_object;
var gf_rows = 1;
var gf_removes = 1;

var _values_fields = {};
jQuery(document).on('ready', init_gf_multi_row);

function init_gf_multi_row() {
    gf_rows = 1;
    gf_removes = 1;
    
    gfLoadFieldsBase();
    gfLoadValues();
}


function gfLoadValues() {
    var exits = gf_if_exists_values();
    if(exits) {
        var _count = jQuery('.gf_multi_row_reference .gfield_list tbody tr').length;
        
        init_gf_loadValues();
        
        for(var i = 0; i < _count; i++){
            gfAddRowFields(null, _values_fields);
        }
    } else {
        _tbody = jQuery('.gf_multi_row_reference .gfield_list tbody');
        _tbody.html('');
    }
    
}

function init_gf_loadValues() {
    var _list = jQuery('.gf_multi_row_reference .gfield_list tbody tr');
    var _id_new_field;
    _list.each(function(index, domElement){
        _current = jQuery(domElement);
        _tds = _current.children('td.gfield_list_cell');
        
        var i = 0;
        
        _tds.each(function(idx, element){
            _curr = jQuery(element);
            _input = _curr.children();
            
            _val = _input.val();
            _field = _base_fields[i];
            
            _id_new_field = 'gfref_'+gf_rows+'_'+(i+1);
            
            if(_field.type == 'multi-select') {
                
                if(_field.selects.length > 0) {
                    var _value_dates = gf_get_values_date(_val);
                    for(var k = 0; k < _field.selects.length; k++) {
                        _select = _field.selects[k];
                        _values_fields[_id_new_field+'_'+_select.type_date] = _value_dates[_select.type_date];
                    }
                }
            } else {
                _values_fields[_id_new_field] = _val;
            }
            i++;
        });
        
        gf_rows++;
    });
    gf_rows = 1;
    jQuery('.gf_multi_row_reference .gfield_list tbody tr').each(function(index, domElement){
        _current = jQuery(domElement);
        if(_current.children().length > 6) {
            _current.remove();
        }
    });
}

function gf_get_values_date(_val_date) {
    if(gf_format_date == 'mdy') {
        _dts = _val_date.split('/');
        _retrn = {
            day: _dts[1],
            month: _dts[0],
            year: _dts[2]
        };
        return _retrn;
        
    } else if(gf_format_date == 'dmy') {
        _dts = _val_date.split('/');
        _retrn = {
            day: _dts[0],
            month: _dts[1],
            year: _dts[2]
        };
        return _retrn;
    } else if(gf_format_date == 'dmy_dash') {
        _dts = _val_date.split('-');
        _retrn = {
            day: _dts[0],
            month: _dts[1],
            year: _dts[2]
        };
        return _retrn;
    } else if(gf_format_date == 'dmy_dot') {
        _dts = _val_date.split('.');
        _retrn = {
            day: _dts[0],
            month: _dts[1],
            year: _dts[2]
        };
        return _retrn;
    } else if(gf_format_date == 'ymd_slash') {
        _dts = _val_date.split('/');
        _retrn = {
            day: _dts[2],
            month: _dts[1],
            year: _dts[0]
        };
        return _retrn;
    } else if(gf_format_date == 'ymd_dash') {
        _dts = _val_date.split('-');
        _retrn = {
            day: _dts[2],
            month: _dts[1],
            year: _dts[0]
        };
        return _retrn;
    } else if(gf_format_date == 'ymd_dot') {
        _dts = _val_date.split('.');
        _retrn = {
            day: _dts[2],
            month: _dts[1],
            year: _dts[0]
        };
        return _retrn;
    }
}
function gf_if_exists_values() {
    var _list = jQuery('.gf_multi_row_reference .gfield_list tbody tr');
    if(_list.length <= 0) {
        return false;
    }
    var centinela = false;
    _list.each(function(index, domElement){
        _current = jQuery(domElement);
        if(centinela) {
            return;
        }
        _tds = _current.children('td');
        _tds.each(function(idx, element){
            _curr = jQuery(element);
            _input = _curr.children();
            if(_input.val().trim().length > 0) {
                centinela = true;
                return;
            }
        });
    });
    return centinela;
}

function gfLoadFieldsBase() {
    
    var _lis = jQuery('.secundary-form .gform_fields').children('li');
    _base_fields = [];
    if(_lis.length > 0) {
        var _cent_load = 0;
        _lis.each(function(index, domElement){
            var _current = jQuery(domElement);
            
            if(_current.hasClass('start_gf_multi_row')) {
                _cent_load = 1;
                ini_adding(_current);
            } else if(_current.hasClass('finish_gf_multi_row') /*|| _current.hasClass('gf_multi_row_reference')*/) {
                gf_finish_object = _current;
                ini_adding(_current);
                _cent_load = 2;
            } else if(_cent_load == 1) {
                ini_adding(_current);
            }
        });
    }
    
}

function ini_adding(_li) {

    var each_selects = function(index, domElement) {
        var _ths = jQuery(domElement);
        _sub_select = _ths.children('select');
        
        var _options = _sub_select.children();
        
        var _struc_options = [];
        if(_options.length > 0) {
            _options.each(function(index1, domElement2){
                var _current_option = jQuery(domElement2);
                var _vl = _current_option.attr('value');
                var _selected = false;
                
                if(typeof(sM.gfInitDate) != 'undefined') {
                    if( _ths.hasClass('gfield_date_dropdown_month') ) {
                        _selected = sM.cMonth == _vl;
                    } else if( _ths.hasClass('gfield_date_dropdown_day') ) {
                        _selected = sM.cDay == _vl;
                    } else if( _ths.hasClass('gfield_date_dropdown_year') ) {
                        _selected = sM.cYear == _vl;
                    }
                }
                
                _struc_options.push({
                    value: _vl,
                    text: _current_option.text(),
                    selected: _selected
                });
            });
        }
        
        if( _ths.hasClass('gfield_date_dropdown_month') ) {
            _type_date = 'month';
        } else if( _ths.hasClass('gfield_date_dropdown_day') ) {
            _type_date = 'day';
        } else if(_ths.hasClass('gfield_date_dropdown_year')) {
            _type_date = 'year';
        }
        
        _selects.push({
            name: _sub_select.attr('name'),
            options: _struc_options,
            type_date: _type_date
        });
    };
    var _container = _li.children('.clear-multi');
                
                
    var _struc_obj = {};
    var _idf = _li.attr('id').split("_")[2];
    var _li_label = '';
    var _obj_label = _li.children('label');
    var inpt = null;
    if(_obj_label.length > 0) {
        _li_label = {
            text: _obj_label.text().replace(/\*/g,''),
            clases: _obj_label.attr('class')
        };
    }
    var list_container = _li.children('.ginput_container');
    if(list_container.hasClass('ginput_list')) {
        var _selects = [];


        var _tds = list_container.find('.gfield_list_cell');

        if(_tds.length > 0) {

            _tds.each(each_selects);

            _struc_obj = {
                id_field: _idf,
                atrclass: _li.attr('class'),
                type: 'multi-dates',
                selects: _selects,
                separator: '/'
            };
        }


        
    } else if( _container.length>0 && _container.hasClass('clear-multi') ) {
        var _selects = [];
        inpt =  _container.children('.ginput_container');
        
        var _type_date = '';
        
        inpt.each(each_selects);
        
        _struc_obj = {
            id_field: _idf,
            atrclass: _li.attr('class'),
            type: 'multi-select',
            selects: _selects,
            separator: '/'
        };
    } else {
        _container = _li.children('.ginput_container');
        inpt = _container.children('select');
        if(inpt.length>0 && inpt.hasClass('gfield_select')) {
            var _options = inpt.children();
            
            var _struc_options = [];
            if(_options.length > 0) {
                _options.each(function(index, domElement){
                    var _current_option = jQuery(domElement);
                    _struc_options.push({
                        value: _current_option.attr('value'),
                        text: _current_option.text(),
                    });
                });
            }
            _struc_obj = {
                id_field: _idf,
                atrclass: _li.attr('class'),
                type: 'select',
                name: inpt.attr('name'),
                options: _struc_options
            };
        } else {
            //if the field is a input type text
            inpt = _container.children('input');
            if(inpt.hasClass('medium')){
                _struc_obj = {
                    id_field: _idf,
                    atrclass: _li.attr('class'),
                    type: 'input',
                    name: inpt.attr('name'),
                    placeholder: inpt.attr('placeholder')
                };
            } else {
                //if the field is a input type checkbox
                inpt = _container.children('ul');
                if(inpt.length>0) {
                    _obj_label = inpt.find('label');
                    _li_label = {
                        text: _obj_label.text().replace(/\*/g,''),
                        clases: _obj_label.attr('class')
                    };

                    inpt = inpt.find('input');
                    _struc_obj = {
                        id_field: _idf,
                        atrclass: _li.attr('class'),
                        type: 'checkbox',
                        name: inpt.attr('name'),
                        placeholder: ''
                    };
                }
            }
        }
    }
    
    if(typeof(_struc_obj.name) != "undefined" || _struc_obj.type == 'multi-select' || _struc_obj.type == 'multi-dates') {
        _struc_obj.label = _li_label;
        _base_fields.push(_struc_obj);
    }
}

function gfRemoveRow(class_to_remove) {
    
    var _remove = jQuery('.'+class_to_remove);
    
    if(_remove.length > 0) {
        _remove.remove();
        gf_removes++;
        
        if( gf_rows-gf_removes == 0) {
            jQuery('.gf_actions').show();
        }
    }
    
}

function gfAddRow(_this) {
    gfAddRowFields(_this, null);
}

function gfAddRowFields(_this, values) {
    if(typeof(gf_finish_object) != "undefined") {
        var _before = null;
        
        var _html = '';
        var _new_row = '';
        var _li;
        var _id_new_field;
        
        var _li_actions = jQuery('.gf_actions');
        
        var _actions_class = _li_actions.attr('class').replace('gf_actions', '');
        var _actions = _li_actions.children();
        //_actions = _actions.find('.ginput_container');
        
        
        var texts = [];
        
        _actions.each(function(index, domElemen) {
            texts.push(jQuery(domElemen));
        });
        
        _actions = texts[1].find('a');
        
        texts = [];
        _actions.each(function(index, domElemen) {
            texts.push(jQuery(domElemen));
        });
        
        var text_add_location = texts[0].text();
        var text_remove_location = texts[1].text();
        
        //var _actions = '<li class="gfrow'+gf_rows+' gfield gfield_html gfield_html_formatted gfield_no_follows_desc"><a href="javascript:void(0);" onclick="gfAddRow(this);">'+text_add_location+'</a> <a href="javascript:void(0);" onclick="gfRemoveRow(\'gfrow'+gf_rows+'\')">'+text_remove_location+'</a></li>';
        _actions ='<li class="gfrow'+gf_rows+' '+_actions_class+'">' +
                  '<a href="javascript:void(0);" onclick="gfAddRow(this);">'+text_add_location+'</a> | ' +
                  '<a href="javascript:void(0);" onclick="gfRemoveRow(\'gfrow'+gf_rows+'\')">'+text_remove_location+'</a></li>';
        
        gf_finish_object.after(_actions);
        
        var _val;
        var refresh = [];
        var num_mselect = 0;
        for(var i = _base_fields.length-1; i >= 0; i--) {
        //for(var i = 0; i < _base_fields.length; i++) {
            
            _field = _base_fields[i];
            
            //clas = i%2 == 0 ? 'gf_left_half' : 'gf_right_half';
            
            //_li = jQuery('<li>').addClass('gfield gplaceholder hide-label '+clas+' gfield_contains_required');
            
            _li = jQuery('<li>').addClass(_field.atrclass);
            
            _id_new_field = 'gfref_'+gf_rows+'_'+(i+1);
            
            _val = (values == null) ? '' : values[_id_new_field];
            
            _div = jQuery('<div>').addClass('ginput_container');
            
            if( _field.type != 'multi-select') {
                _new_row = '<td class="gfield_list_cell gfield_list_24_cell'+(i+1)+'"><input id="'+_id_new_field+'" type="text" name="input_24[]" value="'+_val+'" tabindex="18"></td>'+_new_row;
            }
            
            if(_field.type == 'input') {
                _new_entry = jQuery('<input>').attr('type','text').attr('name', _field.name+'_'+gf_rows+'_'+i).attr('placeholder', _field.placeholder).addClass('medium gfield_select').val(_val);
                _new_entry.attr('ref_to', _id_new_field);
                _new_entry.on('change',change_entry).bind('change', sm_change_dropdown);
                _div.append(_new_entry);
            } else if(_field.type == 'select' ) {
                _new_entry = jQuery('<select>').attr('name', _field.name+'_'+gf_rows+'_'+i).addClass('medium gfield_select');
                
                for(pos in _field.options) {
                    obj_option = _field.options[pos];
                    option = jQuery('<option>').attr('value',obj_option.value).text(obj_option.text);
                    _new_entry.append(option);
                }
                _new_entry.attr('ref_to', _id_new_field).val(_val);
                _new_entry.on('change',change_entry).bind('change', sm_change_dropdown);
                
                _div.append(_new_entry);

            } else if(_field.type == 'multi-select') {

                add_multi_date(num_mselect);
                
                _div = jQuery('<div>').addClass('clear-multi');
                if(_field.selects.length > 0) {
                    _val = '';
                    for(var k = 0; k < _field.selects.length; k++) {
                        
                        _select = _field.selects[k];
                        
                        if(values !== null) {
                            _val_current = values[_id_new_field+'_'+_select.type_date];
                                if(k === 0) {
                                _val = _val_current;
                            } else {
                                _val = _val+''+_field.separator+''+_val_current;
                            }
                        } else {
                            _val_current = '';
                        }
                        _divsub_select = jQuery('<div>').addClass('ginput_container');
                        
                        _new_entry = jQuery('<select>').attr('name', gf_rows+'_'+i+'_'+k+'_'+_select.name);
                        
                        var centinela_selected = false;
                        
                        for(var pos in _select.options) {
                            obj_option = _select.options[pos];
                            option = jQuery('<option>').attr('value',obj_option.value).text(obj_option.text);
                            
                            if(obj_option.selected) {
                                option.attr('selected', 'selected');
                                centinela_selected = obj_option.value;
                            }
                            
                            _new_entry.append(option);
                        }
                        
                        _new_entry.attr('num_mselect', num_mselect).attr('ref_to', _id_new_field).attr('type_date',_select.type_date).attr('row',gf_rows).addClass('multi-select').val(_val_current);
                        _new_entry.on('change',change_entry).bind('change', sm_change_dropdown);
                        _divsub_select.append(_new_entry);
                        
                        if(centinela_selected) {
                            _new_entry.val(centinela_selected);
                            refresh.push(_id_new_field);
                        }

                        num_mselect++;
                        
                        _div.append(_divsub_select);
                    }    
                }
                _new_row = '<td class="gfield_list_cell gfield_list_24_cell'+(i+1)+'"><input id="'+_id_new_field+'" type="text" name="input_24[]" value="'+_val+'" tabindex="18"></td>'+_new_row;
            } /*else if(_field.type == 'checkbox') {
                _new_entry = jQuery('<input>').attr('type','checkbox').attr('name', _field.name+'_'+gf_rows+'_'+i).val(_val).attr('id','check_'+_id_new_field);
                _new_entry.attr('ref_to', _id_new_field);
                _new_label = jQuery('<label>').attr('for', 'check_'+_id_new_field).text(_field.label.text);
                _new_ul = jQuery('<ul>').addClass('gfield_checkbox');
                _new_li = jQuery('<li>');
                _new_ul.append(_new_li);
                _new_li.append(_new_entry);
                _new_li.append(_new_label);

                _div.append(_new_ul);

            } */
            else if(_field.type == 'multi-dates') {

                _div = generatedFieldMultiDates(i, _field, _id_new_field, values);
            }
            
            _li.addClass('gfrow'+gf_rows);
            if(typeof(_field.label) == 'object' && _field.type!='checkbox') {
                var _label = jQuery('<label class="'+_field.label.clases+'">').text(_field.label.text);
                _li.append(_label);
            }
            _li.append(_div);
            _li.insertAfter(gf_finish_object);
            //_li.insertBefore(gf_finish_object);
        }
        
        _li.before('<li class="separator gfrow'+gf_rows+'"></li>');
        _tbody = jQuery('.gf_multi_row_reference .gfield_list tbody');
        if(gf_rows == 1 && _this !== null) {
            jQuery(_this).parent().parent().hide();
        }
        
        _tbody.append('<tr class="gfield_list_row_even gfrow'+gf_rows+'">'+_new_row+'</tr>');
        gf_rows++;
        if( gf_rows-gf_removes > 0) {
            jQuery('.gf_actions').hide();
        }
        
        for(var pos in refresh) {
            jQuery('select[ref_to="'+refresh[pos]+'"]').trigger('change');
        }
        changeDropdownMonth('gfield_date_dropdown_month');
    }
}


function generatedFieldMultiDates(i,field,id_new_field,values) {
    var iconsHtml = '<td class="gfield_list_icons"><img src="{site_url}/wp-content/plugins/gravityforms/images/add.png" class="add_list_item" title="Add a row" alt="Add a row" onclick="gformAddListItem(this, 0)" style="cursor:pointer; margin:0 3px;"><img src="{site_url}/wp-content/plugins/gravityforms/images/remove.png" title="Remove this row" alt="Remove this row" class="delete_list_item" style="cursor:pointer; visibility:hidden;" onclick="gformDeleteListItem(this, 0)"></td>';

    iconsHtml = iconsHtml.replace(/{site_url}/g, window.location.origin);

    var tbl = jQuery('<table>').addClass('gfield_list');
    var tr = jQuery('<tr>');

    if(_field.selects.length > 0) {
        var val = '';
        var select, val_current, divsub_select, new_entry;
        for(var k = 0; k < field.selects.length; k++) {
            
            select = field.selects[k];
            
            if(values !== null) {
                val_current = values[id_new_field+'_'+select.type_date];
                    if(k === 0) {
                    val = val_current;
                } else {
                    val = val+''+field.separator+''+val_current;
                }
            } else {
                val_current = '';
            }
            divsub_select = jQuery('<td>').addClass('gfield_list_cell dropdown-date');
            
            new_entry = jQuery('<select onchange="change_date(this,\''+id_new_field+'\','+k+');">').attr('name', gf_rows+'_'+i+'_'+k+'_'+select.name);
            
            var centinela_selected = false;
            var obj_option, option;
            for(var pos in select.options) {
                obj_option = select.options[pos];
                option = jQuery('<option>').attr('value',obj_option.value).text(obj_option.text);
                
                if(obj_option.selected) {
                    option.attr('selected', 'selected');
                    centinela_selected = obj_option.value;
                }
                
                new_entry.append(option);
            }
            
            new_entry.attr('ref_to', id_new_field).attr('type_date',select.type_date).attr('row',gf_rows).addClass('multi-select').val(val_current);
            //new_entry.on('change',change_entry).bind('change', sm_change_dropdown);
            divsub_select.append(new_entry);
            
            if(centinela_selected) {
                new_entry.val(centinela_selected);
                refresh.push(id_new_field);
            }
            
            tr.append(divsub_select);
        }
        tr.append(iconsHtml);
    }
    tbl.html(tr);
    var div = jQuery('<div>').addClass('ginput_container multidates').html(tbl);
    return div;
}

function change_date(_this,ref,col) {
    var k = -1;
    var fdate = ['day','month','year','stime','etime'];
    var each_trs = function(idx,elem) {
        if(jQuery(elem)[0] == jQuery(_this).parent().parent()[0]) {
            k = idx;
        }
    };
    var getListRow = function() {
        jQuery(_this).parent().parent().parent().children().each(each_trs);
        return k;
    };
    sm_change_dropdown(_this,'smObj');

    var row = getListRow();
    var vlr = jQuery(_this);
    if(row !== -1) {
        var rf = jQuery('#'+ref);
        var json = jQuery.parseJSON(rf.val());

        if(json === null) {
            json = [];
            json[row] = { day: '', month: '', year: '', stime: '', etime: ''};
        } else if(!json[row]) {
            json[row] = { day: '', month: '', year: '', stime: '', etime: ''};
        }

        /*
            [
                { day: xx, month: xx, year: xxxx, stime: xxx, etime: xxx},
                { day: xx, month: xx, year: xxxx, stime: xxx, etime: xxx},
            ]
            
        */

        switch(col) {
            case 0://day
                json[row].day = vlr.val();
                break;
            case 1://month
                json[row].month = vlr.val();
                break;
            case 2://year
                json[row].year = vlr.val();
                break;
            case 3://start time
                json[row].stime = vlr.val();
                break;
            case 4://end time
                json[row].etime = vlr.val();
                break;
        }
        
        rf.val(json_encode(json));
    }
}
function getFormatDate() {
    var format = null;

    if(gf_format_date == 'mdy') {
        format = {
            p1: 'month',
            p2: '/',
            p3: 'day',
            p4: '/',
            p5: 'year'
        };
    } else if(gf_format_date == 'dmy') {
        format = {
            p1: 'day',
            p2: '/',
            p3: 'month',
            p4: '/',
            p5: 'year'
        };
    } else if(gf_format_date == 'ymd_dot') {
        format = {
            p1: 'year',
            p2: '.',
            p3: 'month',
            p4: '.',
            p5: 'day'
        };
    } else if(gf_format_date == 'dmy_dot') {
        format = {
            p1: 'day',
            p2: '.',
            p3: 'month',
            p4: '.',
            p5: 'year'
        };
    } else if(gf_format_date == 'ymd_slash') {
        format = {
            p1: 'year',
            p2: '/',
            p3: 'month',
            p4: '/',
            p5: 'day'
        };
    } else if(gf_format_date == 'ymd_dash') {
        format = {
            p1: 'year',
            p2: '-',
            p3: 'month',
            p4: '-',
            p5: 'day'
        };
    } else /*if(gf_format_date == 'dmy_dash')*/ {
        format = {
            p1: 'day',
            p2: '-',
            p3: 'month',
            p4: '-',
            p5: 'year'
        };
    }
    return format;
}
function add_multi_date(idx) {
    
    var format = getFormatDate();

    if(format === null) {
        return;
    }

    gf_multi_dates[idx]['row'+gf_rows] = format;

    if(gf_format_date == 'mdy') {
        gf_position_dates[idx]['row'+gf_rows] = {day: 3,month: 1,year: 5};
    } else if(gf_format_date == 'dmy') {
        gf_position_dates[idx]['row'+gf_rows] = {day: 1,month: 3,year: 5};
    } else if(gf_format_date == 'dmy_dash') {
        gf_position_dates[idx]['row'+gf_rows] = {day: 1,month: 3,year: 5};
    } else if(gf_format_date == 'dmy_dot') {
        gf_position_dates[idx]['row'+gf_rows] = {day: 1,month: 3,year: 5};
    } else if(gf_format_date == 'ymd_slash') {
        gf_position_dates[idx]['row'+gf_rows] = {day: 5,month: 3,year: 1};
    } else if(gf_format_date == 'ymd_dash') {
        gf_position_dates[idx]['row'+gf_rows] = {day: 5,month: 3,year: 1};
    } else if(gf_format_date == 'ymd_dot') {
        gf_position_dates[idx]['row'+gf_rows] = {day: 5,month: 3,year: 1};
    }
} 
function change_entry() {
    var _objCurrent = jQuery(this);
    
    var _val = _objCurrent.val();
    var _ref_to = _objCurrent.attr('ref_to');
    var idx = _objCurrent.attr('num_mselect');
    var _objRef = jQuery('#'+_ref_to);
    
    if(_objCurrent.hasClass('multi-select')) {
        var typeDate = _objCurrent.attr('type_date');
        
        var _row = _objCurrent.attr('row');
        
        var _pos = gf_position_dates[idx]['row'+_row][typeDate];
        
        gf_multi_dates['row'+_row]['p'+_pos] = _val;
        
        _objRef.val( gf_get_date(gf_multi_dates[idx]['row'+_row]) );
        
    } else {
        _objRef.val(_val);
    }
}


function gf_get_date(rowDate) {
    return ""+rowDate.p1+rowDate.p2+rowDate.p3+rowDate.p4+rowDate.p5;
}



/**
 * http://phpjs.org/functions/json_encode/
 *****/
function json_encode(e){var t,n=this.window.JSON;try{if(typeof n==="object"&&typeof n.stringify==="function"){t=n.stringify(e);if(t===undefined){throw new SyntaxError("json_encode")}return t}var r=e;var i=function(e){var t=/[\\\"\u0000-\u001f\u007f-\u009f\u00ad\u0600-\u0604\u070f\u17b4\u17b5\u200c-\u200f\u2028-\u202f\u2060-\u206f\ufeff\ufff0-\uffff]/g;var n={"\b":"\\b","   ":"\\t","\n":"\\n","\f":"\\f","\r":"\\r",'"':'\\"',"\\":"\\\\"};t.lastIndex=0;return t.test(e)?'"'+e.replace(t,function(e){var t=n[e];return typeof t==="string"?t:"\\u"+("0000"+e.charCodeAt(0).toString(16)).slice(-4)})+'"':'"'+e+'"'};var s=function(e,t){var n="";var r="    ";var o=0;var u="";var a="";var f=0;var l=n;var c=[];var h=t[e];if(h&&typeof h==="object"&&typeof h.toJSON==="function"){h=h.toJSON(e)}switch(typeof h){case"string":return i(h);case"number":return isFinite(h)?String(h):"null";case"boolean":case"null":return String(h);case"object":if(!h){return"null"}if(this.PHPJS_Resource&&h instanceof this.PHPJS_Resource||window.PHPJS_Resource&&h instanceof window.PHPJS_Resource){throw new SyntaxError("json_encode")}n+=r;c=[];if(Object.prototype.toString.apply(h)==="[object Array]"){f=h.length;for(o=0;o<f;o+=1){c[o]=s(o,h)||"null"}a=c.length===0?"[]":n?"[\n"+n+c.join(",\n"+n)+"\n"+l+"]":"["+c.join(",")+"]";n=l;return a}for(u in h){if(Object.hasOwnProperty.call(h,u)){a=s(u,h);if(a){c.push(i(u)+(n?": ":":")+a)}}}a=c.length===0?"{}":n?"{\n"+n+c.join(",\n"+n)+"\n"+l+"}":"{"+c.join(",")+"}";n=l;return a;case"undefined":case"function":default:throw new SyntaxError("json_encode")}};return s("",{"":r})}catch(o){if(!(o instanceof SyntaxError)){throw new Error("Unexpected error type in json_encode()")}this.php_js=this.php_js||{};this.php_js.last_error_json=4;return null}}
