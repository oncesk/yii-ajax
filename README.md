yii-ajax
========

##Installation

 - using git: go to the ***application.ext*** directory and clone project<bR>

```bash
$> git clone https://github.com/oncesk/yii-ajax.git
```
 - using archive: download archive and unpack it into ***application.ext*** directory

##Yii configuration

Set as a component


```php

return array(
  ...
  
  'components' => array(
  
    ...
    
    'yiiAjax' => array(
      'class' => 'ext.yii-ajax.YiiAjax'
    )
    
    ...
    
  )
  
);

```

You can add extension into ***preload*** components in your ***config/main.php*** config file for auto initialization

```php

return array(

  'preload' => array(
    'yiiAjax'
  )
  
);

```

##Javascript

In javascript use YiiAjax object

####Bind event

js:

```javascript
YiiAjax.on('error', function (errorObject) {
 // will be called when server send error event
 console.log(errorObject);
});
```

php:

```php
public function actionTest() {
 $this->_test1();
 $this->_test2();
 
 Yii::app()->end();
}

protected function _test1() {
 new AjaxEvent('error', array(
   'message' => 'You can not run this test'
 ));
}

protected function _test2() {
 new AjaxEvent('error', array(
   'message' => 'Internal server error'
 ));
}

```

####Use YiiAjax.ajax

YiiAjax.ajax method proxying success and done callbacks for reformat server response

js:

```javascript

YiiAjax.ajax({
 url : '/test',
 dataType : 'json',
 success : function (response) {
   console.log(response); // object {success : 0, reason : 'Some reason'}
 }
});

YiiAjax.on('error', function (errorObject) {
 // will be called when server send error event
 console.log(errorObject);
});

```

php:

```php

public function actionTest() {
 $this->_test1();
 $this->_test2();
 
 $response = YiiAjax::getResponse();
 $response['success'] = false;
 $response['reason'] = 'Some reason';
 
 Yii::app()->end();
}

protected function _test1() {
 new AjaxEvent('error', array(
   'message' => 'You can not run this test'
 ));
}

protected function _test2() {
 new AjaxEvent('error', array(
   'message' => 'Internal server error'
 ));
}

```


##PHP

If you ***not add***  extension ***in preload section***, you can initializa it manually!<br>
Example:

```php

public function actionIndex() {
  Yii::app()->getComponent('yiiAjax');
  
  ...
}

```

####Global response object

if request is ajax request you can use YiiAjax::getResponse() everywhere in you project

PHP:

```php

public function actionTest() {
  $this->test1();
  $this->test2();
  Yii::app()->end();
}

protected function test1() {
  $response = YiiAjax::getResponse();
  $response['test1'] = 'success';
}

protected function test2() {
  $response = YiiAjax::getResponse();
  $response['test2'] = 'success';
}

```

Javascript:

```javascript

YiiAjax.ajax({
 url : '/test',
 dataType : 'json',
 success : function (response) {
   console.log(response.test1);
   console.log(response.test2);
   console.log(response);
 }
});

```

