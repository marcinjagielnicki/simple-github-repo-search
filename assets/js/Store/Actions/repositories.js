import repositoryService from "../../Services/repositoryService";


export const REPOSITORIES_FETCH_REQUEST = '@repositories/FETCH_REQUEST';

function repositoriesFetchRequest() {
    return {
        type: REPOSITORIES_FETCH_REQUEST
    };
}

export const REPOSITORIES_FETCH_SUCCESS = '@repositories/FETCH_SUCCESS';

function repositoriesFetchSuccess(result, page) {
    return {
        type: REPOSITORIES_FETCH_SUCCESS,
        result,
        page
    };
}

export const REPOSITORIES_FETCH_ERROR = '@offers/FETCH_ERROR';

function repositoriesFetchError(error) {
    return {
        type: REPOSITORIES_FETCH_ERROR,
        error
    };
}

export function repositoriesFetch(page = 1, filters) {
    return dispatch => {
        dispatch(repositoriesFetchRequest());
        repositoryService.fetch(page, filters).then((ret)=>{
            dispatch(repositoriesFetchSuccess(ret.data, page));
        }).catch((ret)=>{
            dispatch(repositoriesFetchError(ret.data));
            alert('Error occurred while performed your query.');
        });
    };
}
