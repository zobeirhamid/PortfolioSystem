<template>
    <ul class="admin-sortable-list" v-dragula="this.collection" :bag="this.bag">
        <slot></slot>
    </ul>
</template>

<script>
    export default {
        props: ['bag', 'orderHandler', 'collection'],
        methods: {
            orderHasChanged(){
                let changed;
                let currentPosition;
                this.collection.forEach((item, index) => {
                    currentPosition = index + 1;
                    if(item.position != currentPosition && !changed){
                        this.orderHandler(item, index);
                        changed = true;
                    }
                    if(item.position != currentPosition){
                        item.position = currentPosition;
                    }
                });
            },
        },

        created(){
            Vue.vueDragula.eventBus.$on('dropModel', this.orderHasChanged);
        }

    }
</script>
<style lang="scss">
@import "../../sass/variables";
.gu-mirror{
    margin:10px 0;
    padding:15px;
    width:100%;
    background:#202020;
    border:1px solid #282828;
    display:flex;
    justify-content:space-between;
    cursor:move;

    a{
        color:$primary-color;
        text-decoration:none;
    }

    .is-danger{
        color:red;
    }

}
.admin-sortable-list{
    margin:0;
    padding:0;

    li{
        @extend .gu-mirror
    }

}
</style>
