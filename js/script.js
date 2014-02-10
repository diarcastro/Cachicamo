;
jQuery(function($){
  remakeChosen();
  remakeTips();
  $('ul li:first-child').addClass('first');
  $('ul li:last-child').addClass('last');
  preventChosenSubmit();
  
  $('.noEnterSubmit').keypress(function(e){
    if(e.which == 13)e.preventDefault();
  });
});
function remakeTips($selector,$params){
  if(isTouchDevice())return;
  $params = $params || {};
  $params = $.extend({
    width:'100%'
  },$params);
  $selector = $selector || '.has-tip';
  try{
    $($selector).tooltip($params);
  }catch(e){}
}
function remakeChosen($selector,$params){
  if(isTouchDevice()) return;
  $params = $params || {};
  $params = $.extend({
    width:'100%',
    disable_search_threshold:7
  },$params);
  $selector = $selector || 'select.chosen';
  $('select[class^="chosen-color"], select[class*=" chosen-color"]').on('chosen:ready',function(){
    var select = $(this);
    var cls = this.className.replace(/^.(chosen-color[a-z0-9-_]*)$.*/,'\1');
    var container = select.next('.chosen-container').find('.chosen-single');
    container.addClass(cls).attr('rel','value_' + select.val());
    select.on('change click',function(){
      container.attr('rel','value_' + select.val());
    });

  });
  try{
    $($selector).chosen($params);
  }catch(e){}
}
/*function afterValidate(form,data,hasError){
  if(hasError){
    $.noty.closeAll();
    for(var x in data){
      generateStick(data[x][0]);
    }
    return false;
  }else return true;
}
function afterValidateAttr(form,attribute,data,hasError){
  if(hasError){
    for(var x in data){
      generateStick(data[x][0]);
    }
    return false;
  }else return true;
}
function generateStick(text,type){
  var type = type || 'error';
  var options = {text:text,type:type};
  newStick(options);
}
function newStick(options){
  return noty($.extend({
    type:'error',
    dismissQueue:true,
    modal:false,
    maxVisible:false,
    timeout:5000,
    layout:'bottomRight',
    theme:'defaultTheme'
  },options));
}*/
function formRealReset(_form){
  $(_form).find('input').each(function(){
    switch(this.type){
      case 'password':
      case 'text':
      case 'hidden':
        $(this).val('');
        break;
      case 'checkbox':
      case 'radio':
        this.checked = false;
    }
  });
  $(_form).find('select').each(function(){
    $("#" + this.id + " option[value='']").attr("selected",true);
  });
  $(_form).find('textarea').each(function(){
    $(this).val('');
  });
}
/**
 * Evita que los input de los chosen hagan submit
 * @returns void
 */
function preventChosenSubmit(){
  $('body').on('keydown','.chosen-search input',function(e){
    if(e.which == 13){
      e.preventDefault();
      e.stopPropagation();
    }
  });
}
/*--Emular indexOf--*/
if(!Array.prototype.indexOf){
  Array.prototype.indexOf = function(searchElement,fromIndex){
    var i,
    pivot = (fromIndex) ? fromIndex : 0,
    length;
    if(!this){
      throw new TypeError();
    }
    length = this.length;
    if(length === 0 || pivot >= length){
      return -1;
    }
    if(pivot < 0){
      pivot = length - Math.abs(pivot);
    }
    for(i = pivot; i < length; i++){
      if(this[i] === searchElement){
        return i;
      }
    }
    return -1;
  };
}
function isTouchDevice(){
  return"ontouchstart" in window || "onmsgesturechange" in window;
}