<?php
namespace backend/helpers;
use Yii;

//Unify json response format(e.g., return ResponseJSON::success();)
class ResponseJSON
{
  private $defaultSuccessMessage = '操作成功';
  private $defaultFalseMessage = '操作失败';

  protected static function res($data, $url, $msg, $status){
    Yii::$app->response->format = Yii::$app->response::FORMAT_JSON;
  
    return [
      'status' => $status,
      'msg' => $msg,
      'url' => $url,
      'data' => $data
    ]; 
  }
  
  public static function success($data = [], $msg = self::$defaultSuccessMessage, $url = '', $status = 1){
    return $this->res($data, $url, $msg, $status);
  }

  public static function false($data = [], $msg = self::$defaultFalseMessage, $url = '', $status = 0){
    return $this->res($data, $url, $msg, $status);
  }
  
  public static function successWithMsg($msg = self::$defaultSuccessMessage, $data = [], $url = '', $status = 0){
    return $this->res($data, $url, $msg, $status);
  }
  
  public static function falseWithMsg($msg = self::$defaultFalseMessage, $data = [], $url = '', $status = 0){
    return $this->res($data, $url, $msg, $status);
  }
  
  public static function successWithUrl($url = '', $msg = self::$defaultSuccessMessage, $data = [], $status = 0){
    return $this->res($data, $url, $msg, $status);
  }
  
  public static function falseWithUrl($url = '', $msg = self::$defaultFalseMessage, $data = [], $status = 0){
    return $this->res($data, $url, $msg, $status);
  }
}
