<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%domain}}".
 *
 * @property integer $id
 * @property integer $site_id
 * @property string $domain
 * @property integer $main
 *
 * @property Site $site
 */
class Domain extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%domain}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['site_id', 'main'], 'integer'],
            [['domain'],'required'],
            [['domain'], 'string', 'max' => 80],
            [['site_id'], 'exist', 'skipOnError' => true, 'targetClass' => Site::className(), 'targetAttribute' => ['site_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'site_id' => Yii::t('app', 'Site ID'),
            'domain' => Yii::t('app', 'Domain'),
            'main' => Yii::t('app', 'Main'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSite()
    {
        return $this->hasOne(Site::className(), ['id' => 'site_id']);
    }
}
