;
(function($,window,undefined){
  $.fn.Alerta = function(opt){
    var data = null;
    var defaults = {
      id:'alerta' + new Date().getTime()
    };
    opt = $.extend(defaults,opt);
    var alertTop = 150;
    var alerta = Html._('div',{id:opt.id,'class':'Alerta'}),
    $this = alerta,
      title = Html._('h2',{'class':'title'}),
    body = Html._('div',{'class':'b'}),
    footer = Html._('div',{'class':'f'}),
    btn1 = $('<input type="button" class="btn-b left5" value="' + Utils._('app','Ok') + '" />'),
      btn2 = $('<input type="button" class="btn btn-primary" value="' + Utils._('app','Cancel') + '" />'),
      velo = Html._('div',{id:'AVelo_' + opt.id,'class':'AVelo'}),
    timeOut = 0,
      isMake = false;
    function makeAlert(){
      var cf = Html._('div',{'class':'cf'})
        .append(btn2).append(btn1);
      btn1.hide()
        .on('click',function(){
          $this.trigger('close',[true,data]);
          $this.hide();
        });
      btn2.hide()
        .on('click',function(){
          $this.trigger('close',[false,data]);
          $this.hide();
        });
      footer.append(cf);
      alerta.append(title)
        .append(body)
        .append(footer);
      $('body').append(alerta);
      $('body').append(velo);
      velo.hide();
      alerta.hide();
      isMake = true;
    }
    $this.show = function(params){
      if(!params)
        params = {};
      if(!isMake)
        makeAlert();
      $this.setTitle(params.title ? params.title : Utils._('app','Information'));
      var _body = params.body ? params.body : '';
      $this.setBody(_body,typeof _body == 'object' ? 1 : 0);

      $this.set(params);
      onShow(params);
      clearTimeout(timeOut);
      if(params.autoClose)
        timeOut = setTimeout($this.hide,params.autoClose * 1000);

      return $this;
    };
    function onShow($params){
      alerta.css({
        top:alertTop + $(window).scrollTop(),
        left:$(window).width() * .5 - alerta.width() * .5
      });
      var overlay = $params.overlay != undefined ? $params.overlay : true;
      if(overlay)
        velo.stop().fadeTo(200,.7);
      alerta.stop().fadeTo(200,1);
    }
    $this.setBody = function(_body,html){
      body.empty();
      if(html == undefined)
        html = false;
      if(!html)
        body.text(_body);
      else if(typeof _body == 'object')
        body.append(_body);
      else
        body.html(_body);
      return $this;
    };
    $this.setTitle = function(_title,html){
      if(html == undefined)
        html = false;
      if(!html)
        title.text(_title);
      else
        title.html(_title);
      return $this;
    };
    function resetButtons(){
      btn1.removeAttr('class')
        .addClass('btn btn-primary left5 btn-sm btn-')
        .removeAttr('disabled');
      btn2.removeAttr('class')
        .addClass('btn btn-sm btn-primary btn-')
        .removeAttr('disabled');
    }
    $this.getButton = function(button){
      switch(button){
        case 'btn2':
          return btn2;
          break;
        case 'btn1':
        default:
          return btn1;
          break;
      }
    };
    $this.set = function(params){
      data = null;
      if(params.data)
        data = params.data;
      resetButtons();
      if(params.disabled){
        if(params['class'])
          params['class'] += 'disabled';
        else
          params['class'] = 'disabled';
      }
      ;
      if(params.btn1 && params.btn1['class'])
        params.btn1['class'] = 'btn btn-sm left5 btn-primary btn-' + params.btn1['class'];
      var btnText = Utils._('app','Ok');
      if(params.btn1){
        btn1.attr(params.btn1);
        btnText = params.btn1.text ? params.btn1.text : btnText;
      }
      btn1.val(btnText);
      btn1.show();
      if(params.btn2){
        if(params.btn2['class'])
          params.btn2['class'] = 'btn btn-sm btn-primary btn-' + params.btn2['class'];
        btn2.val(params.btn2.text ? params.btn2.text : Utils._('app','Cancel'));
        btn2.attr(params.btn2);
        btn2.show();
      }else
        btn2.hide();
      return $this;
    };
    /**
     * Oculta la Alerta
     * 
     * @param destroy Elimina la alerta despues de ocultarla
     * @return AlertaObject El objeto de alerta actual
     * @access public
     */
    $this.hide = function(destroy){
      velo.stop().fadeOut(100);
      alerta.stop().fadeOut(100,function(){
        $this.trigger('hide',[$this]);
        if(destroy)
          $this.destroy();
      });
      return $this;
    };
    /**
     * Elimina el AlertaObject
     * @return void
     * @public void
     */
    $this.destroy = function(){
      alerta.remove();
      velo.remove();
    };
    return $this;
  };

})(jQuery,window);
var Alerta;
jQuery(function($){
  Alerta = $('body').Alerta();
});
