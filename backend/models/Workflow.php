<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%workflow}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $intro
 * @property integer $is_inner
 *
 * @property WorkflowStep[] $workflowSteps
 */
class Workflow extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function IS_INNER()
    {
        return ['1' => Yii::t('app','Yes'),'2'=>Yii::t('app','No')];
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%workflow}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'],'required'],
            [['intro'], 'string'],
            [['is_inner'], 'integer'],
            [['is_inner'],'default','value'=>2],
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
            'intro' => Yii::t('app', 'Intro'),
            'is_inner' => Yii::t('app', 'Is Inner'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWorkflowSteps()
    {
        return $this->hasMany(WorkflowStep::className(), ['wf_id' => 'id']);
    }
}
