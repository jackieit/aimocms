<?php

namespace backend\models;

use common\models\Site;
use Yii;

/**
 * This is the model class for table "{{%node}}".
 *
 * @property integer $id
 * @property integer $site_id
 * @property integer $cm_id
 * @property string $name
 * @property integer $is_real
 * @property string $v_nodes
 * @property integer $parent
 * @property string $slug
 * @property integer $workflow
 * @property string $tpl_index
 * @property string $tpl_detail
 * @property integer $status
 * @property string $seo_title
 * @property string $seo_keyword
 * @property string $seo_description
 */
class Node extends \common\models\Node
{
    public $parent;
    public $parent_txt;

    /**
     * @return array
     */
    public static function isReal()
    {
        return ['1' => Yii::t('app','Yes'),'2'=>Yii::t('app','No')];
    }
    public static function nodeStatus()
    {
        return [
            '1'  => Yii::t('app','Normal'),
            '-1' => Yii::t('app','Deleted'),
        ];
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {

        return [
            [['site_id','cm_id','name','is_real','workflow'],'required'],
            [['parent','parent_txt'],'required','on'=>'create'],
            [['site_id', 'cm_id', 'is_real', 'parent', 'workflow', 'status'], 'integer'],
            [['v_nodes'], 'string'],
            [['status','cm_id','workflow','is_real'] ,'default','value'=> 1],
            [[ 'parent'] ,'default','value'=> 0],
            [['name'], 'string', 'max' => 20],
            [['slug', 'tpl_index', 'tpl_detail'], 'string', 'max' => 45],
            [['seo_title'], 'string', 'max' => 80],
            [['seo_keyword'], 'string', 'max' => 240],
            [['seo_description'], 'string', 'max' => 120],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'site_id' => Yii::t('app', 'Node Site ID'),
            'cm_id' => Yii::t('app', 'Node Cm ID'),
            'name' => Yii::t('app', 'Node Name'),
            'is_real' => Yii::t('app', 'Node Is Real'),
            'v_nodes' => Yii::t('app', 'Node V Nodes'),
            'parent' => Yii::t('app', 'Node Parent'),
            'parent_txt' => Yii::t('app', 'Node Parent'),
            'slug' => Yii::t('app', 'Node Slug'),
            'workflow' => Yii::t('app', 'Node Workflow'),
            'tpl_index' => Yii::t('app', 'Node Tpl Index'),
            'tpl_detail' => Yii::t('app', 'Node Tpl Detail'),
            'status' => Yii::t('app', 'Node Status'),
            'seo_title' => Yii::t('app', 'Seo Title'),
            'seo_keyword' => Yii::t('app', 'Seo Keyword'),
            'seo_description' => Yii::t('app', 'Seo Description'),
        ];
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $default   = $scenarios['default'];
        unset($default['cm_id'],$default['parent'],$default['parent_txt']);
        $scenarios['update'] = $default;
        return $scenarios;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSite()
    {
        return $this->hasOne(Site::className(),['id'=>'site_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCm()
    {
        return $this->hasOne(Cm::className(),['id'=>'cm_id']);
    }
/*    public function getFather()
    {
        return $this->hasOne(self::className(),['id'=>'parent']);
    }*/
    public function getWorkflow()
    {
        return $this->hasOne(Workflow::className(),['id'=>'workflow']);
    }

    /**
     * @return int
     */
    public function delete()
    {
        $condition = [
            'and',
            ['=','site_id',$this->site_id],
            ['>=', 'lft', $this->lft],
            ['<=', 'rgt', $this->rgt],
        ];
        return $this->updateAll(['status'=>-1],$condition);
    }
/*    public function getParentNode()
    {
        return $this->hasOne(self::className(),['parent'=>'id']);
    }*/
}
