<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Person */

$this->title = 'New Contact';
$this->params['breadcrumbs'][] = ['label' => 'contacts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="person-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelsPhoneNumber' => $modelsPhoneNumber,
    ]) ?>

</div>
