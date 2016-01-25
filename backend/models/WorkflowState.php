<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%workflow_state}}".
 *
 * @property integer $id
 * @property string $name
 * @property integer $val
 * @property integer $is_inner
 */
class WorkflowState extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%workflow_state}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['val','name'],'required'],
            ['is_inner','default','value'=>2],
            [['val', 'is_inner'], 'integer'],
            [['name'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'val' => Yii::t('app', 'Val'),
            'is_inner' => Yii::t('app', 'Is Inner'),
        ];
    }
}
