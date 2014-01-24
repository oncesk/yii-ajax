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

##Usage

If you ***not add***  extension ***in preload section***, you can initializa it manually!<br>
Example with base controller:

```php

public function init() {
  Yii::app()->getComponent('yiiAjax');
}

```

