<?php


echo "<?php\n";
?>
namespace tests\codeception\common\unit\models;

use Yii;
use tests\codeception\common\unit\DbTestCase;
use Codeception\Specify;
use tests\codeception\common\fixtures\<?php echo $model->formName()?>Fixture;

/**
 * Login form test
 */
class <?php echo $model->formName()?>Test extends DbTestCase
{

    use Specify;
    /** DEMO
    public function setUp()
    {
        parent::setUp();

        Yii::configure(Yii::$app, [
            'components' => [
                'user' => [
                    'class' => 'yii\web\User',
                    'identityClass' => 'dbbase\models\system\SystemUser',
                ],
            ],
        ]);
    }

    protected function tearDown()
    {
        Yii::$app->user->logout();
        parent::tearDown();
    }

    public function testLoginNoUser()
    {
        $model = new LoginForm([
            'username' => 'not_existing_username',
            'password' => 'not_existing_password',
        ]);

        $this->specify('user should not be able to login, when there is no identity', function () use ($model) {
            expect('model should not login user', $model->login())->false();
            expect('user should not be logged in', Yii::$app->user->isGuest)->true();
        });
    }
    */

    /**
     * @inheritdoc
     */
    public function fixtures()
    {
        return [
            '<?php echo $model->formName()?>' => [
                'class' => <?php echo $model->formName()?>Fixture::className(),
                'dataFile' => '@tests/codeception/common/fixtures/data/<?=$schema->name?>.php'
            ],
        ];
    }

}
