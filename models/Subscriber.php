<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "subscriber".
 *
 * @property int $id
 * @property string $phone_number
 *
 * @property AuthorSubscriber[] $authorSubscribers
 * @property Author[] $authors
 */
class Subscriber extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'subscriber';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['phone_number', 'required'],
            ['phone_number', 'string', 'max' => 15],
            ['phone_number', 'validatePhoneNumber'],
        ];
    }

    public function validatePhoneNumber()
    {
        $phoneNumber = $this->phone_number;
        if ($phoneNumber != '') {
            if (!preg_match('/^[1-9]\d{9,14}$/', $phoneNumber)) {
                $this->addError('phone_number', 'In Valid Phone number');
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'phone_number' => 'Phone Number',
        ];
    }

    /**
     * Gets query for [[AuthorSubscribers]].
     *
     * @return ActiveQuery
     */
    public function getAuthorSubscribers()
    {
        return $this->hasMany(AuthorSubscriber::class, ['subscriber_id' => 'id']);
    }

    /**
     * Gets query for [[Authors]].
     *
     * @return ActiveQuery
     */
    public function getAuthors()
    {
        return $this->hasMany(Author::class, ['id' => 'author_id'])->viaTable('author_subscriber', ['subscriber_id' => 'id']);
    }
}
