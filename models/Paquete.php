<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "paquete".
 *
 * @property string $codigo
 * @property string $nombre
 * @property string $cantidad
 * @property double $monto
 * @property double $descuento
 *
 * @property CotizacionHasPaquete[] $cotizacionHasPaquetes
 * @property Cotizacion[] $fkCotizacions
 * @property ProductoHasPaquete[] $productoHasPaquetes
 * @property Producto[] $productoCodigos
 */
class Paquete extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'paquete';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cantidad'], 'integer'],
            [['monto', 'descuento'], 'number'],
            [['nombre'], 'string', 'max' => 100],
             [['cantidad'], 'required'],
            [['descuento'], 'required'],
            [['nombre'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'codigo' => 'Codigo',
            'nombre' => 'Nombre',
            'cantidad' => 'Cantidad',
            'monto' => 'Monto',
            'descuento' => 'Descuento(%)',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCotizacionHasPaquetes()
    {
        return $this->hasMany(CotizacionHasPaquete::className(), ['fkPaquete' => 'codigo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkCotizacions()
    {
        return $this->hasMany(Cotizacion::className(), ['idcotizacion' => 'fkCotizacion'])->viaTable('cotizacion_has_paquete', ['fkPaquete' => 'codigo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductoHasPaquetes()
    {
        return $this->hasMany(ProductoHasPaquete::className(), ['paquete_codigo' => 'codigo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductoCodigos()
    {
        return $this->hasMany(Producto::className(), ['codigo' => 'producto_codigo'])->viaTable('producto_has_paquete', ['paquete_codigo' => 'codigo']);
    }
}
