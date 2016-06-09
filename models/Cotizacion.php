<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cotizacion".
 *
 * @property string $idcotizacion
 * @property string $fk_usuario
 * @property string $nombre
 * @property string $apellido
 * @property string $ruc
 * @property string $direccion
 * @property string $fecha
 * @property double $total
 * @property double $descuento
 *
 * @property Usuario $fkUsuario
 * @property CotizacionHasPaquete[] $cotizacionHasPaquetes
 * @property Paquete[] $fkPaquetes
 */
class Cotizacion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cotizacion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fk_usuario'], 'required'],
            [['fk_usuario'], 'integer'],
            [['fecha'], 'safe'],
            [['total', 'descuento'], 'number'],
            [['descuento'], 'required'],
            [['nombre', 'apellido'], 'string', 'max' => 100],
            [['nombre', 'apellido'], 'required'],
            [['ruc'], 'string', 'max' => 30],
            [['direccion'], 'required'],
             [['ruc'], 'required'],
            [['direccion'], 'string', 'max' => 200],
            [['fk_usuario'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['fk_usuario' => 'idusuario']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idcotizacion' => 'Cotizacion',
            'fk_usuario' => 'Usuario',
            'nombre' => 'Nombre',
            'apellido' => 'Apellido',
            'ruc' => 'Ruc',
            'direccion' => 'Direccion',
            'fecha' => 'Fecha',
            'total' => 'Total',
            'descuento' => 'Descuento(%)',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkUsuario()
    {
        return $this->hasOne(Usuario::className(), ['idusuario' => 'fk_usuario']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCotizacionHasPaquetes()
    {
        return $this->hasMany(CotizacionHasPaquete::className(), ['fkCotizacion' => 'idcotizacion']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkPaquetes()
    {
        return $this->hasMany(Paquete::className(), ['codigo' => 'fkPaquete'])->viaTable('cotizacion_has_paquete', ['fkCotizacion' => 'idcotizacion']);
    }
}
