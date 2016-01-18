<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%site_config}}".
 *
 * @property integer $site_id
 * @property string $var
 * @property string $val
 *
 * @property Site $site
 */
class SiteConfig extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%site_config}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['site_id', 'var'], 'required'],
            [['site_id'], 'integer'],
            [['var'], 'string', 'max' => 45],
            [['val'], 'string', 'max' => 255],
            [['site_id'], 'exist', 'skipOnError' => true, 'targetClass' => Site::className(), 'targetAttribute' => ['site_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'site_id' => Yii::t('app', 'Site ID'),
            'var' => Yii::t('app', 'Var'),
            'val' => Yii::t('app', 'Val'),
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
