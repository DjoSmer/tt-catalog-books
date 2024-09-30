<?php

use yii\db\Migration;

/**
 * Class m240929_081415_subscriber
 */
class m240929_081415_subscriber extends Migration
{
    public string $tableName = 'subscriber';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'phone_number' => $this->string(15)->notNull()->unique(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240929_081415_subscriber cannot be reverted.\n";

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
        echo "m240929_081415_subscriber cannot be reverted.\n";

        return false;
    }
    */
}
