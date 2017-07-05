<template>
    <div class="project-preview">
        <div>
            <router-link :to="{name: 'project-details', params: {slug: project.slug}}">
                <ul class="project-preview-categories">
                    <li v-for="category in project.categories.data">
                        {{category.name}}
                    </li>
                </ul>
                <div class="project-preview-image-container">
                    <div class="project-preview-image-loading">
                        <loading-circle color="#39B9C7" />
                    </div>
                    <img :src="project.preview" class="img-responsive project-preview-image">
                </div>
                <div class="project-preview-animation"></div>
            </router-link>
            <div class="project-preview-title">
                <router-link :to="{name: 'project-details', params: {slug: project.slug}}">
                    {{project.title}}
                </router-link>
            </div>
        </div>
    </div>
</template>

<script>
    import LoadingCircle from './LoadingCircle';
    export default {
        props: ['project'],
        components: {'loading-circle': LoadingCircle},
    }
</script>

<style lang="scss">
.project-preview{
    > div{
        position:relative;
        overflow:hidden;
    }

    &:hover{
        .project-preview-animation{
            top:-110%;
            left:100%;
        }
        .project-preview-title{
            background:black;
            box-shadow: 0 0 10px  black;
        }
        .project-preview-image{
            filter:grayscale(0);
            transform:scale(1.03);
        }
    }

    .project-preview-image-container{
        position:relative;
    }

    .project-preview-image{
        filter:grayscale(50%);
        position:relative;
        z-index:1;
        margin-top:-56.25%;
    }

    .project-preview-image-loading{
        position:relative;
        padding-top:56.25%;
    }

    .project-preview-animation{
        display:none;
        @media(min-width:990px){
            display:block;
            transition:1.5s all;
            position:absolute;
            width:200%;
            height:70%;
            transform:rotate(30deg);
            z-index:1;
            top:110%;
            left:-100%;
            background:rgba(255, 255, 255, 0.2);
        }
    }

    .project-preview-title{
        z-index:2;
        position:absolute;
        width:100%;
        bottom:0;
        padding:10px 15px;
        color:white;
        background:rgba(0, 0, 0, 0.75);
        font-weight:lighter;

        a{
            color:white;
            text-decoration:none;
        }
    }

    .project-preview-categories{
        z-index:3;
        position:absolute;
        top:0;
        width:100%;
        display:flex;
        margin:0;
        padding:5px;

        li{
            margin:5px;
            padding:5px 10px;
            list-style:none;
            border-radius:15px;
            background:rgba(0, 0, 0, 0.5);
            //border-bottom:2px solid rgba(0, 0, 0, 0.5);
            font-size:0.8em;
            color:white;
        }
    }
}

</style>
