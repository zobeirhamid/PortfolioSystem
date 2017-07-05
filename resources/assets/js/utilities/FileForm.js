import Form from './Form';
class FileForm extends Form{
    data(){
        let data = new FormData();
        for(let property in this.originalData){
            if(this[property]) data.append(property, this[property]);
        }
        return data;
    }
}

export default FileForm;
