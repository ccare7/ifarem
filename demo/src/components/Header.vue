<template>
    <div>
        <el-breadcrumb separator="/">
            <el-breadcrumb-item v-for="item in items">{{item}}</el-breadcrumb-item>
        </el-breadcrumb>
    </div>
</template>

<script>
    export default {
        data() {
            return {

            }
        },
        props:{
            items:{
                type:Array,
                required:true
            }
        },
        mounted() {
        },
        methods: {},
        created() {
        },
    }
</script>

<style scoped>

</style>