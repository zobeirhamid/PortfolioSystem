<template>
    <form @submit.prevent="onSubmit" @keydown="form.errors.clear($event.target.name)">
        <p class="form-control">
            <label>Name:</label>
            <input class="input" type="text" placeholder="Link's name" name="name" v-model="form.name">
            <span class="help is-danger" v-if="form.errors.has('name')" v-text="form.errors.get('name')"></span>
        </p>
        <p class="form-control">
            <label>FontAwesome-Icon:</label>
            <input class="input" type="text" placeholder="Link's logo" name="fa_logo" v-model="form.fa_logo">
            <span class="help is-danger" v-if="form.errors.has('fa_logo')" v-text="form.errors.get('fa_logo')"></span>
        </p>
        <p class="form-control">
            <label>Link:</label>
            <input class="input" type="text" placeholder="Link's URL" name="link" v-model="form.link">
            <span class="help is-danger" v-if="form.errors.has('link')" v-text="form.errors.get('link')"></span>
        </p>
        <p class="form-control">
            <button class="button is-primary">Submit</button>
        </p>
    </form>
</template>

<script>
    export default {
        props: ['uri', 'method'],
        data(){
            return{
                form: new Form({
                    name: '',
                    fa_logo: '',
                    link: '',
                }),
            }
        },
        methods: {
            onSubmit(){
                this.form.submit(this.method, this.uri)
                    .then(project => {
                        router.push({name: 'admin-links'});
                    });
            }
        },
        created(){
            Event.listen('add-form-link', link => {
                this.form.name = link.name;
                this.form.fa_logo = link.fa_logo;
                this.form.link = link.link;
            });
        }
    }
</script>
