<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%resource}}".
 *
 * @property integer $id
 * @property integer $node_id
 * @property integer $index_id
 * @property string  $path
 * @property integer $created_at
 * @property integer $status
 */
class Resource extends \yii\db\ActiveRecord
{
    public $file;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%resource}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['file'],'file','extensions'=>'gif,png,jpg'],
            //[['file'],'file','uploadRequired'],
            [['file'],'file','maxSize'=>20*1024*1024],
            [['node_id', 'index_id', 'created_at', 'status'], 'integer'],
            [['created_at'],'default','value'=> time() ],

            [['status'],'default','value'=>1],
            [['path'], 'string', 'max' => 80],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'       => Yii::t('app', 'ID'),
            'node_id'  => Yii::t('app', 'Node ID'),
            'index_id' => Yii::t('app', 'Index ID'),
            'path'     => Yii::t('app', 'Path'),
            'created_at' => Yii::t('app', 'Created At'),
            'status'     => Yii::t('app', 'Status'),
        ];
    }
}
