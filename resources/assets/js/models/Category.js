class Category{
    constructor(){
        this.allData = {data: [], event: 'category-all-changed'};
    }
    find(slug, then){
        axios.get('/api/categories/'+slug+'?include=projects,tags')
            .then(response => then(response.data));
    }

    all(then){
        var data;
        axios.get('/api/categories?include=projects,projects.categories')
            .then(response => this.setData(this.allData, response.data));
    }

    setData(container, data){
        container.data = data;
        Event.fire(container.event, container.data);
    }
}

export default new Category;
