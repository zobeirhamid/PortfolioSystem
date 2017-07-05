class Project{
    constructor(){
        this.allData = {data: [], event: 'project-all-changed'};
        this.singleData = {data: {}, event: 'project-single-changed'};
        this.stickyData = {data: {}, event: 'project-sticky-changed'};
    }

    find(slug){
        axios.get('/api/projects/'+slug+'?include=categories')
            .then(response => this.setData(this.singleData, response.data));
    }

    all(){
        axios.get('/api/projects?include=categories')
            .then(response => this.setData(this.allData, response.data));
    }

    sticky(){
        axios.get('/api/projects/sticky?include=categories')
            .then(response => this.setData(this.stickyData, response.data));
    }

    setData(container, data){
        container.data = data;
        if(container.data.data instanceof Array){
            container.data.data.forEach(item => {
                item.isActive = true;
            });
        }
        Event.fire(container.event, container.data);
    }

    link(project){
        const projectLinks = project.data.links;
        let links = {};
        for(let i in projectLinks){
            links[projectLinks[i].rel] = projectLinks[i].uri;
        }
        return links.self;
    }
}

export default new Project
