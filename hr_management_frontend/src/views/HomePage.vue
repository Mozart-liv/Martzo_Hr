<template>
    <div >
        <Header></Header>
        <h1 v-if="!login">Login please</h1>
        <div v-else class="col-md-10 mx-auto p-3 my-5">
                <v-card class="mx-auto p-4 col-md-8" elevation="6">
                    <div class="d-flex flex-row flex-wrap align-center justify-start p-3 ">
                        <div class="me-5">
                            <v-avatar size="150">
                                <v-img :src="userInfo.img" cover>
                                </v-img>
                            </v-avatar>
                        </div>
                        <div class="p-3 text-center">
                            <h3>{{ userInfo.name }}</h3>
                            <p class="text-grey">{{ userInfo.employee_id }}</p>
                        </div>
                        
                    </div>
                    <div class="">
                             <v-switch
                                @change="checkinOut()"
                                v-model="check"
                                hide-details
                                color="success"
                                true-value="check_in " 
                                false-value="check_out"
                                :label="`${check}`"
                            ></v-switch>
                        </div>
                </v-card>
            </div>
        <Footer></Footer>
    </div>
</template>

<script>
    import Header from '../views/AppHeader.vue';
    import Footer from '../views/FooterPage.vue';
    import { mapGetters } from "vuex";
    import axios from 'axios';
    import Swal from "sweetalert2";
    export default {
        name: 'HomePage',
       components: {
        Header, Footer
       },
        data () {
            return {
                login: false,
                check: "attendence",
                checkStatus: true
                
            }
        },
        computed: {
            ...mapGetters(["userInfo", "getToken"]),
        },
        methods: {
            checkLogin () {
                
                if(this.getToken !== ""){
                    this.login = true
                }

            },
            checkinOut(){
                const data = {
                    user_id : this.userInfo.id,
                    check: this.check
                }
                axios.post("http://localhost:8000/api/checkInOut", data).then((response)=>{
                    console.log(response);
                    if(response.data == false){
                        Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Today Attendence has already recorded!"
                        });
                    }

                }).catch((e)=>{
                    console.log(e);
                })
            },
            imgload(){
                if(this.userInfo.img == null || this.userInfo.img == "" || this.userInfo.img == undefined){
                    this.userInfo.img = "http://localhost:8000/image/default.jpg";
                }else{
                    this.userInfo.img = "http://localhost:8000/image/" + this.userInfo.img;
                }
            }
        },
        mounted () {
            this.checkLogin();
            this.imgload();
            console.log(this.userInfo);
        }
    }
</script>

<style lang="stylus" scoped>

</style>
