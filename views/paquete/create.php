<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Paquete */

$this->title = 'Registrar Paquete';
$this->params['breadcrumbs'][] = ['label' => 'Paquetes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="paquete-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
         'modelsProductoHasPaquete'=>$modelsProductoHasPaquete,
    ]) ?>

</div>
