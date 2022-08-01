<template>
    <div class="center">
        <div class="card" style="width: 18rem;">
            <img src="" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">{{organisation.name}}</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                <a href="#" class="btn btn-primary" @click="closeDialog">close</a>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props:['organisation'],
    name: "Details",
    beforeCreate() {
      console.log(this.organisation.name)
        const organisation=this.organisation.name
        if(!organisation){
            const detailsPop=this.$store.state.detailsPop
            this.$store.commit("DETAILS_POP_UP",!detailsPop)
        }
    },
    methods:{
        closeDialog(){
            const detailsPop=this.$store.state.detailsPop
            this.$store.commit("DETAILS_POP_UP",!detailsPop)
        },

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

