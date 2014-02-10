<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
  'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
  'name'=>Yii::t('app','World Cup Brasil 2014'),
  // preloading 'log' component
  'preload'=>array('log'),
//  'theme'=>'default',
  'sourceLanguage'=>'en',
  'language'=>'es',
//  'language'=>'en_us',
//  'sourceLocale'=>'es_co',
  'localeDataPath'=>'protected/messages/data',
  // autoloading model and component classes
  'import'=>array(
    'application.models.*',
    'application.components.*',
    'application.components.helpers.*',
  ),
  'modules'=>array(
    // uncomment the following to enable the Gii tool

    'gii'=>array(
      'class'=>'system.gii.GiiModule',
      'password'=>'<password>',
      // If removed, Gii defaults to localhost only. Edit carefully to taste.
      'ipFilters'=>array('127.0.0.1','::1'),
    ),
  ),
  // application components
  'components'=>array(
    'coreMessages'=>array(
      'basePath'=>'protected/messages/',
    ),
    'cache'=>array(
      'class'=>'CFileCache',
    ),
    'clientScript'=>array(
      'packages'=>array(
//        'scriptMap'=>array(
//          'jquery.js'=>'//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js',
//        ),
        'jquery'=>array(
          'baseUrl'=>YII_DEBUG?'js/':'//ajax.googleapis.com/ajax/libs/jquery/2.1.0/',
          'js'=>array('jquery'.(YII_DEBUG?'':'.min').'.js'),
        ),
//        'jqueryui'=>array(
//          'baseUrl'=>'js/',
//          'js'=>array('jquery-ui-1.10.3.custom.min.js'),
//          'depends'=>array('jquery')
//        ),
        'angularjs'=>array(
//          'baseUrl'=>'//ajax.googleapis.com/ajax/libs/angularjs/1.2.3/',
          'baseUrl'=>YII_DEBUG?'js/':'//ajax.googleapis.com/ajax/libs/angularjs/1.2.12/',
          'js'=>array(
            'ajngularjs'=>'angular'.(YII_DEBUG ? '.js' : '.min.js'),
          ),
          'depends'=>array('jquery')
        ),
        'bootstrap'=>array(
          'baseUrl'=>'js/bootstrap/',
          'js'=>array(
            'bootstrap.js'=>'js/bootstrap'.(YII_DEBUG ? '.js' : '.min.js'),
          ),
          'css'=>array(
            'bootstrap.css'=>'css/bootstrap'.(YII_DEBUG ? '.css' : '.min.css'),
            'theme.css'=>'css/bootstrap-theme'.(YII_DEBUG ? '.css' : '.min.css'),
          ),
          'depends'=>array('jquery')
        ),
        'chosen'=>array(
          'baseUrl'=>'js/chosen/',
          'js'=>array(
            'chosen.js'=>'chosen.jquery'.(YII_DEBUG ? '.js' : '.min.js'),
          ),
          'css'=>array(
            'chosen.css'=>'chosen'.(YII_DEBUG ? '.css' : '.min.css'),
          ),
          'depends'=>array('jquery')
        ),
        'plupload'=>array(
          'baseUrl'=>'js/plupload/js/',
          'js'=>array(
            'plupload.full.min.js',
          ),
        ),
      ),
    ),
    'purifier'=>array(
      'class'=>'Purifier',
    ),
    'browser'=>array(
      'class'=>'Browser',
    ),
    'user'=>array(
      // enable cookie-based authentication
      'class'=>'DWebUser',
      'allowAutoLogin'=>true,
      'loginRequiredAjaxResponse'=>'YII_LOGIN_REQUIRED',
      'returnUrl'=>'home',
    ),
    // uncomment the following to enable URLs in path-format
    'urlManager'=>array(
      'urlFormat'=>'path',
      'showScriptName'=>false,
      'caseSensitive'=>false,
      'rules'=>array(
        ''=>'site/login',
        '<controller:\w+>/<id:\d+>'=>'<controller>/view',
        '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
        '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
        '<module:\w+>/<controller:\w+>/<action:\w+>'=>'<module>/<controller>/<action>',//Corrige error en los ajax de cgridview cuando se hace pagination
        '<module:\w+>/<controller:\w+>/<action:\w+>/<id:\d+>'=>'<module>/<controller>/<action>',//Corrige error en los ajax de cgridview cuando se hace pagination
      ),
    ),
//    'db'=>array(
//      'connectionString'=>'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
//    ),
    // uncomment the following to use a MySQL database
    'db'=>array(
      'connectionString'=>'mysql:host=<host>;dbname=<db>',
      'emulatePrepare'=>true,
      'username'=>'<username>',
      'password'=>'<password>',
      'tablePrefix'=>'<tablePrefix>',
      'charset'=>'utf8',
    ),
    'authManager'=>array(
      'class'=>'CDbAuthManager',
      'connectionID'=>'db',
      'itemTable'=>'{{users_auth_item}}',
      'itemChildTable'=>'{{users_auth_item_child}}',
      'assignmentTable'=>'{{users_auth_assignment}}',
    ),
    'errorHandler'=>array(
      // use 'site/error' action to display errors
      'errorAction'=>'site/error',
    ),
    'log'=>array(
      'class'=>'CLogRouter',
      'routes'=>array(
        array(
          'class'=>'CWebLogRoute',
          'levels'=>'error,warning,trace,profile',
          'enabled'=>false,
//          'categories'=>'system.db.*, application.*',
        ),
      // uncomment the following to show log messages on web pages
      /*
        array(
        'class'=>'CWebLogRoute',
        ),
       */
      ),
    ),
    'widgetFactory'=>array(
      'widgets'=>array(
        'CGridView'=>array(
          'cssFile'=>false,
          'pagerCssClass'=>'pagination-container align-right',
          'pager'=>array(
            'cssFile'=>false,
            'selectedPageCssClass'=>'active',
            'prevPageLabel'=>'«',
            'nextPageLabel'=>'»',
            'firstPageLabel'=>'««',
            'lastPageLabel'=>'»»',
            'hiddenPageCssClass'=>'disabled',
            'header'=>'',
            'footer'=>'',
            'htmlOptions'=>array(
              'class'=>'pagination'
            ),
          ),
          'itemsCssClass'=>'table table-bordered table-striped table-hover table-condensed',
        ),
        'CListView'=>array(
          'cssFile'=>false,
          'pager'=>array('cssFile'=>false),
          'pagerCssClass'=>'pagination',
        ),
        'CDetailView'=>array(
          'cssFile'=>false,
          'htmlOptions'=>array('class'=>'table table-bordered table-striped table-hover table-condensed'),
        ),
      /*
        'CLinkPager' =>array(
        ),
       */
      )
    ),
  ),
  // application-level parameters that can be accessed
  // using Yii::app()->params['paramName']
  'params'=>array(
    // this is used in contact page
    'adminEmail'=>'<email>',
  ),
);
