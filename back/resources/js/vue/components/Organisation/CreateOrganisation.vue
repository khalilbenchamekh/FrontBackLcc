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
               <div class="d-flex justify-content-sm-center" v-for="(error,index) in fetchErrors.emailOrganisation" :key="index">{{error}}</div>
               <div class="d-flex justify-content-sm-center" v-for="(error,index) in fetchErrors.nameCto" :key="index">{{error}}</div>
               <div class="d-flex justify-content-sm-center" v-for="(error,index) in fetchErrors.email" :key="index">{{error}}</div>
               <div class="d-flex justify-content-sm-center" v-for="(error,index) in fetchErrors.passwordCto" :key="index">{{error}}</div>
               <div class="d-flex justify-content-sm-center" v-for="(error,index) in fetchErrors.description" :key="index">{{error}}</div>
            </div>
            <div class="card">
                <div class="card-body">
                    <form class="form-horizontal form-material" @submit.prevent="create">
                        <div class="form-group mb-4">
                            <label class="col-md-12 p-0">Name Organisation</label>
                            <div class="col-md-12 border-bottom p-0">
                                <input type="text"
                                       class="form-control p-0 border-0" v-model="organisation.name"
                                       :disabled="loading"
                                >

                            </div>
                            <span class="text-danger" v-if="errors.name.length>0">{{errors.name}}</span>
                        </div>
                        <div class="form-group mb-4">
                            <label  class="col-md-12 p-0">Email Organisation</label>
                            <div class="col-md-12 border-bottom p-0">
                                <input type="email"
                                       class="form-control p-0 border-0" name="example-email"
                                       id="emailOrganisation" v-model="organisation.emailOrganisation"
                                       :disabled="loading"
                                >
                            </div>
                            <span class="text-danger" v-if="errors.emailOrganisation.length>0">{{errors.emailOrganisation}}</span>
                        </div>
                        <div class="form-group mb-4">
                            <label class="col-md-12 p-0">Name Responsable (CTO)</label>
                            <div class="col-md-12 border-bottom p-0">
                                <input type="text"
                                       :disabled="loading"
                                       class="form-control p-0 border-0" v-model="organisation.nameCto"
                                > </div>
                            <span class="text-danger" v-if="errors.nameCto.length>0">{{errors.nameCto}}</span>
                        </div>
                        <div class="form-group mb-4">
                            <label  class="col-md-12 p-0">Email Responsable(CTO)</label>
                            <div class="col-md-12 border-bottom p-0">
                                <input type="email"
                                       class="form-control p-0 border-0" name="example-email"
                                       v-model="organisation.email"
                                       :disabled="loading"
                                >
                            </div>
                            <span class="text-danger" v-if="errors.email.length>0">{{errors.email}}</span>
                        </div>
                        <div class="form-group mb-4">
                            <label class="col-md-12 p-0">Password Responsable (CTO)</label>
                            <div class="col-md-12 border-bottom p-0">
                                <input type="password" name="password" autocomplete="on"  class="form-control p-0 border-0" v-model="organisation.passwordCto" :disabled="loading">
                            </div>
                            <span class="text-danger" v-if="errors.passwordCto.length>0">{{errors.passwordCto}}</span>
                        </div>
                        <div class="form-group mb-4">
                            <label class="col-md-12 p-0">Organisation Image</label>
                            <div class="update d-flex justify-content-sm-end ">
                                <input type="file" name="file" id="file" class="inputfile"  @change="uploadImage" :disabled="loading"/>
                            </div>
                        </div>
                        <div class="form-group mb-4">
                            <label class="col-md-12 p-0">Description</label>
                            <div class="col-md-12 border-bottom p-0">
                                <textarea rows="5" class="form-control p-0 border-0" v-model="organisation.description" :disabled="loading"></textarea>
                            </div>
                            <span class="text-danger" v-if="errors.description.length>0">{{errors.description}}</span>
                        </div>

                        <div class="form-group mb-4">
                            <div class="col-sm-12">
                                <button class="btn btn-success" :disabled="loading">Create Organisation</button>
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
import {imageOrganisation, saveOrganisation} from "../../../utils/organisations";

export default {
    name: "CreateOrganisation",
    data(){
        return{
            organisation:{emailOrganisation:'',email:'',name:'',nameCto:'',passwordCto:'',description:''},
            errors:{emailOrganisation:'',email:'',name:'',nameCto:'',passwordCto:'',description:''},
            fetchErrors :{emailOrganisation:[],email:[],name:[],nameCto:[],passwordCto:[],description:[]},
            loading:false,
            image:null,
            message:null,
            hasError:false
        }
    },
    created() {

    },
    methods:{
        uploadImage(e) {
            this.image = e.target.files[0]
        },
        async create(e) {
            this.errors={emailOrganisation:'',email:'',name:'',nameCto:'',passwordCto:'',description:''}

            const organisation = this.organisation
            const errors = this.errors
            if (!this.checkEmail(organisation.emailOrganisation)) {
                errors.emailOrganisation = 'Email Organisation is Required'
            }
            if (!this.checkEmail(organisation.email)) {
                errors.email = 'Email is Required'
            }
            if (organisation.name.length < 3 && organisation.name.length >0) {
                errors.name = 'Name is Short'
            }
            if (organisation.passwordCto.length <= 4 && organisation.passwordCto.length >0) {
                errors.passwordCto = 'Password is Short'
            }
            if (organisation.nameCto.length <= 3 && organisation.nameCto.length >0) {
                errors.nameCto = 'Responsable Name is Short'
            }
            if (organisation.description.length <= 3 && organisation.description.length >0) {
                errors.description = 'Description is Required'
            }


            if (organisation.emailOrganisation.length === 0) {
                errors.emailOrganisation = 'Email Organisation is Required'
            }
            if (organisation.email.length === 0) {
                errors.email = 'Email is Required'
            }
            if (organisation.name.length === 0) {
                errors.name = 'Name is Required'
            }
            if (organisation.passwordCto.length === 0) {
                errors.passwordCto = 'Password is Required'
            }
            if (organisation.nameCto.length === 0) {
                errors.nameCto = 'Name Cto is Required'
            }
            if (organisation.description.length === 0) {
                errors.description = 'Description is Required'
            }

            if (organisation.emailOrganisation && organisation.email && organisation.name && organisation.nameCto && organisation.passwordCto && organisation.description) {
                this.loading=true
                const newOrganisation = await saveOrganisation(organisation)
                const body = await newOrganisation.json();
                if(newOrganisation.status===201){
                    this.$store.commit('CREATE_ORGANISATION',body)
                    const organisation=body.organisation;
                    if(this.image && organisation){
                        await imageOrganisation(organisation.id,this.image);
                    }
                    this.organisation={emailOrganisation:'',email:'',name:'',nameCto:'',passwordCto:'',description:''};
                    this.errors={emailOrganisation:'',email:'',name:'',nameCto:'',passwordCto:'',description:''}
                    this.loading=false
                    this.message='Organisation Created'
                }
               if(newOrganisation.status===400){
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


