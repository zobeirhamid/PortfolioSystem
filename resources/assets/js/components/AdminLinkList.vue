<template>
    <sortable-list :bag="this.bag" :collection="this.links" :orderHandler="orderHasChanged">
        <sortable-list-item 
            v-for="link in links" 
            :key="link.id" 
            :link="{name: 'admin-link-edit', params: {id: link.id}}" 
            :title=link.name
            :item=link
            :deleteHandler="deleteLink"
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
                links: []
            }
        },

        methods: {
            orderHasChanged(link, index){
                axios.put('/api/links/'+link.id, {"position": index+1});
            },
            deleteLink(link){
                swal("Deleted!", "Your link has been deleted.", "success");
                axios.delete('/api/links/'+link.id);
                let index = this.links.indexOf(link);
                this.links.splice(index, 1);
            }
        },
        created(){
            axios.get('/api/links')
                .then(response => {
                    this.links = response.data.data;
                    console.log(this.links);
                });
        }
    }
</script>
