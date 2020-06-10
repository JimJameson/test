<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ingredients".
 *
 * @property int $id
 * @property string $name
 * @property int $is_hidden
 *
 * @property DishIngredient[] $dishesIngredients
 * @property Dish[] $dishes
 */
class Ingredient extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ingredients';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'is_hidden'], 'required'],
            [['is_hidden'], 'integer'],
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
            'is_hidden' => 'Скрыто',
        ];
    }

    /**
     * Gets query for [[DishesIngredients]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDishesIngredients()
    {
        return $this->hasMany(DishIngredient::class, ['ingredients_id' => 'id']);
    }

    /**
     * Gets query for [[Dishes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDishes()
    {
        return $this->hasMany(Dish::class, ['id' => 'dishes_id'])->viaTable('dishes_ingredients', ['ingredients_id' => 'id']);
    }

    public function getHiddenStatus()
    {
        $list = self::getHiddenStatusList();
        return $list[$this->is_hidden];
    }

    public static function getHiddenStatusList()
    {
        return ['Нет', 'Да'];
    }
}
