<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "adverts".
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $desc
 * @property int|null $cat_id
 * @property int|null $status
 */
class Adverts extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'adverts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'desc'], 'string'],
            [['cat_id', 'status'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Заголовок',
            'desc' => 'Описания',
            'cat_id' => 'Категория',
            'status' => 'Статус',
        ];
    }

    public function getCatId(){
        return Category::findOne($this->cat_id)['title'];
    }



}
