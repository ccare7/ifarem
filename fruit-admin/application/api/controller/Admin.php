<?php


namespace app\api\controller;

use think\captcha\Captcha;
use think\console\command\make\Model;
use think\helper\Hash;

class Admin
{
//    得到一个哈希值
    private function createHash(){
        return md5(time());
    }
//e0a5aaccc6540b370d280fcd1f5b1aa7
    private function createPassword($password,$hash){
        return md5(sha1($password).$hash);
    }
//9024ee41b5b70845f5373c6635e9a532

    // 管理员登录
    public function login(){
       $data = input('post.');
       $username=$data['username'];
       $num = $data['num'];
       $captcha= new Captcha();
       if(!$captcha->check($num)){
           return json(["msg"=>"验证码错误","code"=>400]);
       }
       $model =model('admin');
       $sel=$model->where("username",$username)->find();

       if(isset($sel)){
           $password=$data['password'];
           $hash=$sel->hash;
           $login_time =$sel->login_date;
           if($sel->password===$this->createPassword($password,$hash)){
               $sel->save(['login_date'=>time()]);
               return json(["msg"=>"登录成功","code"=>200,"dat"=>$login_time,"state"=>$sel->state,"level"=>$sel->level]);
           }else{
               return json(["msg"=>"登录失败","code"=>400]);
           }
       }else{
           return json(["msg"=>"用户名不存在","code"=>400]);
       }

    }
    // 修改密码
    public function changePassword(){
        $data = input('put.');
        $username = $data['username'];
        $model = model("admin");
        $sel = $model->where("username",$username)->find();
        $password = $this->createPassword($data['password'],$sel->hash);
        if($password!==$sel->password){
            return json(["code"=>400,"msg"=>"原密码错误"]);
        }
        $newpassword = $this->createPassword($data['newpassword1'],$sel->hash);
        $res = $sel->save(['password'=>$newpassword]);
        if($res==1){
            return json(["code"=>200,"msg"=>"修改成功"]);
        }else{
            return json(["code"=>400,"msg"=>"修改失败"]);
        }
    }
    //  添加管理员
    public function addManager(){
        $data = input('post.');
        $username = $data['username'];
        $hash = $this->createHash();
        $password = $this->createPassword('123456',$hash);
        $model = model("admin");
        $sel = $model->where('username',$username)->find();
        if($sel){
            return json(['code'=>400,"msg"=>"管理员-已存在"]);
        }
        $sel=$model->save(['username'=>$username,'password'=>$password,'hash'=>$hash]);
        if($sel==1){
            return json(['code'=>200,'msg'=>'添加成功']);
        }else{
            return json(['code'=>400,'msg'=>'添加失败']);
        }
    }
    // 获取管理员
    public function getManager(){
        $data = input('get.');
        $page = $data['page'];
        $pageSize = $data['pageSize'];
        $start = ($page-1)*$pageSize;
        $model = model('admin');
        $sel = $model-> where('level',1)->limit($start,$pageSize)->select();
        $total = $model ->where('level',1)->count();
        return json(["code"=>200,"msg"=>"查询成功","total"=>$total,'data'=>$sel]);
    }
    // 验证按配置项
    public function captcha(){
        $config =    [
            // 验证码字体大小
            'fontSize'    =>    15,
            // 验证码位数
            'length'      =>    4,
            // 关闭验证码杂点
            'useNoise'    =>   false,
            'imageW'      =>   140,
            'imageH'      =>   30
        ];
        $captcha = new Captcha($config);
        return $captcha->entry();
    }
    //验证码
    public function resetPassword(){
       $id = input('put.id');
       $model = model('admin');
       $sel = $model->where('id',$id)->find();
       $hash = $sel->hash;
       $password = $this->createPassword('123456',$hash);
       $er = $sel->isUpdate(true)->save(['password'=>$password]);
       if($er==1){
           return json(['code'=>200,'msg'=>'重置成功']);
       }else{
           return json(['code'=>400,'msg'=>'重置失败']);
       }
    }
    //密码重置
    public function State(){
        $id = input('put.id');
        $model = model('admin');
        $sel = $model->where('id',$id)->find();
        if($sel->state==1){
            $state = 0;
        }else{
            $state = 1;
        }
        $er = $sel->isUpdate(true)->save(['state'=>$state]);
        if($er==1){
            return json(['code'=>200,'msg'=>'操作成功']);
        }else{
            return json(['code'=>400,'msg'=>'操作失败']);
        }
    }
}