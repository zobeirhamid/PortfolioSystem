<template>
    <div>
        <category-list></category-list>
        <link-list></link-list>
        <project-list></project-list>
    </div>
</template>

<script>
    import CategoryList from '../components/CategoryList';
    import ProjectList from '../components/ProjectList';
    import ProjectSticky from '../components/ProjectSticky';
    import LinkList from '../components/LinkList';
    export default {
        components: {
            'category-list': CategoryList,
            'project-list': ProjectList,
            'project-sticky': ProjectSticky,
            'link-list': LinkList
        }
    }
</script>

<style>
</style>
