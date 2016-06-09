<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Tipoproducto */

$this->title = 'Update Tipoproducto: ' . $model->idtipo_producto;
$this->params['breadcrumbs'][] = ['label' => 'Tipoproductos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idtipo_producto, 'url' => ['view', 'id' => $model->idtipo_producto]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tipoproducto-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
