<template>
    <div>
        <Header></Header>
            <div class="col-md-10 mx-auto p-3 my-15">
                <div class="mx-auto col-md-8 mb-3" onclick="history.back()">
                    <v-icon>mdi-arrow-left-top</v-icon>Back
                </div>
                <v-card class="mx-auto p-4 col-md-8" elevation="6">

                    <div class="mt-5 row ps-3">
                        <div class="col">
                            <div class="mb-5">
                                <div>Name :</div>
                                <span class="text-grey ">{{ data.name }}</span>
                            </div>

                             <div class="mb-5">
                                <div>Email :</div>
                                <span class="text-grey ">{{ data.email }}</span>
                            </div>

                            <div class="mb-5">
                                <div>Phone :</div>
                                <span class="text-grey ">{{ data.phone }}</span>
                            </div>

                             <div class="mb-5">
                                <div>Address :</div>
                                <span class="text-grey ">{{ data.address }}</span>
                            </div>
                        </div>

                        <div class="col">
                             <div class="mb-5">
                                <div>Office start time :</div>
                                <span class="text-grey ">{{ data.office_start_time }}</span>
                            </div>

                            <div class="mb-5">
                                <div>Office end time :</div>
                                <span class="text-grey ">{{ data.office_end_time }}</span>
                            </div>

                            <div class="mb-5">
                                <div>Break start time :</div>
                                <span class="text-grey ">{{ data.break_start_time }}</span>
                            </div>

                            <div class="mb-5">
                                <div>Break end time :</div>
                                <span class="text-grey ">{{ data.break_end_time }}</span>
                            </div>

                        </div>
                        
                    </div>
                    <div class="text-end mt-3">
                        <button class="btn btn-primary me-3" @click="update()">
                            <i class="fa-solid fa-pencil"></i>
                            Update Company
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
    import Swal from "sweetalert2";
    import axios from 'axios';
    export default {
        name: 'CompanySetting',
          components: {
            Header,
            Footer,
        },
        data () {
            return {
               data: {}
            }
        },
        methods: {
            getData () {
               axios.get("http://localhost:8000/api/company/data").then((response)=>{
                    console.log(response);
                    this.data = response.data;
                    console.log(this.data);
                }).catch((e)=>{
                    console.log(e);
                })
            },
            update(){
                this.$router.push({
                    name: 'update#company'
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

<style lang="stylus" scoped>

</style>
