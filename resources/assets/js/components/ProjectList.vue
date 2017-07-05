<template>
    <div class="project-list container">
        <project-preview v-for="project in projects" v-if="project.isActive" :project="project"></project-preview>
    </div>

</template>

<script>
    import ProjectPreview from './ProjectPreview';
    export default {
        components: {'project-preview': ProjectPreview},
        props: ['data'],
        data(){
            return{
                projects: []
            }
        },
        watch: {
            data: function(projects){
                this.projects = projects;
            }
        },

        mounted(){
            ProjectModel.all();
        },
        created(){
            if(this.data){
                this.projects = this.data;
            }
            else{
                Event.listen('project-all-changed', projects => {
                    this.projects = projects.data;
                });
            }
        }
    }
</script>
<style lang="scss">
@import "../../sass/variables";
.project-list{ 
    display:flex; 
    flex-direction:column;
    padding:5px; 
    padding-top:$categoryListHeight + 8px; 
    @media(min-width:640px){
        flex-direction:row;
    }
    @media(min-width:840px){
        padding:5px 100px;
        padding-top:$categoryListHeight + 8px; 
    }

    flex-wrap:wrap; 
    > div{
        @media(min-width:640px){
            flex:0 1 33.33%;
        }
        padding:5px;
    }
}
</style>

