<template>
    <div class="project-details">
        <nav class="top-bar">
            <ul class="container">
                <router-link to="/" tag="li" exact>
                    <a>Projects</a>
                </router-link>
            </ul>
        </nav>
        <div class="project-details-content">
            <h1>
                {{project.title}}<br>
            </h1>
            <small>{{project.tags}}</small>
            <p class="project-details-description">
                {{project.description}}
            </p>
            <div class="container">
                <ul class="project-details-links">
                    <li v-if="project.website"><a :href="project.website">Website</a></li>
                    <li v-if="project.demo"><a :href="project.demo">Demo</a></li>
                    <li v-if="project.image"><a :href="project.image">Design</a></li>
                </ul>
                <div class="panel">
                    <img class="img-responsive" :src="project.preview">
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                project: {}
            }
        },

        mounted(){
            ProjectModel.find(this.$route.params.slug);
        },

        created(){
            Event.listen('project-single-changed', project => {
                this.project = project.data;
            });
        }
    }
</script>

<style lang="scss">
@import "../../sass/variables";
.project-details{
    text-align:center;

    .container{
        max-width:600px;
    }
    
    small{
        font-size:1em;
        font-weight:600;
    }
    .project-details-description{
        font-weight:200;
        font-size:1.2em;
        line-height:1.5em;
        max-width:1200px;
        margin:10px auto;
        padding:15px;
    }

    .project-details-links{
        display:flex;
        align-items:center;
        justify-content:center;
        margin:0;
        padding:0;

        li{
            list-style:none;
            margin:15px 10px;
            padding:5px 10px;
            border-radius:20px;
            font-size:1.2em;
            //box-shadow:0 2px 10px rgba(0, 0, 0, 0.3);

            a{
                color: $primary-color;
                text-decoration:none;
            }
        }
    }

    .project-details-content{
        font-family: 'Lato', sans-serif;
        padding-top:$categoryListHeight + 15px; 
        img{
            margin:auto;
        }
    }

}

</style>
