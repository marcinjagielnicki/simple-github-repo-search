import axios from "axios"


class RepositoryService {

    fetch(page=1, filters){
        return axios.post('/api/search', {
            page, ...filters
        }).then( (ret)=>{
            let data = ret.data;
            return { data: data, ...ret };
        });
    }

}

export default new RepositoryService();