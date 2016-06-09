<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Tipoproducto */

$this->title = 'Detalle Tipo Producto';
$this->params['breadcrumbs'][] = ['label' => 'Tipoproductos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipoproducto-view">

    <h1><?= Html::encode($this->title) ?></h1>

    

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
           // 'idtipo_producto',
            'descripcion',
        ],
    ]) ?>

</div>
