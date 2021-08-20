<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * @property int $id
 * @property string $created_at
 * @property string $updated_at
 * @property string $email
 * @property string $phone
 * @property string|null $text
 * @property int|null $manager_id
 *
 * @property Manager|null $manager
 */
class Request extends \yii\db\ActiveRecord
{
    public static function tableName(): string
    {
        return 'requests';
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
            [['email', 'phone'], 'required'],
            ['email', 'email'],
            ['manager_id', 'integer'],
            ['manager_id', 'exist', 'targetClass' => Manager::class, 'targetAttribute' => 'id'],
            [['email', 'phone'], 'string', 'max' => 255],
            ['text', 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id'         => 'ID',
            'created_at' => 'Добавлен',
            'updated_at' => 'Изменен',
            'email'      => 'Email',
            'phone'      => 'Номер телефона',
            'manager_id' => 'Ответственный менеджер',
            'text'       => 'Текст заявки',
        ];
    }

    public function getManager()
    {
        return $this->hasOne(Manager::class, ['id' => 'manager_id']);
    }

    public static function findDuplicate(Request $req)
    {
        $query = Request::find()->alias('req1');
        $query->with(['manager']);

        $subQuery = Request::find()
            ->alias('req2')
            ->select(['id'])
            ->where(['<', 'DATEDIFF(req1.created_at, req2.created_at)', 30])
            ->andWhere(
                ['AND', 'req1.email = :email', 'req1.phone = :phone'],
                ['email' => $req->email, 'phone' => $req->phone]
            )
            ->andWhere(['AND', 'req1.email = req2.email', 'req1.phone = req2.phone'])
            ->andWhere(
                'created_at < :req_created_at',
                ['req_created_at' => $req->created_at]
            )
            ->orderBy(['id' => SORT_DESC])
            ->limit(1);

        $query->andWhere(['=', 'req1.id', $subQuery]);

        return $query->one();
    }
}
