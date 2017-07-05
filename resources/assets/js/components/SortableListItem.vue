<template>
    <li>
        <router-link :to="this.link">{{this.title}}</router-link>
        <a href="#" class="is-danger" @click.prevent="deleteItem">x</a>
    </li>
</template>

<script>
    export default {
        props: ['link', 'title', 'item', 'deleteHandler'],

        methods: {
            deleteItem(){
                swal({
                    title: "Are you sure?",
                    text: "You will not be able to recover this item!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, delete it!",
                    closeOnConfirm: false
                }, () => {
                    this.deleteHandler(this.item)
                });
            }
        }

    }
</script>
