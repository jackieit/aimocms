<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%auth_role}}".
 *
 * @property integer $id
 * @property integer $cat_id
 * @property string $name
 * @property string $description
 * @property string $controllers
 * @property string $actions
 */
class AuthRole extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%auth_role}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cat_id'], 'integer'],
            [['cat_id','name','description'],'required'],
            [['controllers', 'actions'], 'safe'],
            [['name'], 'string', 'max' => 30],
            [['rules'], 'string', 'max' => 80],
            [['description'], 'string', 'max' => 80],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'cat_id' => Yii::t('app', 'Cat ID'),
            'name' => Yii::t('app', 'Name'),
            'rules' => Yii::t('app','Rules'),
            'description' => Yii::t('app', 'Description'),
            'controllers' => Yii::t('app', 'controllers'),
            'actions' => Yii::t('app', 'actions'),
            'authCategroy.name'=> Yii::t('app','Category Name')
        ];
    }
    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {

            $this->controllers = trim(implode(',',$this->controllers),',');

            $this->actions     = trim(implode(',',$this->actions),',');
            return true;
        } else {
            return false;
        }
    }
    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {

           $auth = Yii::$app->authManager;
           $permission = $auth->getPermission($this->name);
           // var_dump($permission);
           if($permission){
               $auth->remove($permission);
           }
           $ruleClass = $this->rules;
           $rule = null;
           if(!empty($this->rules)){

               $rule = new $ruleClass;
               $auth->add($rule);
           }
           $permission = $auth->createPermission($this->name);
           $permission->description = $this->description;
           if(!empty($rule) && isset($rule->name)){
               $permission->ruleName = $rule->name;
           }
           $permission->data = $this->controllers.'|'.$this->actions;

           $auth->add($permission);

           parent::afterSave($insert, $changedAttributes);

        return true;

    }

    /**
     *
     */
    public function afterDelete()
    {
        parent::afterDelete();
        $auth = Yii::$app->authManager;
        $permission = $auth->getPermission($this->name);
        $auth->remove($permission);
    }
    public function getAuthCategory()
    {
        return $this->hasOne(AuthCategory::className(),['id'=>'cat_id']);
    }
}
