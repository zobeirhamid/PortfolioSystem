<template>
    <div class="top-bar" :class="{'categories-list-scrolled': hasScrolled}">
        <div>
            <ul>
                <tab v-for="(category, index) in categories" @clicked="setActive" :selected="index == 0" :name="category.name">
                    <a href="#" @click.prevent>{{category.name}}</a>
                </tab>
            </ul>
        </div>
    </div>
</template>

<script>
    import Tab from './Tab';
    export default {
        components: {'tab': Tab},

        data(){
            return{
                categories: {},
                tabs: [],
                hasScrolled: false
            }
        },

        methods: {
            setActive(event){
                this.tabs.forEach(tab => {
                    tab.isActive = tab == event;
                });
                if(ProjectModel.allData.data){
                    ProjectModel.allData.data.data.forEach(project => {
                        if(project.tags.includes(event.name) || event.name == 'all') project.isActive = true;
                        else project.isActive = false;
                    });
                }


            },

            handleScroll(){
                this.hasScrolled = window.scrollY > 0;
            }
        },

        mounted(){
            CategoryModel.all();
        },

        created(){
            Event.listen('category-all-changed', categories => {
                let categoriesData = [];
                Object.assign(categoriesData, categories.data);
                categoriesData.unshift({
                    'name': 'all',
                    'projects': ProjectModel.allData.data
                });
                this.categories = categoriesData;
            });
            this.tabs = this.$children;
            window.addEventListener('scroll', this.handleScroll);
        }

    }
</script>

<style lang="scss">
@import "../../sass/variables";
.top-bar{
    position:absolute;
}
.categories-list-scrolled{
    position:fixed;
    ul{
        li{
            background: rgba(0, 0, 0, 0.75);
        }
    }
}
</style>
