<template>
    <div>
        <Header></Header>
            <div class="col-md-10 mx-auto p-3 my-5">
                <div class="mx-auto col-md-8 mb-3" onclick="history.back()">
                    <v-icon>mdi-arrow-left-top</v-icon>Back
                </div>
                <v-card class="mx-auto p-4 col-md-8" elevation="6">
                    <div class="d-flex flex-row flex-wrap align-center justify-center p-3 border-bottom">
                        <div class="me-5">
                            <v-avatar size="150">
                                <v-img :src="data.img" cover>
                                </v-img>
                            </v-avatar>
                        </div>
                        <div class="p-3 text-center">
                            <h3>{{ userInfo.name }}</h3>
                            <p class="text-grey">{{ userInfo.employee_id }}</p>
                            <v-chip color="primary">
                                {{ data.department_name }}
                            </v-chip>
                        </div>
                    </div>
                    <div class="mt-5 row ps-3">
                        <div class="col">
                            <div class="mb-5">
                                <span class="text-grey m-2">Phone :</span>
                                <span>{{ userInfo.phone }}</span>
                            </div>

                             <div class="mb-5">
                                <span class="text-grey m-2">Email :</span>
                                <span>{{ userInfo.email }}</span>
                            </div>

                            <div class="mb-5">
                                <span class="text-grey m-2">Role :</span>
                                <span>{{ data.role }}</span>
                            </div>

                             <div class="mb-5">
                                <span class="text-grey m-2">Gender :</span>
                                <span>{{ userInfo.gender }}</span>
                            </div>
                        </div>

                        <div class="col">
                             <div class="mb-5">
                                <span class="text-grey m-2">Address :</span>
                                <span>{{ userInfo.address }}</span>
                            </div>

                            <div class="mb-5">
                                <span class="text-grey m-2">Nrc Number :</span>
                                <span>{{ userInfo.nrc }}</span>
                            </div>

                             <div class="mb-5">
                                <span class="text-grey m-2">Date of Join :</span>
                                <span>{{ userInfo.date_of_join }}</span>
                            </div>

                             <div class="mb-5">
                                <span class="text-grey m-2">Is present? :</span>
                                <v-chip
                                    :color="userInfo.is_present == 1 ? 'green' : 'red'"
                                    :text="userInfo.is_present == 1 ? 'Present' : 'Leave'"
                                    class="text-uppercase"
                                    label
                                    size="small"
                                ></v-chip>
                            </div>
                        </div>
                        
                    </div>
                    <div class="text-end mt-3">
                        <button class="btn btn-primary" @click="passwordChgPage(userInfo.id)">
                            <i class="fa-solid fa-key"></i>
                            Change Password
                        </button>
                    </div>
                </v-card>
            </div>
        <Footer></Footer>
    </div>
</template>

<script>
    import Header from "../AppHeader.vue";
    import Footer from "../FooterPage.vue";
    import { mapGetters } from "vuex";
    import Swal from "sweetalert2";
    import axios from 'axios';
    export default {
        name: 'profilePage',
          components: {
            Header,
            Footer,
        },
        data () {
            return {
               data: {}
            }
        },
        computed: {
            ...mapGetters(["userInfo", "loginStatus"]),
        },
        methods: {
            getData () {
               axios.get("http://localhost:8000/api/employee/userData/" + this.userInfo.id).then((response)=>{
                    console.log(response);
                    if(response.data.img == null){
                        response.data.img = "http://localhost:8000/image/default.jpg";
                    }else{
                        response.data.img = "http://localhost:8000/image/" + response.data.img;
                    }
                    this.data = response.data
                }).catch((e)=>{
                    console.log(e);
                })
            },
            passwordChgPage(id){
                this.$router.push({
                    name: 'passwordchange',
                    query: {id: id}
                })
            },
            messageAlert(mes) {
                if (mes !== undefined && mes !== "" && mes !== null) {
                    Swal.fire({
                    title: "success!",
                    text: mes,
                    icon: "success",
                    });
                }
                this.$router.replace({'query': null});
            },
        },
        mounted () {
            this.getData();
            this.messageAlert(this.$route.query.message);
        }
    }
</script>
