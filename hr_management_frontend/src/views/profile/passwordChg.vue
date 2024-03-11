<template>
    <div>
        <Header title="Password Change"></Header>
        <div class="container col-6 my-15">
            <div class="col-md-6 " onclick="history.back()">
                    <v-icon>mdi-arrow-left-top</v-icon>Back
                </div>
            <div class="card my-5 ">
                <div class="card-body p-5">
                    <h1 class="mb-5 text-primary">Change Password</h1>
                    <form class="text-start row">
                        <div class="form-group mb-4">
                            <label class="form-label" for="form3Example4cg">Old Password</label>
                            <input type="password" v-model="data.oldpassword" id="form3Example4cg" class="form-control form-control-lg" :class="errors.oldpassword ? 'is-invalid' : ''" />
                            <div v-if="errors && errors.oldpassword" class="text-danger">
                                {{ errors.oldpassword[0] }} 
                            </div>
                        </div>
                        <div class="form-group mb-4">
                            <label class="form-label" for="form3Example4cg">New Password</label>
                            <input type="password" v-model="data.newpassword" id="form3Example4cg" class="form-control form-control-lg" :class="errors.newpassword ? 'is-invalid' : ''" />
                            <div v-if="errors && errors.newpassword" class="text-danger">
                                {{ errors.newpassword[0] }} 
                            </div>
                        </div>
                        <div class="form-group mb-4">
                            <label class="form-label" for="form3Example4cg">Confirm New Password</label>
                            <input type="password" v-model="data.confirmpassword" id="form3Example4cg" class="form-control form-control-lg" :class="errors.confirmpassword ? 'is-invalid' : ''" />
                            <div v-if="errors && errors.confirmpassword" class="text-danger">
                                {{ errors.confirmpassword[0] }} 
                            </div>
                        </div>

                        <div class="my-3">
                            <button type="button"
                            class="btn btn-primary text-white btn-block btn-lg " @click="changePassword()" >Update Password</button>
                        </div>
                        <div v-if="errors.message" class="text-danger">
                            {{ errors.message }}
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
        name: 'passwordChg',
        components: {
        Header, Footer
       },
       data () {
        return {
            id: "",
            data : {
                oldpassword : "",
                newpassword : "",
                confirmpassword : ""
            },
            errors: {}
        }
       },
       methods: {
        changePassword () {
            axios.post("http://localhost:8000/api/user/change/password/" + this.id , this.data).then((response)=>{
                console.log(response);
                if(response.data.status == true){
                    location.reload();
                }else{
                    this.errors.message = response.data.message
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
       }
    }
</script>

