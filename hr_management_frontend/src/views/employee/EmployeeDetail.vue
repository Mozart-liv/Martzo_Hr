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
                </v-card>
            </div>
        <Footer></Footer>
    </div>
</template>

<script>
import axios from 'axios';
    import Header from "../AppHeader.vue";
    import Footer from "../FooterPage.vue";
    export default {
        name: 'EmployeeDetail',
        components: {
            Header,
            Footer,
        },
        data () {
            return {
                id: "",
                data: {}
            }
        },
        methods: {
            getEmployeeData (id) {
                axios.get("http://localhost:8000/api/employee/userData/" + id).then((response)=>{
                    
                    if(response.data.img == null){
                        response.data.img = "http://localhost:8000/image/default.jpg";
                    }else{
                        response.data.img = "http://localhost:8000/image/" + response.data.img;
                    }
                    this.data = response.data;

                }).catch((e)=>{
                    console.log(e);
                })
            }
        },
        mounted () {
            this.id = this.$route.query.id;
            this.getEmployeeData(this.id);
        }
        
    }
</script>

<style scoped>

p{
    margin-bottom: 0;
}
</style>
