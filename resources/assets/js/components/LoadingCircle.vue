<template>
    <div class="loading-container">
        <div class="loading-circle" :style={borderColor:this.color}></div>
    </div>
</template>

<script>
    export default {
        props: ['color'],
    }
</script>

<style lang="scss">
    .loading-container{
        top:0;
        position:absolute;
        width:100%;
        height:100%;
        color:#FFF;
        display:flex;
        justify-content:center;
        align-items:center;
    }

    @keyframes rotate {
        from {transform: rotate(0)}
        to {transform: rotate(360deg)}
    }

    .loading-circle{
        width:24px;
        height:24px;
        border-top:2px solid white;
        border-radius:50%;
        animation: rotate 1s infinite linear;
    }
</style>
