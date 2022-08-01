<template>
    <div class="white-box">
        <div :class="validationMessage.validate===true?'alert alert-success text-center':'alert alert-danger text-center'" role="alert" v-if="success">
            <div :class="validationMessage.validate===true?'spinner-border text-success':'spinner-border text-danger'" role="status" v-if="loading">
                <span class="sr-only">Loading...</span>
            </div>
            <span v-if="validationMessage.message!==null">{{validationMessage.message}}</span>
        </div>
        <div class="user-bg"> <img width="100%" alt="user" :src="image">
            <div class="overlay-box">
                <div class="user-content">
                    <a href="javascript:void(0)"><img
                        :src="image"
                        class="thumb-lg img-circle" alt="img"></a>
                    <h4 class="text-white mt-2">{{organisation.name}}</h4>
                    <h5 class="text-white mt-2">{{organisation.emailOrganisation}}</h5>
                </div>
            </div>
        </div>
        <div class="user-btm-box mt-5 d-md-flex">
            <div class="col-md-4 col-sm-4 text-center">
                <h6>Count Users: </h6><span>{{users}}</span>
            </div>
            <div class="col-md-4 col-sm-4 text-center">
                <button @click="onCancel" class="update" v-if="change">Cancel</button>
            </div>
            <div class="col-md-4 col-sm-4 text-center">
                <div class="update bg-success">
                    <input type="file" name="file" id="file" class="inputfile"  @change="uploadImage" :disabled="change===true" />
                    <label for="file" class="lab">Choose file</label>
                </div>
            </div>
        </div>
        <button type="button" class="btn btn-primary btn-sm" v-if="change" @click="onSubmit">Update Image</button>
    </div>
</template>

<script>
import {getImageOrganiastion, imageOrganisation} from "../../../utils/organisations";

export default {
    props:['users','organisation'],
    name: "ImageOrganisation",
    data(){
        return{
            image:null,
            newImage:null,
            validationMessage:{validate:false,message:null},
            success:false,
            change:false,
            loading:false
        }
    },
    async created() {
        const id=this.$route.params.id
        const response = await getImageOrganiastion(id)
        this.image = response;
    },
    methods:{
         uploadImage(e) {
            let img = e.target.files[0]
            this.newImage = img
             this.change=true
        },
        async onSubmit() {
            let valisation = ["image/jpeg", "image/png", "image/gif"].includes(this.newImage.type)
            if (valisation) {
                this.loading=true
                this.change=false
                const id = this.$route.params.id
                const update = await imageOrganisation(id, this.newImage)
                if (update.status === 202) {
                    this.success=true
                    this.loading=true
                    const responseImage = await getImageOrganiastion(id)
                    this.image = responseImage;
                    this.loading=false
                    this.validationMessage={validate:true,message:"Image Updated"}
                }
            } else {
                this.success=true
                this.loading=false
                this.validationMessage={validate:false,message:"Image No Updated"}
            }
        },
        onCancel(){
            this.success=false
            this.validationMessage={validate:false,message:null},
             this.newImage=null
            this.change=false
        }
    }
}
</script>

<style scoped>
.inputfile {
    width: 0.1px;
    height: 0.1px;
    opacity: 0;
    overflow: hidden;
    position: absolute;
    z-index: -1;
}
inputfile + label {
    font-size: 1.25em;
    font-weight: 700;
    color: white;
    background-color: black;
    display: inline-block;
    cursor: pointer;
}
.update{
    padding: 5px;
    cursor: pointer;
    border-radius: 5px;
}
.lab{
    cursor: pointer;
    color: white;
}
</style>
