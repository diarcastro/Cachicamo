var Utils = Utils || {};
Utils.messages = {};
var path = path || {};
Utils.getPath = function(alias,file){
  if(!file)file = '';
  switch(alias){
    case 'loaders':
      return path.loaders + file;
    case 'images':
    default:
      return path.images + file;
  }
};
Utils._ = function(category,message){
  try{
    var _md5 = hex_md5(message);
    if(Utils.messages[category]['t_' + _md5])
      return Utils.messages[category]['t_' + _md5];
    else return '';
  }catch(e){}
};
Utils.getExtension = function(file){
  if(!file)return false;
  var fileParts = file.split('.');
  return fileParts[fileParts.length - 1];
};
Utils.removeDiv=function(div,callback){
	$(div).css({
		'opacity':.5,
		'overflow':'hidden'
	});
	$(div).animate({
		height:0
	},200,function(){
		$(this).remove();
    if(callback) callback();
	});
};
/*
Utils.niceScroll=function(element,_class){
  _class=_class || 'nice-s';
  var scroll = $(element).niceScroll({
    cursorwidth:7,
    zindex:500,
//    cursorcolor:'#8FC73C',
    cursorborderradius:0,
    cursoropacitymin:0,
    railoffset:{left:-2}
  });
  $('#' + scroll.id).addClass(_class);
  return scroll;
};
 */
Utils.alert = function(msg){
  Alerta.show({
    title:Utils._('app','Information'),
    body:Html._('span',{
      html:msg
    }),
    btn1:{'class':'success'}
  });
};
Utils.showDistractor = function(type,center){
  type = type || 'bar';
  center = center || true;
  Alerta.show({
    title:Utils._('app','Loading information...'),
    body:Html.distractor({type:type,center:center}),
    btn1:{'class':' disabled'}
  });
};
Utils.hideDistractor = function(){
  Alerta.hide();
};

var Html = Html || {};
/**
 * Retorna un tag
 * @param tag (String) Etiqueta que desea crear
 * @param params (Object) Parametros de la etiqueta
 * @returns jQuery Object
 */
Html._ = function(tag,params){
  if(params && params.href && params.href == '#')params.href = 'javascript:;';
  return jQuery('<' + tag + ' />',params);
};
/**
 * Retorna la imagen del distractor
 * @param params (object) {type:Tipo de distractor(bar|circle), center: Centra el distractor en una capa}
 * @returns jQuery Object
 */
Html.distractor = function(params){
  var params = params || {type:'bar',center:false,alt:'loading...'};

  if(!params.type)params.type = 'bar';
  params.src = Utils.getPath('loaders','preloader-' + params.type + '.gif');

  var img = Html._('img',params);
  if(params.center)return Html._('div',{'class':'align-center'}).append(img);
  return img;
};
Html.clear = function(){
  return Html._('div',{
    'class':'clr'
  });
};
Html.icon = function(icon){
  icon = icon || '';
  return Html._('span',{'class':'glyphicon glyphicon-' + icon});
};
/**
 * Crea un select
 * @param {object} htmlOptions
 * @returns {jQueryObject}
 */
Html.makeSelect = function(htmlOptions){
  var data = htmlOptions.data || {},
  empty = htmlOptions.empty || false,
//  empty = htmlOptions.empty || {value:'',text:'Seleccione'},
  itemDelete = ['data','empty'];
  for(var i = 0,l = itemDelete.length; i < l; i++)
    delete htmlOptions[itemDelete[i]];

  function makeOptions(container,data){
    for(value in data){
      var text = data[value];
      if(typeof text == 'object'){
        var optGroup = Html._('optgroup',{label:value});
        optGroup = makeOptions(optGroup,text);
        container.append(optGroup);
      }else {
        container.append(Html._('option',{text:text,value:value}));
      }
    }
    return container;
  }

  var select = Html._('select',htmlOptions);
  if(empty)select.append(Html._('option',empty));
  return makeOptions(select,data);
};

