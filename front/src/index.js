import React from 'react';
import ReactDOM from 'react-dom';
import { Provider } from 'react-redux';
import { createHistory } from 'history';

import configureStore from './store/configureStore';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'devextreme/dist/css/dx.common.css';
import 'devextreme/dist/css/dx.material.teal.dark.compact.css';
import "react-dates/initialize";
import "react-dates/lib/css/_datepicker.css";
import App from './container/App';
import './index.css';
import registerServiceWorker from "./config/registerServiceWorker";
const store = configureStore();
export const hist = createHistory();

store.subscribe(() => console.log("new Store", store.getState()))
ReactDOM.render(

  <Provider store={store}>
    <App />
  </Provider>
  , document.getElementById('root'));
registerServiceWorker();


