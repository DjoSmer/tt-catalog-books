<?php
/**
 * author E.Demidov 2024
 */

namespace app\models;

use yii\db\Exception;

class SubscribeForm extends Subscriber
{
    /** @var int */
    public int $author_id;

    public function rules(): array
    {
        return array_merge(parent::rules(), [
            ['author_id', 'required'],
            ['author_id', 'integer'],
        ]);
    }

    /**
     * @throws Exception
     */
    public function authorSubscribe()
    {
        $subscribe = Subscriber::findOne(['phone_number' => $this->phone_number]);
        if (!$subscribe) {
            $subscribe = $this;
            $this->save();
        }

        $authorSubscribe = new AuthorSubscriber();
        $authorSubscribe->author_id = $this->author_id;
        $authorSubscribe->subscriber_id = $subscribe->id;
        $authorSubscribe->save();
    }
}
