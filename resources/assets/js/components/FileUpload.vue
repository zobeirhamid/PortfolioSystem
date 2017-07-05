<template>
    <input type="file" @change="fileChange">
</template>

<script>
    export default {
        props: {
            name: String,
            event: {
                type: String,
                default: 'add-file'
            }
        },
        data(){
            return{
                file: {
                    name: this.name,
                    stream: null
                },
            }
        },
        methods: {
            fileChange(e){
                this.file.stream = e.target.files[0];
                Event.fire(this.event, this.file);
            }
        },
    }
</script>

<style>

</style>
