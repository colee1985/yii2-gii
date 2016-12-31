# yii2-gii 扩展
==================================
安装：composer require colee/yii2-gii --prefer-dist



## Model分层说明
> common里分了三层   
> bases  ---  基础层  
> models ---  实例方法层  
> cores  ---  核心层，对外接口，静态方法为主  

### usage
在配置中添加  
``` php
$config['modules']['gii']['generators'] = [
    'model' => [
        'class' => 'colee\gii\model\Generator'
    ],
];
```
--------------------------------------------

## 夹具数据模版生产工具
### usage
在配置中添加  
``` php
$config['modules']['gii']['generators'] = [
    'fixtures' => [
        'class' => 'colee\gii\fixtures\Generator'
    ],
];
```
> 通过访问 http://127.0.0.1:8080/gii/fixtures 生成夹具模版   
> 并前往模版编写写测试用例  

生成假数据
```shell
tests/codeception/bin/yii fixture/generate teacher --count=100
```
运行测试用例:   
```shell
	cd tests/codeception/common/
	codecept run
```
运行指定目录的case 
```shell
codecept run .\unit\models\fixtures
```
运行指定文件的某个case  
```shell
codecept run .\unit\models\LoginFormTest.php:testLoginNoUser
```

