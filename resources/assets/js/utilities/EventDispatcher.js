import Vue from 'vue';

class EventDispatcher{
    constructor(){
        this.vue = new Vue();
    }

    fire(event, data = null){
        this.vue.$emit(event, data);
    }

    listen(event, callback){
        this.vue.$on(event, callback);
    }

    listenOnce(event, callback){
        this.vue.$once(event, callback);
    }
}

export default new EventDispatcher;
