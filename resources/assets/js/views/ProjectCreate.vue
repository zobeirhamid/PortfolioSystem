<template>
    <div>
        <h2>Create a new Project</h2>
        <project-form uri="/api/projects" method="post"></project-form>
    </div>
</template>

<script>
    import ProjectForm from '../components/ProjectForm';
    export default {
        components: {
            'project-form': ProjectForm,
        },
    }
</script>

<style>

</style>
