import {createStore, combineReducers, applyMiddleware} from 'redux';
import thunk from 'redux-thunk';
import rootReducer from './rootReducer';

const store = createStore(
  combineReducers(rootReducer),
  applyMiddleware(thunk),
);

export default store;
