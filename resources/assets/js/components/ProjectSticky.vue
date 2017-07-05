<template>
    <div class="project-sticky">
        <project-list :data='projects'></project-list>
    </div>
</template>

<script>
    import ProjectList from './ProjectList';
    export default {
        components: {'project-list': ProjectList},
        data(){
            return{
                projects: []
            }
        },
        mounted(){
            ProjectModel.sticky();
        },
        created(){
            Event.listen('project-sticky-changed', projects => {
                this.projects = projects.data;
            });
        }
    }
</script>

<style lang="scss">
@import "../../sass/variables";
.project-sticky{
    padding-top:$categoryListHeight + 8px; 

    
    .project-list{
        justify-content:center;

        .project-preview {
            @media(min-width:640px){
                flex:1 1 33.33%;
            }

            .project-preview-animation{
                display:none;
            }

            .project-preview-title{
                display:none;
            }

            > div{
                img{
                    margin:auto;
                }
            }
        }
    }
}

.project-list{
    padding-top:8px;
}

</style>

