<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\DishIngredient;
use app\modules\admin\models\DishIngredientSearch;
use yii\base\Model;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DishIngredientController implements the CRUD actions for DishIngredient model.
 */
class DishIngredientController extends Controller
{
    /**
     * {@inheritdoc}
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
     * Lists all DishIngredient models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DishIngredientSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DishIngredient model.
     * @param integer $dishes_id
     * @param integer $ingredients_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($dishes_id, $ingredients_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($dishes_id, $ingredients_id),
        ]);
    }

    /**
     * Creates a new DishIngredient model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $count = count(Yii::$app->request->post('Dishingredient', []));
        $model = [new DishIngredient()];

        for ($i = 1; $i < $count; $i++) {
            $model[] = new DishIngredient();
        }

        if (Model::loadMultiple($model, Yii::$app->request->post()) && Model::validateMultiple($model)) {

            foreach ($model as $item) {
                $item->save(false);
            }

            return $this->redirect('index');
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing DishIngredient model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $dishes_id
     * @param integer $ingredients_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($dishes_id, $ingredients_id)
    {
        $model = $this->findModel($dishes_id, $ingredients_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'dishes_id' => $model->dishes_id, 'ingredients_id' => $model->ingredients_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing DishIngredient model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $dishes_id
     * @param integer $ingredients_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($dishes_id, $ingredients_id)
    {
        $this->findModel($dishes_id, $ingredients_id)->delete();

        return $this->redirect(['index']);
    }

    public function actionAdd()
    {
        $cnt = Yii::$app->request->post('cnt');

        return $this->renderAjax('_add_form', [
            'cnt' => $cnt,
            'model' => new DishIngredient()
        ]);
    }


    /**
     * Finds the DishIngredient model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $dishes_id
     * @param integer $ingredients_id
     * @return DishIngredient the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($dishes_id, $ingredients_id)
    {
        if (($model = DishIngredient::findOne(['dishes_id' => $dishes_id, 'ingredients_id' => $ingredients_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
