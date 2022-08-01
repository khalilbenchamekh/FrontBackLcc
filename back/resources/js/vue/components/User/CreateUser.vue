<template>
    <div class="row justify-content-sm-center">

        <div class="col-lg-8 col-xlg-9 col-md-12 mt-sm-5 ">
            <div class="alert alert-secondary d-flex justify-content-sm-center"  v-if="loading" role="alert">
                <div class="spinner-border text-success" v-if="message===null" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>

            </div>
            <div class="alert alert-secondary d-flex justify-content-sm-center text-success" v-if="message" role="status">
                {{message}}
            </div>

            <div class="alert alert-danger "  v-if="hasError" role="alert">
                <div class="d-flex justify-content-sm-center" v-for="(error,index) in fetchErrors.name" :key="index">{{error}}</div>
                <div class="d-flex justify-content-sm-center" v-for="(error,index) in fetchErrors.email" :key="index">{{error}}</div>
                <div class="d-flex justify-content-sm-center" v-for="(error,index) in fetchErrors.password" :key="index">{{error}}</div>
            </div>
            <div class="card">
                <div class="card-body">
                    <form class="form-horizontal form-material" @submit.prevent="create">
                        <div class="form-group mb-4">
                            <label class="col-md-12 p-0">Name</label>
                            <div class="col-md-12 border-bottom p-0">
                                <input type="text"
                                       class="form-control p-0 border-0" v-model="user.name"
                                       :disabled="loading"
                                >

                            </div>
                            <span class="text-danger" v-if="errors.name.length>0">{{errors.name}}</span>
                        </div>

                        <div class="form-group mb-4">
                            <label  class="col-md-12 p-0">Email </label>
                            <div class="col-md-12 border-bottom p-0">
                                <input type="email"
                                       class="form-control p-0 border-0" name="example-email"
                                       v-model="user.email"
                                       :disabled="loading"
                                >
                            </div>
                            <span class="text-danger" v-if="errors.email.length>0">{{errors.email}}</span>
                        </div>
                        <div class="form-group mb-4">
                            <label class="col-md-12 p-0">Password </label>
                            <div class="col-md-12 border-bottom p-0">
                                <input type="password" name="password" autocomplete="on"  class="form-control p-0 border-0" v-model="user.password" :disabled="loading">
                            </div>
                            <span class="text-danger" v-if="errors.password.length>0">{{errors.password}}</span>
                        </div>
                        <div class="form-group mb-4">
                            <label class="col-md-12 p-0">User Image</label>
                            <div class="update d-flex justify-content-sm-end ">
                                <input type="file" name="file" id="file" class="inputfile"  @change="uploadImage" :disabled="loading"/>
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <div class="col-sm-12">
                                <button class="btn btn-success" :disabled="loading">Create User</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Column -->
    </div>
</template>

<script>
import {saveUser ,saveImageUser} from "../../../utils/users";

export default {
    data(){
        return{
            user:{email:'',name:'',password:'',organisation_id:this.$route.params.id},
            errors:{email:'',name:'',password:''},
            fetchErrors :{email:[],name:[],password:[]},
            loading:false,
            image:null,
            message:null,
            hasError:false
        }
    },
    created() {
    console.log(this.user)
    },
    methods:{
        uploadImage(e) {
            this.image = e.target.files[0]
        },
        async create(e) {
            this.errors={email:'',name:'',password:''}
            this.message=null
            this.hasError=null
            const user = this.user
            const errors = this.errors

            if (!this.checkEmail(user.email)) {
                errors.email = 'Email is Required'
            }
            if (user.name.length < 3 && user.name.length >0) {
                errors.name = 'Name is Short'
            }
            if (user.password.length <= 4 && user.password.length >0) {
                errors.password = 'Password is Short'
            }


            if (user.email.length === 0) {
                errors.email = 'Email is Required'
            }
            if (user.name.length === 0) {
                errors.name = 'Name is Required'
            }
            if (user.password.length === 0) {
                errors.password = 'Password is Required'
            }

            if ( user.email && user.name && user.password) {
                this.loading=true
                const newUser = await saveUser(user)
                const body = await newUser.json();
                if(newUser.status===201){
                    this.$store.commit('ADD_USER_ORGANISATION',body.user)
                    const user=body.user;
                    if(this.image && user){
                        await saveImageUser(user.id,this.image);
                    }
                    this.user={email:'',name:'',password:'',organisation_id:this.$route.params.id};
                    this.errors={email:'',name:'',password:''}
                    this.loading=false
                    this.message='User Created'
                }
                if(newUser.status===400){
                    if(body){
                        this.hasError=true
                        this.fetchErrors = body.error;
                        this.loading=false
                    }
                }
            }
            e.preventDefault()
        },
        checkEmail(email){
            let re = /\S+@\S+\.\S+/;
            return re.test(email);
        }
    }
}
</script>


