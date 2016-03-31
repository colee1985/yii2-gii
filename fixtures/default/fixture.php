<?php
/**
 * This is the template for generating the fixture template of a specified table.
 */

echo "<?php\n";
?>

namespace tests\codeception\common\fixtures;

use yii\test\ActiveFixture;

/**
 * <?php echo $model->formName()?> fixture
 */
class <?php echo $model->formName()?>Fixture extends ActiveFixture
{
    public $modelClass = '<?php echo $model::className()?>';
}
