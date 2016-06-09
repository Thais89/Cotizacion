<?php

namespace app\controllers;

use Yii;
use app\models\Paquete;
use app\models\PaqueteSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Producto;
use app\models\ProductoHasPaquete;
use app\models\Model;
use yii\web\Response;

/**
 * PaqueteController implements the CRUD actions for Paquete model.
 */
class PaqueteController extends Controller
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
     * Lists all Paquete models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PaqueteSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Paquete model.
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
     * Creates a new Paquete model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
   public function actionCreate()
    {
        $model = new Paquete();
        $modelsProductoHasPaquete = [new ProductoHasPaquete];

        if(Yii::$app->request->isAjax && $model->load(Yii::$app->request->post()))
        {
            $modelsProductoHasPaquete = Model::createMultiple(ProductoHasPaquete::classname());
            Model::loadMultiple($modelsProductoHasPaquete, Yii::$app->request->post());
            foreach ($modelsProductoHasPaquete as $key => $value) {

                $modelsProductoHasPaquete[$key]['d']=$_POST['Paquete']['cantidad'];
            }
            $model->attributes=$_POST['Paquete'];
             Yii::$app->response->format = 'json';
            return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelsProductoHasPaquete),
                    ActiveForm::validate($model)
                );
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

                $modelsProductoHasPaquete  = Model::createMultiple(ProductoHasPaquete::classname());
            Model::loadMultiple($modelsProductoHasPaquete , Yii::$app->request->post());

            // validate all models
            $valid = $model->validate();
            $subtotal = 0;
            //$valid = Model::validateMultiple($modelsProductoHasPaquete ) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        foreach ($modelsProductoHasPaquete  as $modelProductoHasPaquete)
                         {
                            $modelProductoHasPaquete->paquete_codigo = $model->codigo;


                            $producto = Producto::findOne( $modelProductoHasPaquete->producto_codigo );

                        
                            
                            $producto->cantidad -= $modelProductoHasPaquete->cantidad*$model->cantidad;
                            $producto->save();
                            $subtotal += ( $producto->precio * $modelProductoHasPaquete->cantidad );

                            if (! ($flag = $modelProductoHasPaquete->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }

                        $total = $subtotal - ( ( $subtotal * $model->descuento )/ 100 );

                        $model->monto = $total;
                        $model->save();
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $model->codigo]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        
        } else {
            return $this->render('create', [
                'model' => $model,
                'modelsProductoHasPaquete' => (empty($modelsProductoHasPaquete)) ? [new ProductoHasPaquete] : $modelsProductoHasPaquete
            ]);
        }
    }


    /**
     * Updates an existing Paquete model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->codigo]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Paquete model.
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
     * Finds the Paquete model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Paquete the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Paquete::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
