<?php

namespace backend\controllers;

use backend\models\AuthCategory;
use Yii;
use backend\models\AuthRole;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RoleController implements the CRUD actions for AuthRole model.
 */
class RoleController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'category-delete' =>['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all AuthRole models.
     * @return mixed
     */
    public function actionIndex()
    {

        $dataProvider = new ActiveDataProvider([
            'query' => AuthRole::find()->with('authCategory')->orderBy(['cat_id'=>SORT_ASC]),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * Lists all AuthRole category models.
     * @return mixed
     */
    public function actionCategoryList()
    {
         $dataProvider = new ActiveDataProvider([
            'query' => AuthCategory::find(),
        ]);

        return $this->render('category-list', [
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * Displays a single AuthRole model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new AuthRole model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AuthRole();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing AuthRole model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        //$model->controllers = explode(',',$model->controllers);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing AuthRole model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    /**
     * Deletes an existing AuthRoleCategory model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionCategoryDelete($id)
    {
        AuthCategory::findOne($id)->delete();

        return $this->redirect(['category-list']);
    }
    /**
     * Finds the AuthRole model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AuthRole the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AuthRole::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    /**
     * Creates a new AuthRole model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCategoryCreate()
    {
        $model = new AuthCategory();
        $response =  Yii::$app->response;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if(Yii::$app->request->isAjax){
                $id = $model->id;
                $data   =  $model->find()->asArray()->all();
                $result = [
                    'selected'=> $id,
                    'data' => $data,
                ];
                $response->format = $response::FORMAT_JSON;
                return $result;
            }else{
                //return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            if(Yii::$app->request->isAjax) {
                $response->format = $response::FORMAT_JSON;
                return $model->getErrors();
            }
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
    public function actionCategoryEdit($id)
    {
        $model = AuthCategory::findOne($id);
        //$model->findOne($id);
        $response =  Yii::$app->response;
        $result['success'] = 0;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if(Yii::$app->request->isAjax){

                $result = [
                    'success'=> 1,
                ];
                $response->format = $response::FORMAT_JSON;
                return $result;
            }else{
                //return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        return $result;
    }
    /**
     * Get all actions by $controller
     *
     * @return mixed
     */
    public function actionGetAction($controller)
    {

        $slash = strpos($controller,'/');
        $module = substr($controller,0,$slash);
        $controller_file = Yii::getAlias($controller);
        $actions = [];
        $response = Yii::$app->response;
        $response->format = $response::FORMAT_JSON;
        if(!is_file($controller_file)){
            return $actions;
        }
        $id = Inflector::camel2id(substr(basename($controller_file), 0, -14));

        $namespaceClass = str_replace('/','\\',trim($controller,'@.php'));
        $reflector = new \ReflectionClass($namespaceClass);
        $methods = $reflector->getMethods();
        foreach($methods as $method){
            $name = $method->getName();
            if($method->isPublic() && !$method->isStatic() && strpos($name, 'action') === 0 && $name !== 'actions'){
                $action =substr($name,6);
                $actions[] = $module.'/'.$id.'/'.Inflector::camel2id($action);
            }
        }
        return $actions;
    }
    /**
     * Get all controllers
     * @return array
     */
    public  function getControllers()
    {
        $controller_path = ['@backend/controllers','@frontend/controllers'];
        $files = [];
        foreach($controller_path as $location){
            $root   = Yii::getAlias($location);
            $handle = opendir($root);
            while (($path = readdir($handle)) !== false) {

                if(strpos($path,'Controller')===false)
                    continue;

                $files[] = $location.'/'.$path;

            }
            closedir($handle);
        }
        return $files;
    }
}
