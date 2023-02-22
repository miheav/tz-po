<?php

use yii\db\Migration;

class m230221_152923_create_table_apple extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%apple}}', [
            'id' => $this->primaryKey(),
            'color' => $this->string()->notNull(),
            'appearance_date' => $this->dateTime()->defaultValue(NULL),
            'fall_date' => $this->dateTime()->defaultValue(NULL),
            'status' => $this->smallInteger()->notNull()->defaultValue(0),
            'size' => $this->float()->notNull()->defaultValue(1),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%apple}}');
    }
}
