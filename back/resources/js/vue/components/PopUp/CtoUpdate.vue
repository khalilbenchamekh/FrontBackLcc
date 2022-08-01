<template>
    <div class="center">

            <div class="card-body">
                <div class="col-lg-8 col-xlg-9 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form class="form-horizontal form-material" @submit.prevent="onsubmit">
                                <div class="form-group mb-4">
                                    <label class="col-md-12 p-0">Name</label>
                                    <div class="col-md-12 border-bottom p-0">
                                        <input type="text" placeholder="Johnathan Doe"

                                               class="form-control p-0 border-0"> </div>
                                </div>
                                <div class="form-group mb-4">
                                    <label for="example-email" class="col-md-12 p-0">Email</label>
                                    <div class="col-md-12 border-bottom p-0">
                                        <input type="email"


                                               class="form-control p-0 border-0" name="example-email"
                                               id="example-email">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <a href="#" class="btn btn-primary" @click="closeDialog">close</a>
                <a href="#" class="btn btn-success" @click="acceptDialog">Update</a>
        </div>
    </div>
</template>

<script>
export default {
    name: "CtoUpdate",
    props:["cto"],

    methods:{
        closeDialog(){
            const updateCto= this.$store.state.updateCto
            this.$store.commit('CTO_UPDATE_POP_UP',false)
        },
        acceptDialog(){
            const updateCto= this.$store.state.updateCto
            this.$store.commit('CTO_UPDATE_POP_UP',false)
        }
    }
}
</script>

<style scoped>
.center {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: white;
    padding: 20px;
}

.btn {
    margin: 10px;
}
</style>
