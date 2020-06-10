<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dishes_ingredients".
 *
 * @property int $dishes_id
 * @property int $ingredients_id
 *
 * @property Dish $dishes
 * @property Ingredient $ingredients

 */
class DishIngredient extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dishes_ingredients';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ingredients_id'], 'required'],
            ['dishes_id', 'safe'],
            [['dishes_id', 'ingredients_id'], 'integer'],
            [['dishes_id', 'ingredients_id'], 'unique', 'targetAttribute' => ['dishes_id', 'ingredients_id']],
            [['dishes_id'], 'exist', 'skipOnError' => true, 'targetClass' => Dish::class, 'targetAttribute' => ['dishes_id' => 'id']],
            [['ingredients_id'], 'exist', 'skipOnError' => true, 'targetClass' => Ingredient::class, 'targetAttribute' => ['ingredients_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'dishes_id' => 'Блюдо',
            'ingredients_id' => 'Ингредиент',
        ];
    }

    /**
     * Gets query for [[Dishes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDishes()
    {
        return $this->hasOne(Dish::class, ['id' => 'dishes_id']);
    }

    /**
     * Gets query for [[Ingredients]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIngredients()
    {
        return $this->hasOne(Ingredient::class, ['id' => 'ingredients_id']);
    }

}
