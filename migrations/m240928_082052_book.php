<?php

use yii\db\Migration;

/**
 * Class m240928_082052_book
 */
class m240928_082052_book extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('book', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'description' => $this->text()->notNull(),
            'release_year' => $this->smallInteger()->notNull(),
            'isbn' => $this->bigInteger(),
            'created_at' => $this->dateTime()->defaultExpression('NOW()'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240928_082052_book cannot be reverted.\n";

        $this->dropTable('book');

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240928_082052_book cannot be reverted.\n";

        return false;
    }
    */
}
