<template>
    <div>
        <h2>Edit Link - {{link.name}}</h2>
        <link-form :uri=uri method="put"></link-form>
    </div>
</template>

<script>
    import LinkForm from '../components/LinkForm';
    export default {
        components: {'link-form': LinkForm},
        data(){
            return{
                link: {},
                uri: null

            }
        },

        mounted(){
            axios.get('/api/links/'+this.$route.params.id)
                .then(response => {
                    this.link = response.data.data;
                    this.uri = '/api/links/'+this.link.id;
                    Event.fire('add-form-link', response.data.data);
                });
        }

    }
</script>
