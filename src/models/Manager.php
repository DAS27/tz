<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * @property int $id
 * @property string $created_at
 * @property string $updated_at
 * @property string $name
 * @property int $is_works
 */
class Manager extends \yii\db\ActiveRecord
{
    public static function tableName(): string
    {
        return 'managers';
    }

    public function behaviors(): array
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    public function rules(): array
    {
        return [
            [['name', 'is_works'], 'required'],
            ['name', 'string', 'max' => 255],
            ['is_works', 'boolean'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id'         => 'ID',
            'created_at' => 'Добавлен',
            'updated_at' => 'Изменен',
            'name'       => 'ФИО',
            'is_works'   => 'Сейчас работает',
        ];
    }

    public static function getList(): array
    {
        return array_column(
            self::find()->orderBy('name ASC')->asArray()->all(),
            'name',
            'id'
        );
    }
}
