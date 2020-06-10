<?php

namespace app\controllers;

use app\models\Dish;
use app\models\DishIngredient;
use app\models\Ingredient;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $ingredients = Ingredient::find()->where(['is_hidden' => 0])->asArray()->all();
        $ingredients = ArrayHelper::map($ingredients, 'id', 'name');
        return $this->render('index', compact('ingredients'));
    }

    public function actionSearch($values) {

        if (Yii::$app->request->isAjax) {

            $values = explode(',',$values);

            if (count($values) < 2) {
                return 'Выберите больше ингредиентов';
            }
            $query = DishIngredient::find()
                ->select(['dishes_id', 'COUNT(*) AS count', 'SUM(ingredients.is_hidden) AS sum'])
                ->joinWith('ingredients')
                ->where(['ingredients_id' => $values])
                ->groupBy('dishes_id')
                ->having(['sum' => 0]);


            $dishes = $query
                ->andHaving(['count' => count($values)])
                ->all();

            $coincidences = 'Результаты по полному совпадению';

            if (empty($dishes)) {
                $dishes = $query
                    ->andHaving(['>=', 'count', 2])
                    ->orderBy('count')
                    ->all();
                $coincidences = 'Результаты по частичному совпадению';
            }

            if (empty($dishes)) {
                return 'Ничего не найдено';
            }

            return $this->renderAjax('inc/dish', compact('dishes', 'coincidences'));
        }
    }
}
