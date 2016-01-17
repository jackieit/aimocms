<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%site}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $template
 * @property integer $is_publish
 * @property string $path
 * @property string $dsn
 * @property string $url
 * @property string $res_path
 * @property string $res_url
 * @property string $page_404
 * @property string $beian
 * @property string $seo_title
 * @property string $seo_keyword
 * @property string $seo_description
 *
 * @property Domain[] $domains
 * @property SiteConfig[] $siteConfigs
 */
class Site extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%site}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['is_publish'], 'integer'],
            [['name', 'seo_title'], 'string', 'max' => 80],
            [['template'], 'string', 'max' => 30],
            [['path', 'dsn', 'url', 'res_path', 'res_url', 'seo_description'], 'string', 'max' => 120],
            [['page_404', 'beian'], 'string', 'max' => 45],
            [['seo_keyword'], 'string', 'max' => 240],
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
            'template' => Yii::t('app', 'Template'),
            'is_publish' => Yii::t('app', 'Is Publish'),
            'path' => Yii::t('app', 'Path'),
            'dsn' => Yii::t('app', 'Dsn'),
            'url' => Yii::t('app', 'Url'),
            'res_path' => Yii::t('app', 'Res Path'),
            'res_url' => Yii::t('app', 'Res Url'),
            'page_404' => Yii::t('app', 'Page 404'),
            'beian' => Yii::t('app', 'Beian'),
            'seo_title' => Yii::t('app', 'Seo Title'),
            'seo_keyword' => Yii::t('app', 'Seo Keyword'),
            'seo_description' => Yii::t('app', 'Seo Description'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDomains()
    {
        return $this->hasMany(Domain::className(), ['site_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSiteConfigs()
    {
        return $this->hasMany(SiteConfig::className(), ['site_id' => 'id']);
    }
}
