<template>
    <div>
        <h2>Edit Project - {{project.title}}</h2>
        <project-form :uri="uri" method="put"></project-form>
    </div>
</template>

<script>
    import ProjectForm from '../components/ProjectForm';
    export default {
        components: {
            'project-form': ProjectForm,
        },
        data(){
            return {
                project: {},
                uri: null
            }
        },

        mounted(){
            ProjectModel.find(this.$route.params.slug) 
        },

        created(){
            Event.listen('project-single-changed', project => {
                this.project = project.data;
                this.uri = ProjectModel.link(project);
                Event.fire('add-form-project', project.data);
            });
        }

    }
</script>

<style>

</style>

