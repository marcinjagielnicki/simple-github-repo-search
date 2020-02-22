import React, { Component } from 'react';
import ReactPaginate from 'react-paginate';

export default class Pagination extends Component {
    constructor(props){
        super(props);
        this.onPageChange = this.onPageChange.bind(this);
    }

    onPageChange(page) {
        const {meta} = this.props;
        if((meta.selected-1) !== page.selected) {
            this.props.onPageChange(page.selected+1);
        }
    }

    render() {
        const {meta} = this.props;
        return (
            <div className="pagination">
                <ReactPaginate
                    initialPage={meta.selected-1}
                    activeClassName="active"
                    pageCount={meta.pageCount}
                    pageRangeDisplayed={4}
                    marginPagesDisplayed={2}
                    onPageChange={this.onPageChange}
                />
            </div>
        )
    }
}
