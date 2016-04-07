# yii2-gii 扩展
---

## 夹具数据模版生产工具
### usage
``` php
$config['modules']['gii']['generators'] = [
    'fixtures' => [
        'class' => 'colee\gii\fixtures\Generator'
    ],
];
```
运行示例:   
```shell
	tests/codeception/bin/yii fixture/generate teacher --count=100
	cd tests/codeception/common/
	codecept run
```

## Model分层生成
> common里分了三层   
> bases  ---  基础层  
> models ---  实例方法层  
> cores  ---  核心层，对外接口，静态方法为主  
### usage
``` php
$config['modules']['gii']['generators'] = [
    'model' => [
        'class' => 'colee\gii\model\Generator'
    ],
];
```