<?php

use yii\db\Migration;

/**
 * Class m240928_085318_book_image
 */
class m240928_085318_book_image extends Migration
{
    public string $tableName = 'book_image';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'book_id' => $this->integer()->notNull(),
            'filename' => $this->string()->notNull(),
            'cover' => $this->boolean()->defaultValue(false),
        ]);

        $this->addForeignKey(
            'fk-book_image-book_id',
            $this->tableName,
            'book_id',
            'book',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240928_085318_book_image cannot be reverted.\n";

        $this->dropForeignKey(
            'fk-book_image-book_id',
            $this->tableName
        );

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
        echo "m240928_085318_book_image cannot be reverted.\n";

        return false;
    }
    */
}
