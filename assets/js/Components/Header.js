import React, { Component } from "react";

export default class Header extends Component {
    render() {
        return (
            <nav className="flex items-center justify-between flex-wrap bg-teal-500 p-6">
                <div className="flex items-center flex-shrink-0 text-white mr-6">
                    <span className="font-semibold text-xl tracking-tight">Repository search</span>
                </div>
            </nav>
        );
    }
}