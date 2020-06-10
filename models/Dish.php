<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dishes".
 *
 * @property int $id
 * @property string $name
 *
 * @property DishIngredient[] $dishesIngredients
 * @property Ingredient[] $ingredients
 */
class Dish extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dishes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Наименование',
        ];
    }

    /**
     * Gets query for [[DishesIngredients]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDishesIngredients()
    {
        return $this->hasMany(DishIngredient::class, ['dishes_id' => 'id']);
    }

    /**
     * Gets query for [[Ingredients]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIngredients()
    {
        return $this->hasMany(Ingredient::class, ['id' => 'ingredients_id'])->viaTable('dishes_ingredients', ['dishes_id' => 'id']);
    }



}
