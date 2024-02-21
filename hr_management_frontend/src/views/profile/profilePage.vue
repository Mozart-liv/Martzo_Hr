<template>
    <div>
        <Header></Header>
            <div class="col-md-10 mx-auto p-3 my-15">
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
                            <h3>{{ data.name }}</h3>
                            <p class="text-grey">{{ data.employee_id }}</p>
                            <v-chip color="primary">
                                {{ data.department_name }}
                            </v-chip>
                        </div>
                    </div>
                    <div class="mt-5 row ps-3">
                        <div class="col">
                            <div class="mb-5">
                                <span class="text-grey m-2">Phone :</span>
                                <span>{{ data.phone }}</span>
                            </div>

                             <div class="mb-5">
                                <span class="text-grey m-2">Email :</span>
                                <span>{{ data.email }}</span>
                            </div>

                            <div class="mb-5">
                                <span class="text-grey m-2">Role :</span>
                                <span>{{ data.role }}</span>
                            </div>

                             <div class="mb-5">
                                <span class="text-grey m-2">Gender :</span>
                                <span>{{ data.gender }}</span>
                            </div>
                        </div>

                        <div class="col">
                             <div class="mb-5">
                                <span class="text-grey m-2">Address :</span>
                                <span>{{ data.address }}</span>
                            </div>

                            <div class="mb-5">
                                <span class="text-grey m-2">Nrc Number :</span>
                                <span>{{ data.nrc }}</span>
                            </div>

                             <div class="mb-5">
                                <span class="text-grey m-2">Date of Join :</span>
                                <span>{{ data.date_of_join }}</span>
                            </div>

                             <div class="mb-5">
                                <span class="text-grey m-2">Is present? :</span>
                                <v-chip
                                    :color="data.is_present == 1 ? 'green' : 'red'"
                                    :text="data.is_present == 1 ? 'Present' : 'Leave'"
                                    class="text-uppercase"
                                    label
                                    size="small"
                                ></v-chip>
                            </div>
                        </div>
                        
                    </div>
                    <div class="text-end mt-3">
                        <button class="btn btn-primary me-3" @click="update(data.id)">
                            <i class="fa-solid fa-pencil"></i>
                            Update Profile
                        </button>
                        <button class="btn btn-primary me-3" @click="passwordChgPage(data.id)">
                            <i class="fa-solid fa-key"></i>
                            Change Password
                        </button>
                        
                    </div>
                    <div class="text-end mt-3">
                        <button class="btn btn-danger me-3" @click="logout()">
                            <i class="fa-solid fa-right-from-bracket"></i>
                            Logout
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
            ...mapGetters(["userInfo", "getToken"]),
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
            update(id){
                this.$router.push({
                name: 'update#profile',
                query: {
                    id: id
                }
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
            logout(){
                Swal.fire({
                    title: "Are you sure to logout?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, logout!"
                    }).then((result) => {
                    if (result.isConfirmed) {
                        location.reload();
                }
                });
               
            }
        },
        mounted () {
            this.messageAlert(this.$route.query.message)
            this.getData();
        }
    }
</script>
