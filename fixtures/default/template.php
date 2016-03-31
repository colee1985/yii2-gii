<?php
/**
 * This is the template for generating the fixture template of a specified table.
 */
// var_dump($schema);exit;
echo "<?php\n";
?>
/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */

 $security = Yii::$app->getSecurity();

return [
    <?php foreach ($schema->columns as $name=>$column){if($column!='id'){?>
    '<?php echo $name?>' => <?php echo $generator->getFormatter($column);?>,
    <?php }}?>
];