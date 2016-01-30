<?php

namespace backend\controllers;
use backend\models\Resource;
use Yii;
use yii\web\UploadedFile;

class ResourceController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionListBy()
    {
        return $this->render('list-by');
    }

    public function actionMove()
    {
        return $this->render('move');
    }

    public function actionUpload()
    {
        $request = Yii::$app->request;
        $response = Yii::$app->response;
        $response->format = $response::FORMAT_JSON;
        $result = [
            'result' => null,
            'msg'    => null,
            'id'     => mt_rand(100,999),
        ];
        if($request->isPost){
            $model = new Resource();
           // d($_FILES);
            $uploader = UploadedFile::getInstance($model,'file');
            if($model->validate()){
                //$uploader->saveAs();
            }else{
                $msg = $model->getErrors();
                $result['msg'] = $msg;
            }

        }
        return $result;
        //return $this->render('upload');
    }

}
