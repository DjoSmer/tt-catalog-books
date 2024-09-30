<?php

use yii\db\Migration;

/**
 * Class m240928_085015_book_author
 */
class m240928_085015_book_author extends Migration
{
    public string $tableName = 'book_author';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'book_id' => $this->integer()->notNull(),
            'author_id' => $this->integer()->notNull(),
            'PRIMARY KEY(book_id, author_id)',
        ]);

        $this->addForeignKey(
            'fk-book_author-book_id',
            $this->tableName,
            'book_id',
            'book',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-book_author-author_id',
            $this->tableName,
            'author_id',
            'author',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240928_085015_book_author cannot be reverted.\n";

        $this->dropForeignKey('fk-book_author-book_id', $this->tableName);
        $this->dropForeignKey('fk-book_author-author_id', $this->tableName);

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
        echo "m240928_085015_book_author cannot be reverted.\n";

        return false;
    }
    */
}
