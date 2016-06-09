<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Cotizacion */

$this->title = 'Detalle Cotizacion';
$this->params['breadcrumbs'][] = ['label' => 'Cotizacions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cotizacion-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
       
        <?= Html::a('Exportar', ['exportar', 'id' => $model->idcotizacion], ['class' => 'btn btn-info']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'idcotizacion',
            //'fk_usuario',
            'nombre',
            'apellido',
            'ruc',
            'direccion',
            'fecha',
            'descuento',
            'total',
            
        ],
    ]) ?>

</div>
