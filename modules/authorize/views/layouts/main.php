<?php
use yii\helpers\Html;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?php echo Yii::$app->language ?>" id="extr-page">
<head>
    <meta charset="<?php echo Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title><?php echo Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <?php echo Html::jsFile('@web/js/vue.min.js'); ?>
    <?php echo Html::jsFile('@web/js/axios.min.js'); ?>
</head>
<body class="animated fadeInDown">
<?php $this->beginBody() ?>

<?php echo isset($content) ? $content : ''; ?>

<?php $this->endBody() ?>

</body>
</html>
<?php $this->endPage() ?>