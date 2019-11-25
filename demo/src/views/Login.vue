<template>
    <div class="bg">
        <el-row type="flex" justify="center" align="middle">
            <el-col :span="6" class="box">
                <h3>鲜果管理系统</h3>
                <el-form label-width="80px" ref="form" :rules="rules" :model="form">
                    <el-form-item prop="username" label="用户名：">
                        <el-input v-model="form.username"></el-input>
                    </el-form-item>
                    <el-form-item prop="password" label="密码：">
                        <el-input v-model="form.password" type="password"></el-input>
                    </el-form-item>
                    <el-form-item prop="num" label="验证码：" :span="12">
                        <el-col :span="12">
                            <el-input v-model="form.num"></el-input>
                        </el-col>
                        <el-col :span="12">
                            <img :src="src" alt="" @click="change" style="width: 100%;height: 100%" >
                        </el-col>
                    </el-form-item>
                    <el-form-item>
                        <el-col :span="5">
                            <el-button type="primary" @click="sub">登录</el-button>
                        </el-col>
                    </el-form-item>
                </el-form>
            </el-col>
        </el-row>
    </div>
</template>

<script>
    import formtDate from "../utils/formtDate";
    export default {
        data() {
            return {
                form:{
                    username:"",
                    password:"",
                    num:"",
                },
                rules: {
                    username:{required:true,message:"用户名不能为空",trigger:'blur'},
                    password:{required:true,message:"密码不能为空",trigger:'blur'},
                    num:{required:true,message:"验证码不能为空",trigger:'blur'},
                },
                src:'/api/Admin/captcha'
            }
        },
        mounted()
        {

        },
        methods:{
            change(){
                this.src="/api/Admin/captcha?t="+Date.now();
            },
            sub(){
                this.$refs.form.validate(valid=>{
                    if(valid){
                        this.axios.post("/api/Admin/login",this.form).then(res=>{
                            if(res.data.code==200){
                                if(res.data.state==1){
                                    this.$message.error("账户暂时无法登录");
                                }else{
                                    this.$message.success("登录成功,上次登录时间为:"+formtDate(res.data.dat));
                                    sessionStorage.setItem('username',this.form.username);
                                    sessionStorage.setItem('level',res.data.level);
                                    this.$router.push('/admin');
                                }
                            }else{
                                this.$message.error(res.data.msg)
                            }
                        })
                    }else{
                        this.$message.error("验证失败")
                    }
                })
            }
        },
        created()
        {

        },
    }
</script>

<style scoped>
    .bg{
        width: 100vw;
        height: 100vh;
        background: url(../assets/20171122191532_f2975b.jpg)no-repeat center/cover;
    }
    .box{
        width: 500px;
        height: 465px;
        padding: 30px;
        border-radius: 10px;
        background: rgba(253, 255, 253, 0.5);
    }
    .el-row{
        height: 100vh;
    }
    h3{
        line-height: 100px;
    }
</style>