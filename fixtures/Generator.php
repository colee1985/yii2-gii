<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace colee\gii\fixtures;

use Yii;
use yii\base\Model;
use yii\gii\CodeFile;

/**
 * This generator will generate one or multiple ActiveRecord classes for the specified database table.
 *
 * @author CoLee <5969226@qq.com>
 * @since 2.0
 */
class Generator extends \yii\gii\Generator
{
    public $modelClass;
    public $viewPath = '@tests/codeception/common/templates/fixtures';
    public $viewName;
    
    
    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'Fixtures Generator';
    }

    /**
     * @inheritdoc
     */
    public function getDescription()
    {
        return '这是一个根据YII Model 生成夹具测试模板的脚手架。';
    }
    
    /**
     * @inheritdoc
     */
    public function generate()
    {
        $schema = $this->getModel()->getTableSchema();
        
        $files = [];
        $files[] = new CodeFile(
            Yii::getAlias($this->viewPath) . '/' . $schema->name . '.php',
            $this->render('template.php',[
                'model'=>$this->getModel(),
                'schema'=>$schema,
            ])
        );
        $files[] = new CodeFile(
            str_replace('/templates', '', Yii::getAlias($this->viewPath)) . '/' . $this->getModel()->formName() . 'Fixture.php',
            $this->render('fixture.php',[
                'model'=>$this->getModel(),
            ])
        );
        $files[] = new CodeFile(
            str_replace('/templates', '/unit/models', Yii::getAlias($this->viewPath)) . '/' . $this->getModel()->formName() . 'Test.php',
            $this->render('test.php',[
                'model'=>$this->getModel(),
                'schema'=>$schema,

                'dir'=>'models',
            ])
        );
        $files[] = new CodeFile(
            str_replace('/templates', '/unit/cores', Yii::getAlias($this->viewPath)) . '/' . $this->getModel()->formName() . 'Test.php',
            $this->render('test.php',[
                'model'=>$this->getModel(),
                'schema'=>$schema,
                'dir'=>'cores',
            ])
        );
    
        return $files;
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['modelClass', 'viewPath'], 'filter', 'filter' => 'trim'],
            [['modelClass', 'viewPath'], 'required'],
            [['modelClass'], 'match', 'pattern' => '/^[\w\\\\]*$/', 'message' => 'Only word characters and backslashes are allowed.'],
            [['modelClass'], 'validateClass', 'params' => ['extends' => Model::className()]],
            [['viewPath'], 'match', 'pattern' => '/^@?\w+[\\-\\/\w]*$/', 'message' => 'Only word characters, dashes, slashes and @ are allowed.'],
            [['viewPath'], 'validateViewPath'],
            [['enableI18N'], 'boolean'],
        ]);
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'modelClass' => 'Model Class',
            'viewName' => 'View Name',
            'viewPath' => 'Fixture Templates Path',
        ]);
    }
    
    /**
     * @inheritdoc
     */
    public function requiredTemplates()
    {
        return ['fixture.php'];
    }
    
    /**
     * @inheritdoc
     */
    public function stickyAttributes()
    {
        return array_merge(parent::stickyAttributes(), ['viewPath']);
    }
    
    /**
     * @inheritdoc
     */
    public function hints()
    {
        return array_merge(parent::hints(), [
            'modelClass' => 'This is the model class for collecting the form input. You should provide a fully qualified class name, e.g., <code>app\models\Post</code>.',
            'viewName' => 'This is the view name with respect to the view path. For example, <code>site/index</code> would generate a <code>site/index.php</code> view file under the view path.',
            'viewPath' => 'This is the root view path to keep the generated view files. You may provide either a directory or a path alias, e.g., <code>@app/views</code>.',
        ]);
    }
    
    /**
     * @inheritdoc
     */
    public function successMessage()
    {
        $code = highlight_string($this->render('action.php'), true);
    
        return <<<EOD
<p>The form has been generated successfully.</p>
<p>You may add the following code in an appropriate controller class to invoke the view:</p>
<pre>$code</pre>
EOD;
    }
    
    /**
     * Validates [[viewPath]] to make sure it is a valid path or path alias and exists.
     */
    public function validateViewPath()
    {
        $path = Yii::getAlias($this->viewPath, false);

        if ($path === false || !is_dir($path)) {
            $this->addError('viewPath', 'fixture template path does not exist.');
        }
    }
    /**
     * 获取Model
     */
    public function getModel()
    {
        $model = new $this->modelClass();
        
        return $model;
    }
    
    /**
     * 字段换取Faker格式类型
     * @param unknown $column
     */
    public function getFormatter($column)
    {
        $time_fields = ['created_at','create_time','updated_at', 'update_time'];
        if ($column->name=='email'){
            return '$faker->email';
        }elseif (in_array($column->name, $time_fields)){
            return 'time()';
        }elseif (in_array($column->name, ['auth_key'])){
            return '$security->generateRandomString()';
        }elseif (in_array($column->name, ['password_hash', 'password_reset_token'])){
            return '$security->generatePasswordHash(111111)';
        }elseif (in_array($column->type, ['string'])){
            return '$faker->text($maxNbChars = '.$column->size.')';
        }elseif (in_array($column->type, ['integer'])){
            return '$faker->buildingNumber()';
        }else{
            return '""';
        }
    }
}
