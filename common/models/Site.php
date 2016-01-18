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
    public $domain_txt;

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
            [['name','template','url','domain_txt'],'required'],
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
            'name' => Yii::t('app', 'Site name'),
            'template' => Yii::t('app', 'Template themes'),
            'is_publish' => Yii::t('app', 'Is Publish'),
            'path' => Yii::t('app', 'Publish Path'),
            'dsn' => Yii::t('app', 'Publish Dsn'),
            'url' => Yii::t('app', 'Publish Url'),
            'res_path' => Yii::t('app', 'Resource Path'),
            'res_url' => Yii::t('app', 'Resource Url'),
            'page_404' => Yii::t('app', 'Page 404 templete'),
            'beian' => Yii::t('app', 'Beian'),
            'seo_title' => Yii::t('app', 'Seo Title'),
            'seo_keyword' => Yii::t('app', 'Seo Keyword'),
            'seo_description' => Yii::t('app', 'Seo Description'),
            'domain_txt' => Yii::t('app','Domain'),
        ];
    }
    /**
     * @inheritdoc
     */
    public function afterSave($insert,$changedAttributes)
    {
        parent::afterSave($insert,$changedAttributes);
        $domain = preg_split("/\r\n/isU",trim($this->domain_txt));

        $site_id = $this->getPrimaryKey();
        $domains = Domain::find()->where(['site_id' => $site_id])->all();
        foreach($domain as $key => $dm){
            $dm = trim($dm);
            if(empty($dm))
                continue;
            $domain_model = $this->findModelByDomain($domains,$dm);
            if(!isset($domain_model)){
                $domain_model = new Domain();
            }
            if($key===0){
                $domain_model->main = 1;
            }else{
                $domain_model->main = 0;
            }
            $domain_model->domain = $dm;
            $domain_model->site_id = $this->id;
            $domain_model->save();
        }


    }

    /**
     * @inheritdoc
     * @return common\models\Domain
     */
    public function findModelByDomain($models,$domain)
    {
        if($models ===null)
            return null;
        foreach($models as $model){
            if($model->domain === $domain){
                return $model;
            }
        }
        return null;
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
