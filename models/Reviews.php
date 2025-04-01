<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

class Reviews extends ActiveRecord
{
    public static function tableName()
    {
        return 'reviews';
    }
    public function rules()
    {
        return [
            [['title', 'text'], 'required', 'message' => 'Поле обязательно для заполнения'],
            ['title', 'string', 'max' => 255, 'message' => 'Заголовок не может быть длиннее 255 символов'],
            ['text', 'string', 'max' => 5000, 'message' => 'Текст не может быть длиннее 5000 символов'],
            ['is_recommended', 'in', 'range' => ['yes', 'no', 'none'], 'message' => 'Выберите, рекомендуете ли вы товар'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'title' => 'Заголовок отзыва одной фразой',
            'text' => 'Ваш отзыв',
            'is_recommended' => 'Вы бы порекомендовали это?',
            'created_at' => 'Дата создания',
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    // Если есть связь с таблицей users
    public function getUser()
    {
        return $this->hasOne(NewUsers::class, ['id' => 'user_id']);
    }
}