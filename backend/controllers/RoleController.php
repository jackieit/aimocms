<?php

namespace backend\controllers;

use backend\models\AuthCategory;
use Yii;
use backend\models\AuthRole;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
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
        $controllers = $this->getControllers();
        var_dump($controllers);
        $dataProvider = new ActiveDataProvider([
            'query' => AuthRole::find(),
        ]);

        return $this->render('index', [
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
            return $this->redirect(['view', 'id' => $model->id]);
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
    public function actionCreateCate()
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
                return $this->redirect(['view', 'id' => $model->id]);
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
    /**
     * Get all actions by $controller
     *
     * @return mixed
     */
    public function actionGetAction($controller)
    {
        $controllerfile = Yii::getAlias($controller);
        $actions = [];
        $response = Yii::$app->response;
        $response->format = $response::FORMAT_JSON;
        if(!is_file($controllerfile)){
            return $actions;
        }

        $namespaceClass = str_replace('/','\\',trim($controller,'@.php'));

        $reflector = new \ReflectionClass($namespaceClass);
        $properties = $reflector->getMethods();

        var_dump($properties);

    }
    /**
     * Get all controllers
     * @return array
     */
    public  function getControllers()
    {
        $controller_path = ['@backend/controllers','@frontend/controllers'];
        $files = [];
        $basePath = '';
        foreach($controller_path as $location){
            $root   = Yii::getAlias($location);
            $handle = opendir($root);
            while (($path = readdir($handle)) !== false) {
                if ($path === '.git' || $path === '.svn' || $path === '.' || $path === '..') {
                    continue;
                }
                if(strpos($path,'Controller')===false)
                    continue;

                $files[] = $location.'/'.$path;

            }
            closedir($handle);
        }
        return $files;
    }
}
