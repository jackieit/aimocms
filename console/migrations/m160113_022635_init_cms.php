<?php

use yii\db\Migration;

class m160113_022635_init_cms extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        //create system setting table
        $tableComment = $tableOptions." COMMENT '系统设置表'";

        $this->execute("DROP TABLE IF EXISTS {{%setting}};");

        $this->createTable('{{%setting}}',[
            'var' => $this->string(45)->notNull()->defaultValue('')->unique()." COMMENT '变量'",
            'val' => $this->string(255)->notNull()->defaultValue('')." COMMENT '变量值'",
        ],$tableComment);

        //create site setting table
        $tableComment = $tableOptions." COMMENT '站点表'";

        $this->execute("DROP TABLE IF EXISTS {{%domain}};");
        $this->execute("DROP TABLE IF EXISTS {{%site_config}};");
        $this->execute("DROP TABLE IF EXISTS {{%site}};");

        $this->createTable('{{%site}}',[
            'id'         => $this->primaryKey(),
            'name'       => $this->string(80)->notNull()->defaultValue('')."  COMMENT '站点名称'",
            'template'   => $this->string(30)->notNull()->defaultValue('')."  COMMENT '模板路径'",
            'is_publish' => $this->boolean()->notNull()->defaultValue(0)."    COMMENT '是否独立发布'",
            'path'       => $this->string(120)->notNull()->defaultValue('')." COMMENT '发布路径'",
            'dsn'        => $this->string(120)->notNull()->defaultValue('')." COMMENT '发布DSN'",
            'url'        => $this->string(120)->notNull()->defaultValue('')." COMMENT '站点URL'",
            'res_path'   => $this->string(120)->notNull()->defaultValue('')." COMMENT '资源发布路径'",
            'res_url'    => $this->string(120)->notNull()->defaultValue('')." COMMENT '资源发布URL'",
            'page_404'   => $this->string(45)->notNull()->defaultValue('')."  COMMENT '404页面模板'",
            'beian'      => $this->string(45)->notNull()->defaultValue('')."  COMMENT 'ICP备案号'",
            'seo_title'       => $this->string(80)->notNull()->defaultValue('')."  COMMENT 'SEO标题'",
            'seo_keyword'     => $this->string(240)->notNull()->defaultValue('')." COMMENT 'SEO关键字'",
            'seo_description' => $this->string(120)->notNull()->defaultValue('')." COMMENT 'SEO描述'",

        ],$tableComment);
        //insert default site data
        $this->insert('{{%site}}',[
            'id'        => '1',
            'name'      => '默认站点',
            'template'  => 'default',
            'is_publish' => '0',
            'url'       => '@web',
            'res_path'  => ' @frontend/web/static',
            'res_url'   => '@web/static/',
        ]);
        $tableComment = $tableOptions." COMMENT '站点域名表'";

        $this->createTable('{{%domain}}',[
            'id'      => $this->primaryKey(),
            'site_id' => $this->integer()->notNull()->defaultValue(0)." COMMENT '站点ID'",
            'domain' => $this->string(80)->notNull()->defaultValue('')." COMMENT '域名'",
            'main'    => $this->boolean()->notNull()->defaultValue(0)." COMMENT '是否主域名'",
            ' key(`site_id`)',
            'CONSTRAINT {{%domain}}
                FOREIGN KEY (`site_id`)
                REFERENCES {{%site}} (`id`)
                ON DELETE CASCADE
                ON UPDATE CASCADE ',
        ],$tableComment);
        //insert default site domain
        $this->batchInsert('{{%domain}}',[
                'site_id','domain','main'
            ],
            [
                [1 ,'www.example.com',1],
                [1, 'example.com',0],
            ]
        );


        $tableComment = $tableOptions." COMMENT '站点设置表'";
        $this->createTable('{{%site_config}}',[
            'site_id' => $this->integer()->notNull()->defaultValue(0)." COMMENT '站点ID'",
            'var' => $this->string(45)->notNull()->defaultValue('')."  COMMENT '变量'",
            'val' => $this->string(255)->notNull()->defaultValue('')." COMMENT '变量值'",
            'Primary key(`site_id`,`var`)',
            'CONSTRAINT {{%site_config}}
                FOREIGN KEY (`site_id`)
                REFERENCES {{%site}} (`id`)
                ON DELETE CASCADE
                ON UPDATE CASCADE ',
        ],$tableComment);

        $tableComment = $tableOptions." COMMENT '内容模型表'";

        $this->execute("DROP TABLE IF EXISTS {{%cm_field}};");
        $this->execute("DROP TABLE IF EXISTS {{%cm}};");

        $this->createTable('{{%cm}}',[
            'id'      => $this->primaryKey(),
            'name'    => $this->string(45)->notNull()->defaultValue('')."  COMMENT '名称'",
            'tab'     => $this->string(45)->notNull()->defaultValue('')."  COMMENT '表名称'",
            'is_inner'  => $this->boolean()->notNull()->defaultValue(0)." COMMENT '是否内置'",
            'site_id'   => $this->integer()->notNull()->defaultValue(0)." COMMENT '站点ID'",
            'tab_index' => $this->boolean()->notNull()->defaultValue(0)." COMMENT '对应索引表'", //1 cm_index 2 user
            'rules'    => $this->text()."  COMMENT '数据来源'",
            'title_field'    => $this->text()."  COMMENT '标题字段'",
            'select_field'  => $this->text()."  COMMENT '列表字段'",

        ],$tableComment);
        $this->insert('{{%cm}}',[
           'name'       => '文章模型',
            'tab'       => 'article',
            'is_inner'  => 1,
            'site_id'   => 0,
            'tab_index' => 1,
        ]);
        //---
        $tableComment = $tableOptions." COMMENT '内容模型表'";


        $this->createTable('{{%cm_field}}',[
            'id'      => $this->primaryKey(),
            'cm_id'   => $this->integer()->notNull()->defaultValue(0)." COMMENT '内容模型ID'",
            'name'    => $this->string(45)->notNull()->defaultValue('')."  COMMENT '字段名称'",
            'label'   => $this->string(45)->notNull()->defaultValue('')."  COMMENT '字段说明'",
            'hint'    => $this->string(45)->notNull()->defaultValue('')."  COMMENT '字段描述'",
            'data_type'  => $this->string(45)->notNull()->defaultValue('')."  COMMENT '数据类型'",
            'length'   => $this->string(20)->notNull()->defaultValue('')." COMMENT '字段长度'",
            'sort'     => $this->smallInteger()->notNull()->defaultValue(0)." COMMENT '排序'",
            'input'    => $this->string(45)->notNull()->defaultValue('')."  COMMENT '表单输入类型'",
            'source'   => $this->text()."  COMMENT '数据来源'",
            'is_inner' => $this->boolean()->notNull()->defaultValue(0)." COMMENT '是否内置'",
            'key cmid (`cm_id`)',
            'CONSTRAINT {{%cm_field}}
                FOREIGN KEY (`cm_id`)
                REFERENCES {{%cm}} (`id`)
                ON DELETE CASCADE
                ON UPDATE CASCADE ',
        ],$tableComment);

        $this->batchInsert('{{%cm_field}}',
            ['cm_id','name','label','hint','data_type','length','input','source','is_inner'],
            [
                [1,'title','标题','','string',80,'textInput','',1],
                [1,'color','标题颜色','','string',10,'textInput','',1],
                [1,'author','作者','','string',45,'textInput','',1],
                [1,'from'  ,'文章来源','','string',60,'textInput','',1],
                [1,'photo' ,'图片','','string',60,'textInput','',1],
                [1,'intro' ,'简介','','string',240,'textarea','',1],
                [1,'content','详细内容','','text',0,'textarea','',1],
                [1,'tpl_detail','详细内容模板','','text',0,'textarea','',1],
                [1,'file_name','文件名','','text',0,'textarea','',1],
                [1,'slug','固定连接','','text',0,'textInput','',1],
                [1,'seo_title','SEO标题','','string',80,'textInput','',1],
                [1,'seo_keyword','SEO关键字','','string',240,'textInput','',1],
                [1,'seo_description','SEO描述','','string',120,'textarea','',1],
            ]
        );
        $tableComment = $tableOptions." COMMENT '结点分类表'";
        $this->execute("DROP TABLE IF EXISTS {{%node}};");
        $this->createTable('{{%node}}',[
            'id'       => $this->primaryKey(),
            'site_id'  => $this->integer()->notNull()->defaultValue(0)." COMMENT '站点ID'",
            'cm_id'    => $this->integer()->notNull()->defaultValue(0)." COMMENT '内容模型ID'",
            'name'     => $this->string(20)->notNull()->defaultValue('')." COMMENT '结点名称'",
            'is_real'  => $this->boolean()->notNull()->defaultValue(0)."  COMMENT '实虚结点'",
            'v_nodes'  => $this->text()." COMMENT '虚结点包含结点'",
            'parent'   => $this->integer()->notNull()->defaultValue(0)." COMMENT '上级结点'",
            'slug'     => $this->string(45)->notNull()->defaultValue(0)." COMMENT '英文标识slug'",
            'workflow' => $this->boolean()->notNull()->defaultValue(0)." COMMENT '投稿工作流'",
            'tpl_index' => $this->string(45)->notNull()->defaultValue('')." COMMENT '首页模板'",
            'tpl_detail' => $this->string(45)->notNull()->defaultValue('')." COMMENT '详细内容页模板'",
            'status'     => $this->boolean()->notNull()->defaultValue(0)." COMMENT '结点状态'",
            'seo_title'       => $this->string(80)->notNull()->defaultValue('')."  COMMENT 'SEO标题'",
            'seo_keyword'     => $this->string(240)->notNull()->defaultValue('')." COMMENT 'SEO关键字'",
            'seo_description' => $this->string(120)->notNull()->defaultValue('')." COMMENT 'SEO描述'",


        ],$tableComment);

        $tableComment = $tableOptions." COMMENT '文章内容表'";

        $this->execute("DROP TABLE IF EXISTS {{%cm_article}};");
        $this->createTable('{{%cm_article}}',[
            'id'      => $this->primaryKey(),
            'title'   => $this->string(80)->notNull()->defaultValue('')." COMMENT '标题'",
            'color'   => $this->string(10)->notNull()->defaultValue('')." COMMENT '标题颜色'",
            'author'  => $this->string(45)->notNull()->defaultValue('')." COMMENT '作者'",
            'from'    => $this->string(60)->notNull()->defaultValue('')." COMMENT '文章来源'",
            'photo'   => $this->string(60)->notNull()->defaultValue('')." COMMENT '图片'",
            'intro'   => $this->string(240)->notNull()->defaultValue('')." COMMENT '简介'",
            'content' => $this->text()." COMMENT '详细内容'",
            'seo_title'       => $this->string(80)->notNull()->defaultValue('')."  COMMENT 'SEO标题'",
            'seo_keyword'     => $this->string(240)->notNull()->defaultValue('')." COMMENT 'SEO关键字'",
            'seo_description' => $this->string(120)->notNull()->defaultValue('')." COMMENT 'SEO描述'",
            'tpl_detail' => $this->string(45)->notNull()->defaultValue('')." COMMENT '详细内容页模板'",
            'file_name'  => $this->string(45)->notNull()->defaultValue('')." COMMENT '文件名'",
            'slug'  => $this->string(45)->notNull()->defaultValue('')." COMMENT '固定连接'",
        ],$tableComment);

        $tableComment = $tableOptions." COMMENT '内容索引表'";
        $this->execute("DROP TABLE IF EXISTS {{%cm_index}};");

        $this->createTable('{{%cm_index}}',[
            'id'    => $this->primaryKey(),
            'cm_id'      => $this->integer()->notNull()->defaultValue(0)." COMMENT '内容模型ID'",
            'content_id' => $this->integer()->notNull()->defaultValue(0)." COMMENT '关联内容ID'",
            'node_id'    => $this->integer()->notNull()->defaultValue(0)." COMMENT '结点分类ID'",
            'parent_id'  => $this->integer()->notNull()->defaultValue(0)." COMMENT '父内容ID'",
             // 越小越靠前
            'top'    => $this->smallInteger()->notNull()->defaultValue(0)." COMMENT '置顶'",
            'pink'   => $this->smallInteger()->notNull()->defaultValue(0)." COMMENT '精华'",
            'sort'   => $this->smallInteger()->notNull()->defaultValue(0)." COMMENT '排序'",
            'created_at' => $this->integer()->notNull()->defaultValue(0)." COMMENT '发布时间'",
            'updated_at' => $this->integer()->notNull()->defaultValue(0)." COMMENT '更新时间'",
            // 1 正常 <1 删除
            'state'  => $this->boolean()->notNull()->defaultValue(0)." COMMENT '状态'",
            'key `content`(`cm_id`,`node_id`,`content_id`)',
            'key `sort` (`top` asc,`pink` asc ,`sort` asc,`updated_at` desc)',

        ],$tableComment);
        $tableComment = $tableOptions." COMMENT '操作记录表'";
        $this->execute("DROP TABLE IF EXISTS {{%log}};");
        $this->createTable('{{%log}}',[
            'id'   => $this->primaryKey(),
            //日志类型  用户类 内容类 角色类 站点类 结点类
            'kind'    => $this->smallInteger()->notNull()->defaultValue(0)." COMMENT '日志类型'",
            'user_id' => $this->integer()->notNull()->defaultValue(0)." COMMENT '用户ID'",
            'data'    => $this->string(60)->notNull()->defaultValue('')." COMMENT '操作内容'",
            'ip'      => $this->integer()->notNull()->defaultValue(0)." COMMENT '操作IP'",
            'dateline'  => $this->integer()->notNull()->defaultValue(0)." COMMENT '操作时间'",
            'key kind(`kind`)',
        ],$tableComment);

    }


    /**
     *
     */
    public function down()
    {
        $this->dropTable('{{%setting}}');
        $this->dropTable('{{%domain}}');
        $this->dropTable('{{%site_config}}');

        $this->dropTable('{{%site}}');
        $this->dropTable('{{%cm_field}}');

        $this->dropTable('{{%cm}}');
        $this->dropTable('{{%cm_article}}');
        $this->dropTable('{{%cm_index}}');


        $this->dropTable('{{%node}}');

    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
