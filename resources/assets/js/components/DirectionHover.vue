<template>
    <div class="direction-hover" :class="{
        'enter-hover-top': directionEnter == 0, 
        'enter-hover-right': directionEnter == 1,
        'leave-hover-bottom': directionLeave == 2
    }">
    </div>
</template>

<script>
    export default {
        props: ['directionEnter', 'directionLeave'],
    }
</script>

<style lang="scss">
.direction-hover{
    transition:1s transform;
    position:absolute;
    width:100%;
    height:100%;
    background:rgba(0, 0, 0, 0.5);
    top:-100%;
    z-index:1;
}

.enter-hover-top{
    top:-100%;
    left:0;
    transform:translate(0, 100%);
}

.enter-hover-right{
    top:0;
    left:-100%;
    transform:translate(100%, 0);
}
.leave-hover-bottom{
    top:-100%;
    left:0;
    transform:translate(0, 50%);
}
</style>
