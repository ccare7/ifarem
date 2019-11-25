<?php


namespace app\api\controller;


use think\controller\Rest;

class Type extends Rest
{
    public function type(){
        $method=$this->method;
        switch ($method){
            case 'get': return $this->get();
            case 'post': return $this->post();
            case 'put': return $this->put();
            case 'delete': return $this->delete();
        }
    }
    private function get(){
        $model = model('type');
        $sel= $model->select();
        return json(['data'=>$sel]);
    }
    private function post(){

    }
    private function put(){

    }
    private function delete(){

    }
}