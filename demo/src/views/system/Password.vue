<template>
    <div>
        <nav-header style="margin-bottom: 20px" :items="['首页','系统设置']"></nav-header>
        <el-card type="flex" justify="center" align="middle">
            <el-form ref="form" :model="form" label-width="100px" style="width: 600px;" :rules="rules">
                <el-form-item label="原密码:" prop="password">
                    <el-input v-model="form.password"></el-input>
                </el-form-item>
                <el-form-item label="新密码" prop="newpassword1">
                    <el-input v-model="form.newpassword1"></el-input>
                </el-form-item>
                <el-form-item label="再次输入" prop="newpassword2">
                    <el-input v-model="form.newpassword2"></el-input>
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" @click="sub">确认修改</el-button>
                </el-form-item>
            </el-form>
        </el-card>
    </div>
</template>

<script>
    import Header from "../../components/Header";
    export default {
        data() {
            let change=(rule,value,callback)=>{
                let ru = /^[0-9a-zA-Z]{6,}$/
                if(ru.test(value)){
                    callback()
                }else{
                    callback(new Error("请输入至少6位数字或字母的新密码"))
                }
            }
            let change1=(rule,value,callback)=>{
                if(value==this.form.newpassword1){
                    callback()
                }else{
                    callback(new Error("请输入一致的密码"))
                }
            }
            return {
                form:{
                    username:sessionStorage.getItem("username"),
                    password:'',
                    newpassword1:'',
                    newpassword2:''
                },
                rules:{
                    password:{ required: true, message: '原密码不能为空', trigger: 'blur' },
                    newpassword1: [
                        {required: true, message: '新密码不能为空', trigger: 'blur'},
                        {validator:change,trigger: "blur"}
                    ],
                    newpassword2: [
                        {required: true, message: '密码输入不一致', trigger: 'blur'},
                        {validator:change1,trigger: "blur"}
                    ],
                }
            }

        },mounted()
        {

        },
        components:{
          "nav-header":Header
        },
        methods:{
            sub(){
                this.$refs.form.validate(valid=>{
                    if(valid) {
                        this.axios.put("/api/Admin/changePassword", this.form).then(res => {
                            if (res.data.code == 200) {
                                return this.$message.success("修改成功")
                                this.$refs.form.resetFields();
                            } else {
                                return this.$message.error("修改失败")
                            }
                        })
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

</style>