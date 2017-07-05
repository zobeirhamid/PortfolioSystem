<template>
    <li :class="{'is-active': isActive}" @click="clicked">
        <slot></slot>
    </li>
</template>

<script>
    export default {
        props:{
            selected: {default: false},
            name: {default: ''}
        },
        data(){
            return{
                isActive: false
            }

        },

        methods:{
            clicked(){
                this.$emit('clicked', this);
            }
        },

        mounted(){
            this.isActive = this.selected;
        }
    }
</script>

<style>

</style>
