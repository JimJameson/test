<?php

namespace app\modules\admin\controllers;

use app\models\DishIngredient;
use app\models\Ingredient;
use app\modules\admin\models\IngredientSearch;
use Yii;
use app\models\Dish;
use app\modules\admin\models\DishSearch;
use app\models\Model;
use yii\db\Exception;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * DishController implements the CRUD actions for Dish model.
 */
class DishController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Dish models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DishSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Dish model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id)
        ]);
    }

    /**
     * Creates a new Customer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Dish();
        $modelsIngredient = [new DishIngredient()];
        $ingredients = Ingredient::find()->asArray()->all();
        $ingredients = ArrayHelper::map($ingredients,'id', 'name');
        if ($model->load(Yii::$app->request->post())) {

            $modelsIngredient = Model::createMultiple(DishIngredient::class);
            Model::loadMultiple($modelsIngredient, Yii::$app->request->post());

            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelsIngredient),
                    ActiveForm::validate($model)
                );
            }

            // validate all models
            $valid = $model->validate();
            $valid = Model::validateMultiple($modelsIngredient) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        foreach ($modelsIngredient as $item) {
                            $item->dishes_id = $model->id;
                            if (! ($flag = $item->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
            'modelsIngredient' => (empty($modelsIngredient)) ? [new DishIngredient()] : $modelsIngredient,
            'ingredients' => $ingredients,
        ]);
    }

    /**
     * Updates an existing Customer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelsIngredient = $model->dishesIngredients;
        $ingredients = Ingredient::find()->asArray()->all();
        $ingredients = ArrayHelper::map($ingredients,'id', 'name');

        if ($model->load(Yii::$app->request->post())) {

            $oldIDs = ArrayHelper::map($modelsIngredient, 'ingredients_id', 'ingredients_id');
            $modelsIngredient = Model::createMultiple(DishIngredient::class, $modelsIngredient);
            Model::loadMultiple($modelsIngredient, Yii::$app->request->post());
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelsIngredient, 'ingredients_id', 'ingredients_id')));

            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelsIngredient),
                    ActiveForm::validate($model)
                );
            }

            // validate all models
            $valid = $model->validate();
            $valid = Model::validateMultiple($modelsIngredient) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        if (! empty($deletedIDs)) {
                            DishIngredient::deleteAll(['ingredients_id' => $deletedIDs]);
                        }
                        foreach ($modelsIngredient as $item) {
                            if (! ($flag = $item->save(false))) {
                                $item->dishes_id = $model->id;
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
            'modelsIngredient' => (empty($modelsIngredient)) ? [new DishIngredient()] : $modelsIngredient,
            'ingredients' => $ingredients,
        ]);
    }


    /**
     * Deletes an existing Dish model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Dish model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Dish the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Dish::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
