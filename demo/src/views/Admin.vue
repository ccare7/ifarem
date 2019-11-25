<template>
    <el-container style="height: 100vh; border: 1px solid #eee">
        <el-aside width="auto" style="background-color: #fff">
            <el-menu default-active="1-1" class="el-menu-vertical-demo" style="height:90vh" @open="handleOpen" @close="handleClose" :collapse="isCollapse" :router="true">
                <el-submenu v-for="item in routes" :index="item.name">
                    <template slot="title">
                        <i class="el-icon-location"></i>
                        <span slot="title">{{item.meta.title}}</span>
                    </template>
                    <el-menu-item v-for="nav in item.children" :index="nav.name" :route="{name:nav.name}">
                        {{nav.meta.title}}
                    </el-menu-item>
                </el-submenu>
            </el-menu>
        </el-aside>

        <el-container  router='true'>
            <el-header class="Co" type="flex" justify="center" align="middle">
                <el-row style="height: 100%;">
                    <el-col :span="2" style="line-height: 55px;">
                        <el-radio-group v-model="isCollapse" size="mini">
                            <el-radio-button :label="false">展开</el-radio-button>
                            <el-radio-button :label="true">收起</el-radio-button>
                        </el-radio-group>
                    </el-col>
                    <el-col :span="15" style="line-height: 60px; text-align: left">
                        <h2>鲜果汇管理系统</h2>
                    </el-col>
                    <el-col :span="4" style="line-height: 60px;">
                        时间：{{nowTime}}
                    </el-col>
                    <el-col :span="2" style="line-height: 60px;">
                        管理员： {{user}}
                    </el-col>
                    <el-col :span="1" style="line-height: 60px;">
                        <el-button type="text" @click="outline">退出登录</el-button>
                    </el-col>
                </el-row>
            </el-header>
            <el-main>
                <router-view/>
            </el-main>
        </el-container>

    </el-container>
</template>

<script>
    import formtDate from "../utils/formtDate";

    export default {
        data() {
            return{
                activeIndex: '1',
                activeIndex2: '1',
                nowTime:'',
                isCollapse: false,
                user:sessionStorage.getItem('username'),
                routes:[]
            }
        },
        mounted(){
            if(sessionStorage.getItem('level')==1){
                this.routes=this.$store.state.obj2.children;
            }else{
                this.routes=this.$store.state.obj1.children;
                console.log(this.$store.state.obj1.children)
            }
        },
        methods:{
            handleOpen(key, keyPath) {

            },
            handleClose(key, keyPath) {

            },
            outline(){
                sessionStorage.removeItem("username");
                sessionStorage.removeItem('level');
                this.$router.push("login");
                location.reload();
            }
        },
        created()
        {
            setInterval(()=>{
                let gr = Date.now();
                this.nowTime = formtDate(gr/1000);
            },1000)
        },
    }
</script>

<style>
    .Mo{
        margin: 0;
        padding: 0;
    }
    .Co{
        border-bottom: 1px solid #ccc;
    }
    .el-menu-vertical-demo:not(.el-menu--collapse) {
        width: 200px;
        min-height: 400px;
    }
</style>