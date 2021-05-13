import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'
// import example from './module-example'

Vue.use(Vuex)
import { getField, updateField } from 'vuex-map-fields'

/*
 * If not building with SSR mode, you can
 * directly export the Store instantiation;
 *
 * The function below can be async too; either use
 * async/await or return a Promise which resolves
 * with the Store instance.
 */

export default function (/* { ssrContext } */) {
  const Store = new Vuex.Store({
    modules: {
      // example
    },
    state: {
      token: localStorage.getItem("login_token") || null,
       addUser: {
        user: "",
        pass: "",
        fname: "",
        lname: ""
    },
    },
    getters: {
      getField,
      loggedIn(state){
        return state.token !== null
      }
    }, 
    mutations: {
      updateField,
      loginToken (state, token) {
        state.token = token
      },
      removeToken (state) {
        state.token = null
      },
    }, 
    actions: {
      LOGIN_USER(context, payload){
        return new Promise((resolve, reject) => {
          axios.post('http://localhost/myvuebackend/', payload, {
            headers: { 'Content-Type': 'application/json' },
            params: {
              loginId: 1
            }
          })
          .then(response => {
            if(response.data === ''){
              resolve(response);
            }

            for(var i=0; i < response.data.length; i++){
              
              const token = response.data[i].UserId;
              if(token !== null){
                if(response.data.Username === payload.Username &&
                response.data.Password === payload.Password){
                  localStorage.setItem("login_token", token);
                  context.commit("loginToken", token);
                  resolve(response);
                }
              }
            }
          })
          .catch(error => {
            reject('Login Error!')
            console.log(error)
          })
          })
      },
      ADD_USER({ commit }, payload){
        return new Promise((resolve, reject) => {
          axios.post('http://localhost/myvuebackend/', payload, {
            params: {
              addId: 1
            }
        })
        .then((response) => {
          resolve(response)
        }).catch(error => {
         reject(error)
        })
      });
      },
      DELETE_USER({ commit }, payload){
        return new Promise((resolve, reject) => {
          axios.delete('http://localhost/myvuebackend/', {
            params: {
              delId: 1,
              userId: payload.userId
            }, 
            payload
        
        }).then(response => {
          resolve(response)
        }).
        catch(error => {
          reject(error)
        })
      });
      },      
      UPDATE_USER({ commit }, payload){
        return new Promise((resolve, reject) => {
          axios.put('http://localhost/myvuebackend/', payload, {
            params: {
              editId: 1,
            }, 
          
        }).then(response => {
          resolve(response)
        }).catch(error => {
          reject(error)
        })
      });
      },   
      LOGOUT_USER(context, payload){
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token
        if(context.getters.loggedIn){
          return new Promise((resolve, reject) => {
            axios.post('http://localhost/myvuebackend/', {
              params: {
                loginId: 2
              }
            })
          
          .then(response => {
            context.commit('removeToken');
            resolve(response);
          }).catch(error => {
            localStorage.removeItem('login_token');
            context.commit('removeToken');
            reject(error);
          })
        })
        }
      }
        
      
    },
      
    // enable strict mode (adds overhead!)
    // for dev mode only
    strict: process.env.DEBUGGING
  })

  return Store
}
