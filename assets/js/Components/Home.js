import React, {Component, useState} from "react";
import Form from "./Search/Form";
import {connect} from "react-redux";
import {repositoriesFetch} from "../Store/Actions/repositories";
import Loader from "./Search/Loader";
import Repository from "./Repository/Repository";
import Pagination from "./Search/Pagination";

class Home extends Component {
    constructor(props) {
        super(props);
        this.state = {
            data: Object.assign({}, {name: '', sortBy: 'name'})
        };
    }

    loadRepositories = (page = 1) => {
        this.props._repositoriesFetch(page, {query: this.state.data.name, sort: this.state.data.sortBy});
    }

    renderItem(item) {
        return <Repository key={item.name} item={item}/>
    }

    onSearch = (name, sortBy) => {
        const {_repositoriesFetch} = this.props;
        this.setState({
            data: {
                name,
                sortBy
            }
        });
        _repositoriesFetch(1, {
            query: name,
            sort: sortBy
        })
    }

    render() {

        const {repositories, repositoriesLoading, pagination, anyRequestPerformed} = this.props;
        return (
            <>
                <Form onSearch={({name, sortBy}) => this.onSearch(name, sortBy)}/>
                <div className="w-full">
                    {anyRequestPerformed ? (
                        <>
                            {repositoriesLoading ? <Loader/> : <div className="w-full grid grid-cols-2 gap-4">{repositories.map((item) => this.renderItem(item))}</div>}
                            {!repositoriesLoading && repositories.length > 0 ?
                                <Pagination meta={pagination} onPageChange={this.loadRepositories}/> : null}
                            {!repositoriesLoading && repositories.length === 0 ?
                                <h4>We couldn't find any repositories matching criteria.</h4> : null}
                        </>
                    ) : null}

                </div>
            </>

        );
    }
}

const mapDispatchToProps = (dispatch) => {
    return {
        _repositoriesFetch: (page, filters) => dispatch(repositoriesFetch(page, filters)),
    }
};

const mapStateToProps = (state) => {
    return {
        ...state.repositories
    }
};

export default connect(mapStateToProps, mapDispatchToProps)(Home);