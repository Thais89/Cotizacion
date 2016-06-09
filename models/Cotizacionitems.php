<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cotizacionitems".
 *
 * @property string $idItem
 * @property string $paquete_codigo
 * @property string $fkCotizacion
 * @property string $cantidad
 * @property double $monto
 *
 * @property Paquete $paqueteCodigo
 * @property Cotizacion $fkCotizacion0
 */
class Cotizacionitems extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cotizacionitems';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['paquete_codigo', 'fkCotizacion', 'cantidad'], 'integer'],
            [['fkCotizacion'], 'required'],
            [['monto'], 'number'],
            [['paquete_codigo'], 'exist', 'skipOnError' => true, 'targetClass' => Paquete::className(), 'targetAttribute' => ['paquete_codigo' => 'codigo']],
            [['fkCotizacion'], 'exist', 'skipOnError' => true, 'targetClass' => Cotizacion::className(), 'targetAttribute' => ['fkCotizacion' => 'idcotizacion']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idItem' => 'Id Item',
            'paquete_codigo' => 'Paquete Codigo',
            'fkCotizacion' => 'Fk Cotizacion',
            'cantidad' => 'Cantidad',
            'monto' => 'Monto',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPaqueteCodigo()
    {
        return $this->hasOne(Paquete::className(), ['codigo' => 'paquete_codigo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkCotizacion0()
    {
        return $this->hasOne(Cotizacion::className(), ['idcotizacion' => 'fkCotizacion']);
    }
}
