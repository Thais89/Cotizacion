<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Cotizacion */

$this->title = 'Registrar Cotizacion';
$this->params['breadcrumbs'][] = ['label' => 'Cotizacions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cotizacion-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelsCotizacionitems' => $modelsCotizacionitems,
    ]) ?>

</div>
