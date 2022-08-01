//import $ from 'jquery';
//window.$ = window.jQuery = $;
//import 'jquery-ui/ui/widgets/datepicker.js';
//$('#datepicker').datepicker();

require('./bootstrap')
import { createApp } from 'vue'
import store from "./vue/store/index"
import router from './router'



import App from "./vue/App";
import Login from "./vue/pages/Login";



const app = createApp(App)

app.use(router)
app.use(store)

app.mount('#main-wrapper')
