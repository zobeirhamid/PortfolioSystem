<template>
    <div>
        <category-list></category-list>
        <admin-project-list bag="admin-project-sticky-list"></admin-project-list>
    </div>
</template>

<script>
    import AdminProjectList from '../components/AdminProjectList';
    import CategoryList from '../components/CategoryList';

    export default {
        components:{
            'admin-project-list': AdminProjectList,
            'category-list': CategoryList
        },

        mounted(){
            ProjectModel.sticky();
        },

    }
</script>

<style>

</style>
