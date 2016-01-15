<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $curTableOptions = $tableOptions." COMMENT '用户表'";
        $this->execute("DROP TABLE IF EXISTS {{%user_admin}};");
        $this->execute("DROP TABLE IF EXISTS {{%user}};");

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),

            'status'     => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $curTableOptions);

        $this->insert('{{%user}}',[
            'id' => 1,
            'username' => 'admin',
            'auth_key' => 'EkmeWfKlpqsxdN53Jr_VeOgZkmePsuTM',
            'password_hash' => '$2y$13$eGk3JW51BFokL1QpXeF.xO7AluEPF8E54WuUMKpXYAygb9DEGGhsC',
            'email'=> 'w@vlongbiz.com',
            'created_at'  => time(),
            'updated_at'  => time(),
        ]);

        $curTableOptions = $tableOptions." COMMENT '管理权限表'";
        $this->createTable('{{%user_admin}}',[
            'user_id'   => $this->integer()->notNull()->defaultValue(0),
            'site_ids'  => $this->text()." COMMENT '管理站点ID'",
            'node_ids'  => $this->text()." COMMENT '管理结点ID'",
            'cm_ids'    => $this->text()." COMMENT '管理内容模型ID'",
            'allow_ips' => $this->text()." COMMENT '允许登录IP地址'",
            'Primary key (user_id)',
            'CONSTRAINT {{%user_admin}}
                FOREIGN KEY (`user_id`)
                REFERENCES {{%user}} (`id`)
                ON DELETE CASCADE
                ON UPDATE CASCADE ',
        ],$curTableOptions);
        //权限相关放这这里了
        $this->execute("DROP TABLE IF EXISTS {{%auth_category}};");

        $curTableOptions = $tableOptions." COMMENT '权限定义分类表'";
        $this->createTable('{{%auth_category}}',[
            'id'   => $this->primaryKey(),
            'name' => $this->string(20)->notNull()->defaultValue('')
        ],$curTableOptions);

        $curTableOptions = $tableOptions." COMMENT '权限预定义最小角色'";
        $this->execute("DROP TABLE IF EXISTS {{%auth_role}};");

        $this->createTable('{{%auth_role}}',[
            'id'     => $this->primaryKey(),
            'cat_id' => $this->integer()->notNull()->defaultValue(0)." COMMENT '角色分类'",
            'name'        => $this->string(30)->notNull()->defaultValue('')." COMMENT '角色名称'",
            'description' => $this->string(80)->notNull()->defaultValue('')." COMMENT '角色描述'",
            'rules'       => $this->string(80)->notNull()->defaultValue('') ." COMMENT '定义rule class'",
            'controllers' => $this->text()." COMMENT '允许访问控制器'",
            'actions'     => $this->text()." COMMENT '允许访问动作ID'"

        ],$curTableOptions);
    }

    public function down()
    {
        $this->execute("DROP TABLE IF EXISTS {{%user_admin}};");
        $this->execute("DROP TABLE IF EXISTS {{%user}};");
        $this->execute("DROP TABLE IF EXISTS {{%auth_category}};");
        $this->execute("DROP TABLE IF EXISTS {{%auth_role}};");
    }
}
