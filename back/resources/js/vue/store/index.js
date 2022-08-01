// import { createStore } from 'vuex'
//
// export const store = createStore({
//     state :{
//             token: null
//     },
//     mutations:  {
//         GET_TOKEN(state,payload){
//             state.token=payload
//         }
//     },
//     actions:{
//         getToken(context, payload)
//         {
//             let token=context.state.token
//             token=payload
//             context.commit('GET_TOKEN',token)
//         }
//     }
// })
import { createStore, createLogger } from 'vuex';
import VuexPersistence from 'vuex-persist';

import state from './modules/state';
import getters from './modules/getters';
import mutations from './modules/mutations';
import actions from './modules/actions';

const debug = process.env.NODE_ENV !== 'production';
const debugLogger = debug ? createLogger() : [];
const vuexLocal = new VuexPersistence({
    storage: window.localStorage,
});

export default createStore({
    state,
    getters,
    actions,
    mutations,
    strict: debug,
    plugins: [vuexLocal.plugin, debugLogger],
});
