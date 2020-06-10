<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%users}}`.
 */
class m200609_191705_add_is_admin_column_to_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%users}}', 'is_admin', $this->boolean());

        $this->insert('{{%users}}', [
            'username' => 'admin',
            'is_admin' => true,
            'password_hash' => '$2y$13$M9C5dZ3oJuhRjmALwshhaO5ctnQBdDi6HpaRXE.8Udf.F.Ld78i42'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%users}}', 'is_admin');
    }
}
