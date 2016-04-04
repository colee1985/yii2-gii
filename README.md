
### usage
``` php
$config['modules']['gii']['generators'] = [
        'fixtures' => [
            'class' => 'colee\gii\fixtures\Generator'
        ],
    ];
```
> 运行示例:
	tests/codeception/bin/yii fixture/generate teacher --count=100
	cd tests/codeception/common/
	codecept run