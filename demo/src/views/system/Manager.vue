<template>
    <div>
        <nav-header style="margin-bottom: 20px" :items="['首页','系统设置']"></nav-header>
        <el-card>
            <el-tabs v-model="form.activeName">
                <el-tab-pane label="查看管理员" name="list">
                    <el-table :data="tableData">
                        <el-table-column label="id" prop="id"></el-table-column>
                        <el-table-column label="用户名" prop="username"></el-table-column>
                        <el-table-column label="状态" prop="state">
                            <template #default="cs">
                                <span v-if="cs.row.state==1">黑名单</span>
                                <span v-if="cs.row.state==0">白名单</span>
                            </template>
                        </el-table-column>
                        <el-table-column label="上次登录时间" prop="login_date">
                            <template #default="ce">
                                <span v-date="ce.row.login_date"></span>
                            </template>
                        </el-table-column>
                        <el-table-column label="操作" >
                            <template #default="tr">
                                <el-button type="text" size="mini" @click="resetPassword(tr.row.id)">重置密码</el-button>
                                <el-button type="text" v-if="tr.row.state==0" @click="State(tr.row.id)" size="mini">加入黑名单</el-button>
                                <el-button type="text" v-else="tr.row.state==1" size="mini" @click="State(tr.row.id)">移除黑名单</el-button>
                            </template>
                        </el-table-column>
                    </el-table>
                    <el-pagination
                        background
                        layout="prev, pager, next"
                        :total="total"
                        :page-size.sync=pageSize
                        :current-page.sync=page
                    >
                    </el-pagination>
                </el-tab-pane>
                <el-tab-pane label="添加管理员" name="add">
                    <el-form ref="form" :model="form">
                        <el-form-item prop="username" label="用户名">
                            <el-input v-model="form.username"></el-input>
                        </el-form-item>
                        <el-form-item>
                            <el-button type="primary" @click="add" size="mini">提交</el-button>
                        </el-form-item>
                    </el-form>
                </el-tab-pane>
            </el-tabs>
        </el-card>
    </div>
</template>

<script>
    import formtDate from "@/utils/formtDate";
    import Header from "@/components/Header";
    export default {
        data() {
            return{
                form:{
                    activeName:"list",
                },
                tableData:[],
                page:1,
                pageSize:5,
                total:30,
                login_time:0,
            }
        },
        mounted()
        {

        },
        components:{
            "nav-header":Header
        },
        methods:{
            add(){
                this.$refs.form.validate(valid=>{
                    if(valid){
                        this.axios.post("/api/Admin/addManager",this.form).then(res=>{
                            if(res.data.code==200){
                                console.log(res);
                                this.$message.success(res.data.msg);
                                this.$refs.form.resetFields();
                                this.fetchData();
                            }else{
                                this.$message.error(res.data.msg)
                            }
                        })
                    }
                })
            },
            fetchData(){
                this.axios.get('/api/Admin/getManager',{
                    params:{
                        page:this.page,
                        pageSize:this.pageSize,
                    }
                }).then(res=>{
                    if(res.data.code==200){
                        this.tableData=res.data.data;
                        this.total=res.data.total;
                    }
                })
            },
            resetPassword(id){
                this.axios.put('/api/Admin/resetPassword',{id}).then(res=>{
                    if(res.data.code==200){
                        this.$message.success("重置成功")
                    }else{
                        this.$message.error("重置失败")
                    }
                })
            },
            State(id){
                this.axios.put('/api/Admin/State',{id}).then(res=>{
                    if(res.data.code==200){
                        this.$message.success("操作成功");
                        this.fetchData();
                    }else{
                        this.$message.error("操作失败")
                    }
                })
            },
        },
        directives:{
            date: {
                inserted(el,bind){
                    el.innerHTML = formtDate(bind.value);
                }
            },
        },
        watch:{
            page:function () {
                this.fetchData();
            }
        },
        created()
        {
            this.fetchData()
        },
    }
</script>

<style scoped>

</style>