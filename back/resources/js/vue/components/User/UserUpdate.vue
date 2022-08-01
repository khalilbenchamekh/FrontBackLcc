<template>
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Start Page Content -->
        <!-- ============================================================== -->
        <!-- Row -->
        <div class="row">
            <!-- Column -->
            <div class="col-lg-4 col-xlg-3 col-md-12" id="center">
                <div class="alert alert-success rounded d-flex justify-content-sm-center" v-if="ok">
                    <span class="spinner spinner-border" v-if="loading&&successMessage===null"></span>
                    <span class="text-white" v-if="successMessage">{{successMessage}}</span>
                </div>
                <div class="alert alert-danger d-flex justify-content-sm-center" v-if="message && loading===false">
                    {{message}}
                </div>
                <div class="white-box " >

                    <div class="user-bg"> <img width="100%" alt="user" :src="image">
                        <div class="overlay-box"> <label for="actual-btn" class="icon" ><i class="fas fa-camera"></i></label><input type="file" @change="uploadImage" id="actual-btn">
                            <div class="user-content">
                                <a href="javascript:void(0)" class=""><img :src="image"
                                                                  class="thumb-lg img-circle " alt="img"> </a>
                                <h4 class="text-white mt-2">{{user.name}}</h4>
                                <h5 class="text-white mt-2">{{user.email}}</h5>
                            </div>
                        </div>
                    </div>
                    <div class="user-btm-box mt-5 d-md-flex">
                        <div class="col-md-4 col-sm-4 text-center">
                            <h1>258</h1>
                        </div>
                        <div class="col-md-4 col-sm-4 text-center">
                            <h1>125</h1>
                        </div>
                        <div class="col-md-4 col-sm-4 text-center">
                            <h1 v-if="changeImage"><button class="btn btn-success" @click="submitImage">Update Image</button></h1>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <!-- Column -->
            <div class="col-lg-8 col-xlg-9 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form class="form-horizontal form-material"  @submit="updateUser">
                            <div class="form-group mb-4">
                                <label class="col-md-12 p-0">Full Name</label>
                                <div class="col-md-12 border-bottom p-0">
                                    <input type="text" placeholder="Johnathan Doe"
                                           v-model="user.name"
                                           class="form-control p-0 border-0"> </div>
                            </div>
                            <div class="form-group mb-4">
                                <label for="example-email" class="col-md-12 p-0">Email</label>
                                <div class="col-md-12 border-bottom p-0">
                                    <input type="email" placeholder="johnathan@admin.com"
                                           class="form-control p-0 border-0" name="example-email"
                                           v-model="user.email"
                                           id="example-email">
                                </div>
                            </div>

                            <div class="form-group mb-4">
                                <div class="col-sm-12">
                                    <button class="btn btn-success">Update Profile 1</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Column -->
        </div>

    </div>
</template>

<script>
import {editUser, getImage, getUser, saveImageUser} from "../../../utils/users";

export default {
    data(){
        return{
            user:{},
            image:null,
            errors:{email:null,name:null},
            changeImage:null,
            message:null,
            loading:false,
            ok:false,
            successMessage:null
        }
    },
    async created() {
        let id = this.$route.params.id
        const response = await getUser(id)
        if(response.status===200){
            this.user=response.data
            console.log(response.data)
        }
        const image = await getImage(id)
        if(image!==null){
            this.image=image
            console.log(this.image)
        }
    },
    methods:{
        uploadImage(e) {
            this.changeImage = e.target.files[0]
        },
        async updateUser(e) {
            e.preventDefault()
            if (this.user) {
                const data = this.user
                const id = this.$route.params.id

                if (this.checkEmail(data.email)) {

                    if (data.name.length !== 0) {
                        if (data.name.length > 3) {
                            const response = await editUser(id, data)
                            console.log(this.user)
                            if(response.status===200){
                                this.$store.commit('CHANGE_USER',response.data)

                            }
                        } else {
                            this.errors.name = 'Name is short'
                        }
                    } else {
                        this.errors.name = "Name is Required"
                    }

                } else {
                    this.errors.email = 'Email is Required'
                }
            }

        },
        checkEmail(email){
            let re = /\S+@\S+\.\S+/;
            return re.test(email);
        },
        async submitImage() {
            this.message=null
            this.ok=true
            this.loading=true
            let file = this.changeImage
            let id=this.$route.params.id
            const formImage = ["image/png", "image/jpeg", "image/gif"]
            if(file) {
                if (formImage.includes(file.type)) {
                    const response = await saveImageUser(id, this.changeImage)
                    if (response) {
                        const newImage = await getImage(id)
                        this.image = newImage
                    }
                    this.loading=false
                    this.changeImage=null
                    this.successMessage="Image Updated"
                }else {
                    this.ok=false
                    this.loading=false
                    this.message="Error Format Image"
                    this.changeImage=null
                }
            }
        }
    }
}
</script>

<style scoped>
#center{
    position: relative;
}
.icon{
    position: absolute;
    z-index: 99;
    left: 5%;
    top: 5%;
    font-size: larger;
    background-color: indigo;
    color: white;
    padding: 0.5rem;
    font-family: sans-serif;
    border-radius: 0.3rem;
    cursor: pointer;
    margin-top: 1rem;
}
#actual-btn{
    visibility: hidden;
}
</style>
