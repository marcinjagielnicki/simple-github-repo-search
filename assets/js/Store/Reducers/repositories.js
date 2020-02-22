import {
    REPOSITORIES_FETCH_ERROR,
    REPOSITORIES_FETCH_REQUEST,
    REPOSITORIES_FETCH_SUCCESS
} from "../Actions/repositories";

const initState = {
    anyRequestPerformed: false,
    repositoriesLoading: false,
    errorState: false,
    repositories: [],
    pagination: {
        total: 0,
        selected: 1,
        pageSize: 10,
        pageCount: 1
    }
};

export default function repositories(state = initState, action) {
    switch (action.type) {
        case REPOSITORIES_FETCH_ERROR:
            return {
                ...state,
                repositoriesLoading: false,
                errorState: true
            };
        case REPOSITORIES_FETCH_REQUEST:
            return {
                ...state,
                anyRequestPerformed: true,
                repositoriesLoading: true,
                errorState: false
            };
        case REPOSITORIES_FETCH_SUCCESS:
            const result = action.result || {};
            const repositories = result.results || [];
            const pageSize = result.itemsPerPage || 5;
            const total = result.totalCount || 0;
            return {
                ...state,
                repositories: [...repositories],
                repositoriesLoading: false,
                pagination: {
                    total,
                    pageSize,
                    selected: action.page,
                    pageCount: Math.ceil(total/pageSize)
                }
            };
        default:
            return state;
    }
}
