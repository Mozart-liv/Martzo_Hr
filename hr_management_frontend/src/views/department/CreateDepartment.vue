<template>
    <div>
        <Header></Header>
        <div class="container">
            <div class="card my-5 col-md-6 mx-auto">
                <div class="card-body p-5">
                    <h1 class="mb-5 text-primary">Add Department</h1>
                    <form class="text-start row">
                         <div class="form-gorup mb-4">
                            <label class="form-label" >Title</label>
                            <input type="text" v-model="data.title"  class="form-control form-control-lg" :class="errors.title ? 'is-invalid' : ''" />
                            <div v-if="errors && errors.title" class="text-danger">
                                {{ errors.title[0] }} 
                            </div>
                        </div>
                        <div class="d-flex justify-content-center my-3">
                            <button type="button"
                            class="btn btn-primary text-white btn-block btn-lg " @click="createDepartment()" >ADD</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
        <Footer></Footer>
    </div>
</template>

<script>
    import Header from '../AppHeader.vue';
    import Footer from '../FooterPage.vue';
    import axios from 'axios';


    export default {
        name: 'CreateEmployee',
        components: {
        Header, Footer
       },
       data () {
        return {
            data: {
                title:""
            },
           errors: {}
        }
       },
       methods: {
        //post data to backend
        createDepartment(){
            axios.post('http://localhost:8000/api/department/create', this.data).then((response)=>{
                if(response.data.status == true){
                    this.$router.push({
                        name: 'department',
                        query : {
                            message : response.data.message
                        }
                    })
                }

            }).catch((e)=>{
                console.log(e);
                if(e.response.status == 422){
                    this.errors = e.response.data.errors;
                }
            })
        }
       },
    }
</script>

<style lang="stylus" scoped>

</style>
