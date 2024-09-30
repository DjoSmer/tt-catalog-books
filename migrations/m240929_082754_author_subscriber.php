<?php

use yii\db\Migration;

/**
 * Class m240929_082754_author_subscriber
 */
class m240929_082754_author_subscriber extends Migration
{
    public string $tableName = 'author_subscriber';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'author_id' => $this->integer()->notNull(),
            'subscriber_id' => $this->integer()->notNull(),
            'PRIMARY KEY(author_id, subscriber_id)',
        ]);

        $this->addForeignKey(
            sprintf('fk-%s-author_id', $this->tableName),
            $this->tableName,
            'author_id',
            'author',
            'id'
        );

        $this->addForeignKey(
            sprintf('fk-%s-subscriber_id', $this->tableName),
            $this->tableName,
            'subscriber_id',
            'subscriber',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240929_082754_author_subscriber cannot be reverted.\n";

        $this->dropForeignKey(sprintf('fk-%s-author_id', $this->tableName), $this->tableName);
        $this->dropForeignKey(sprintf('fk-%s-subscriber_id', $this->tableName), $this->tableName);

        $this->dropTable($this->tableName);

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240929_082754_author_subscriber cannot be reverted.\n";

        return false;
    }
    */
}
