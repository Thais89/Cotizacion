<?php

namespace app\controllers;

use Yii;
use app\models\Cotizacion;
use app\models\Cotizacionitems;
use app\models\CotizacionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Paquete;
use app\models\ModelCotizacion;
use app\models\CotizacionHasPaquete;

/**
 * CotizacionController implements the CRUD actions for Cotizacion model.
 */
class CotizacionController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Cotizacion models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CotizacionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Cotizacion model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Cotizacion model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
   public function actionCreate()
    {
        $model = new Cotizacion();
        $modelsCotizacionitems = [new CotizacionHasPaquete];
        $model->fecha=date('Y-m-d');
        $model->fk_usuario=Yii::$app->user->identity->id;

        if ($model->load(Yii::$app->request->post())) {

                $modelsCotizacionitems  = ModelCotizacion::createMultiple(CotizacionHasPaquete::classname());
            ModelCotizacion::loadMultiple($modelsCotizacionitems , Yii::$app->request->post());

            // validate all models
            $valid = $model->validate();
            //$valid = Model::validateMultiple($modelsCotizacionitems ) && $valid;
            $subtotal1=0;
            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        foreach ($modelsCotizacionitems  as $registro)
                         {
                            $registro->fkCotizacion = $model->idcotizacion;

                            $paquete = Paquete::findOne( $registro->fkPaquete );
                            $paquete->cantidad -= $registro->cantidad;
                            $paquete->save();
                            $subtotal1 += ( $paquete->monto * $registro->cantidad );
                            
                            
                            if (! ($flag = $registro->save(false))) {
                                // un acumulador sumando el precio del producto por el impuesto por la cantidad que se va al paquete
                                $transaction->rollBack();
                                break;
                            }
                        }


                        $total = $subtotal1 - ( ( $subtotal1 * $model->descuento )/ 100 );
                        $model->total = $total;
                        $model->save();
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $model->idcotizacion]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        
        } else {
            return $this->render('create', [
                'model' => $model,
                'modelsCotizacionitems' => (empty($modelsCotizacionitems)) ? [new CotizacionHasPaquete] : $modelsCotizacionitems
            ]);
        }
    }


    /**
     * Updates an existing Cotizacion model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idcotizacion]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionExportar($id)
    {
        $model = $this->findModel($id);

        return $this->render('exportar', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Cotizacion model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Cotizacion model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Cotizacion the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Cotizacion::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
