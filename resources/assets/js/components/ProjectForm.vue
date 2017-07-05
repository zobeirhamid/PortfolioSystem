<template>
    <form @submit.prevent="onSubmit" @keydown="form.errors.clear($event.target.name)">
        <p class="form-control">
            <label>Title:</label>
            <input class="input" type="text" placeholder="Project's title" name="title" v-model="form.title">
            <span class="help is-danger" v-if="form.errors.has('title')" v-text="form.errors.get('title')"></span>
        </p>
        <p class="form-control">
            <label>Description:</label>
            <textarea class="textarea" placeholder="Project's description" name="description" v-model="form.description"></textarea>
            <span class="help is-danger" v-if="form.errors.has('description')" v-text="form.errors.get('description')"></span>
        </p>
        <p class="form-control">
            <label><input type="checkbox" v-model="form.sticky"> Sticky</label>
        </p>
        <p class="form-control">
            <label>Tags:</label>
            <input class="input" type="text" placeholder="Project's Tags" name="tags" v-model="form.tags">
            <span class="help is-danger" v-if="form.errors.has('tags')" v-text="form.errors.get('tags')"></span>
        </p>
        <p class="form-control">
            <label>Website:</label>
            <input class="input" type="text" placeholder="Project's website" name="website" v-model="form.website">
            <span class="help is-danger" v-if="form.errors.has('website')" v-text="form.errors.get('website')"></span>
        </p>
        <p class="form-control">
            <label>Preview:</label>
            <file-upload name="preview"></file-upload>
            <span class="help is-danger" v-if="files.errors.has('preview')" v-text="files.errors.get('preview')"></span>
        </p>
        <p class="form-control">
            <label>Demo:</label>
            <file-upload name="demo"></file-upload>
            <span class="help is-danger" v-if="files.errors.has('demo')" v-text="files.errors.get('demo')"></span>
        </p>
        <p class="form-control">
            <label>Image:</label>
            <file-upload name="image"></file-upload>
            <span class="help is-danger" v-if="files.errors.has('image')" v-text="files.errors.get('image')"></span>
        </p>
        <p class="form-control">
            <button class="button is-primary">Submit</button>
        </p>
    </form>
</template>

<script>
    import FileUpload from './FileUpload';
    export default {
        props: ['uri', 'method'],
        components: {'file-upload': FileUpload},
        watch: {
            uri: function(link){
                this.link = link;
            }
        },
        data(){
            return{
                form: new Form({
                    title: '',
                    description: '',
                    website: '',
                    tags: '',
                    sticky: false,
                }),

                files: new FileForm({
                    preview: null,
                    demo: null,
                    image: null,
                }, 'PUT'),
                link: null
            }
        },
        methods: {
            onSubmit(){
                this.form.submit(this.method, this.link)
                    .then(project => {
                        this.link = ProjectModel.link(project);
                        this.files.submit('post', this.link)
                            .then(project => {
                                router.push({name: 'admin-projects'});
                            })
                            .catch(error => console.log(error));
                    });
            }
        },
        created(){
            this.link = this.uri;
            Event.listen('add-file', file => {
                this.files[file.name] = file.stream;
            });
            Event.listen('add-form-project', project => {
                this.form.title = project.title;
                this.form.description = project.description;
                this.form.sticky = project.sticky;
                this.form.website = project.website;
                this.form.tags = project.tags;
            });
        }
    }
</script>
