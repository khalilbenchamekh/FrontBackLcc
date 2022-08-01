<template>
    <div class="container login_page" style="position: absolute; top: 30%; left: 40%;width: 20%;z-index: 88" >

        <form method="post" @submit.prevent="onSubmit" class="align-self-center">
            <div class="form-group">
                <label for="email">Name:</label>
                <input type="email" class="form-control" id="email" name="email" v-model="email">
            </div>
            <div class="form-group">
                <label for="pwd">Password:</label>
                <input type="password" class="form-control" id="pwd" v-model="password">
            </div>
            <button type="submit" class="btn btn-outline-primary">Login</button>
        </form>
    </div>
</template>
<script>
import axios from 'axios';
import {SERVER} from "../../server";
import {getToken} from "../Caller/tokenCaller";
import {loginUser} from "../../utils/auth";

export default {
    setup: () => ({
        title: 'How To Install Vue 3 in Laravel 8 From Scratch',
        email:'',
        password:'',
        indo:'',
        data:null
    }),
    methods:{
        async onSubmit() {
            try {
                const isAuth =await loginUser(this.email, this.password)
                
                console.log(isAuth)
                 this.$router.push('/admin/index');
            }
            catch (err) {
                alert(`Error: ${err}`)
            }
        }
    }
}
</script>
