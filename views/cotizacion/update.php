<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Cotizacion */

$this->title = 'Update Cotizacion: ' . $model->idcotizacion;
$this->params['breadcrumbs'][] = ['label' => 'Cotizacions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idcotizacion, 'url' => ['view', 'id' => $model->idcotizacion]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="cotizacion-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
