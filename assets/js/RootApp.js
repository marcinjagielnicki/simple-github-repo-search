import React, {Component} from "react";
import {BrowserRouter, Route, Redirect, Switch} from "react-router-dom";
import Header from "./Components/Header";
import Home from "./Components/Home";
import {Provider} from "react-redux";
import store from "./Store/store";


class App extends Component {
    render() {
        return (
            <Provider store={store}>
                <div className="container mx-auto">
                    <BrowserRouter>
                        <Header/>
                        <Switch>
                            <Route key="home" exact path="/" component={Home}/>
                        </Switch>
                    </BrowserRouter>
                </div>
            </Provider>
        )
    }
}

export default App;