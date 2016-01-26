<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%workflow_step}}".
 *
 * @property integer $id
 * @property integer $wf_id
 * @property integer $role_id
 * @property string $name
 * @property string $before_state
 * @property string $after_state
 * @property integer $append_note
 * @property string $intro
 *
 * @property Workflow $wf
 */
class WorkflowStep extends \yii\db\ActiveRecord
{
    public static function appendNode()
    {
        return [
            '1' => Yii::t('app','Yes'),
            '2' => Yii::t('app','No'),
        ];
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%workflow_step}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['wf_id',  'append_note'], 'integer'],
            [['intro','role_id'], 'string'],
            [['name'], 'string', 'max' => 45],
            [['append_note'],'default','value'=>2],
            [['before_state', 'after_state'], 'string', 'max' => 80],
            [['wf_id'], 'exist', 'skipOnError' => true, 'targetClass' => Workflow::className(), 'targetAttribute' => ['wf_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'    => Yii::t('app', 'ID'),
            'wf_id' => Yii::t('app', 'Wf ID'),
            'role_id' => Yii::t('app', 'Role ID'),
            'name'    => Yii::t('app', 'Name'),
            'before_state' => Yii::t('app', 'Before State'),
            'after_state' => Yii::t('app', 'After State'),
            'append_note' => Yii::t('app', 'Append Note'),
            'intro' => Yii::t('app', 'Intro'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWf()
    {
        return $this->hasOne(Workflow::className(), ['id' => 'wf_id']);
    }
}
