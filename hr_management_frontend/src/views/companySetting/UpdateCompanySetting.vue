<template>
    <div>
        <Header></Header>
        <div class="container">
            <div class="card my-15 ">
                <div class="card-body p-5">
                    <h1 class="mb-5 text-primary">Update Employee</h1>
                    <form class="text-start row">
                        <div class="col-md-6 px-3">
                             <div class="form-gorup mb-4">
                                <label class="form-label" >Name</label>
                                <input type="text" v-model="data.name"  class="form-control form-control-lg" :class="errors.name ? 'is-invalid' : ''" />
                                <div v-if="errors && errors.name" class="text-danger">
                                    {{ errors.name[0] }} 
                                </div>
                            </div>
                            <div class="form-group mb-4">
                                <label class="form-label">Email</label>
                                <input type="email" v-model="data.email" class="form-control form-control-lg" :class="errors.email ? 'is-invalid' : ''"  />
                                <div v-if="errors && errors.email" class="text-danger">
                                    {{ errors.email[0] }} 
                                </div>
                            </div>

                            <div class="form-group mb-4">
                                <label class="form-label">Phone</label>
                                <input type="number" v-model="data.phone" class="form-control form-control-lg" :class="errors.phone ? 'is-invalid' : ''" />  
                                <div v-if="errors && errors.phone" class="text-danger">
                                    {{ errors.phone[0] }} 
                                </div>  
                            </div>

                            <div class="form-group mb-4">
                                <label class="form-label">Address</label>
                                <textarea name="" id="" v-model="data.address" class="form-control" :class="errors.address ? 'is-invalid' : ''"   rows="3"></textarea>
                                <div v-if="errors && errors.address" class="text-danger">
                                    {{ errors.address[0] }} 
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 px-3">

                            <div class="form-group mb-4">
                                <label class="form-label">Office start time</label>
                                <input type="time" v-model="data.office_start_time" class="form-control form-control-lg"  />    
                            </div>
                            <div class="form-group mb-4">
                                <label class="form-label">Office end time</label>
                                <input type="time" v-model="data.office_end_time" class="form-control form-control-lg" />    
                            
                            </div>

                            <div class="form-group mb-4">
                                <label class="form-label">Break start time</label>
                                <input type="time" v-model="data.break_start_time" class="form-control form-control-lg"  />    

                            </div>

                            <div class="form-group mb-4">
                                <label class="form-label">Break start time</label>
                                <input type="time" v-model="data.break_end_time" class="form-control form-control-lg"  />    

                            </div>

                            
                        </div>

                        <div class="d-flex justify-content-center my-3">
                            <button type="button"
                            class="btn btn-primary text-white btn-block btn-lg " @click="UpdateEmployee()" >Update</button>
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
        name: 'UpdateCompanySetting',
        components: {
        Header, Footer
       },
        data () {
            return {
                data: {},
                errors: {},
            }
        },
        methods: {
            getOldData(){
                axios.get("http://localhost:8000/api/company/data").then((response)=>{
                    console.log(response);

                    this.data = response.data
                }).catch((e)=>{
                    console.log(e);
                })
            },
            UpdateEmployee(){
                axios.post("http://localhost:8000/api/company/update", this.data).then((response)=>{
                    if(response.data.status == true){
                    this.$router.push({
                        name: 'company',
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
            this.getOldData();
        }
    }
</script>

<style lang="stylus" scoped>

</style>
