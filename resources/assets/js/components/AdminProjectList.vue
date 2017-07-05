<template>
    <sortable-list :bag="this.bag" :collection="this.projects" :orderHandler="orderHasChanged">
        <sortable-list-item 
            v-for="project in projects" 
            v-if="project.isActive" 
            :key="project.id" 
            :link="{name: 'admin-project-edit', params: {slug: project.slug}}" 
            :title=project.title
            :item=project
            :deleteHandler="deleteProject"
        />
    </sortable-list>
</template>

<script>
    import SortableList from './SortableList';
    import SortableListItem from './SortableListItem';
    export default {
        props: ['bag'],
        components: {
            'sortable-list': SortableList,
            'sortable-list-item': SortableListItem
        },

        data(){
            return{
                projects: []
            }
        },

        methods: {
            orderHasChanged(project, index){
                axios.put('/api/projects/'+project.slug, {"position": index+1});
            },
            deleteProject(project){
                swal("Deleted!", "Your project has been deleted.", "success");
                axios.delete('/api/projects/'+project.slug);
                let index = this.projects.indexOf(project);
                this.projects.splice(index, 1);
            }
        },
        created(){
            Event.listen('project-all-changed', projects => {
                this.projects = projects.data;
            });
            Event.listen('project-sticky-changed', projects => {
                this.projects = projects.data;
            });
        }
    }
</script>
