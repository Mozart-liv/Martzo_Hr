<template>
    <div>
        <Header></Header>
        <div class="container">
            <div class="card my-15 ">
                <div class="card-body p-5">
                    <h1 class="mb-5 text-primary">Update Department</h1>
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
                            class="btn btn-primary text-white btn-block btn-lg " @click="UpdateDepartment()" >Update</button>
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
        name: 'UpdateEmployee',
        components: {
        Header, Footer
       },
        data () {
            return {
                id: "",
                data: {},
                errors: {}
            }
        },
        methods: {
            getOldData(id){
                axios.get("http://localhost:8000/api/department/update/" + id).then((response)=>{
                    console.log(response);
                    this.data = response.data
                }).catch((e)=>{
                    console.log(e);
                })
            },
            UpdateDepartment(){
                axios.post("http://localhost:8000/api/department/update", this.data).then((response)=>{
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
        mounted () {
            this.id = this.$route.query.id
            this.getOldData(this.id);
        }
    }
</script>

<style lang="stylus" scoped>

</style>
