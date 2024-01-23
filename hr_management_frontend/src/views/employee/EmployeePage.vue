<template>
    <div>
        <Header></Header>
            <div class="col-md-9 my-5 mx-auto">
                <button class="btn btn-primary" @click="goCreate()">
                    <i class="fa-regular fa-square-plus"></i>
                Create Employee
            </button>
            <div class="card mt-3">
                <div class="card-body p-4 ">
                <table class="display table table-bordered text-center cell-border compact stripe" id="mytable">
                <thead>
                    <tr>
                        <th>Employee Id</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Role</th>
                        <th>Department</th>
                        <th>Is_present</th>
                    </tr>
                </thead>
                </table>
            </div>
            </div>
            </div>
            
            

        <Footer></Footer>     
    </div>
</template>

<script>
    import axios from 'axios';
    import { mapGetters } from "vuex";
    import DataTable from 'datatables.net-bs5';
    import 'datatables.net-buttons-bs5';
    import 'datatables.net-buttons/js/buttons.colVis.mjs';
    import DateTime from 'datatables.net-datetime';
    import 'datatables.net-responsive-bs5';
    import 'datatables.net-searchbuilder-bs5';
    import 'datatables.net-select-bs5';
    import $ from 'jquery';
    import Header from '../AppHeader.vue';
    import Footer from '../FooterPage.vue';
    import Swal from 'sweetalert2';
    export default {
        name: 'EmployeePage',
        components: {
        Header, Footer
       },
        data () {
            return {
               message : ""
            }
        },
        computed: {
            ...mapGetters(["userInfo", "loginStatus"]),
        },
        methods: {
            getData () {
                axios.post("http://localhost:8000/api/employeeList", this.userInfo ).then((response)=>{
                    console.log(response.data);
                    $('#mytable').DataTable( {
                    data: response.data.employeeData,
                    columns: [
                        { data: 'id', class: 'align-middle' },
                        { data: 'name', class: 'align-middle' },
                        { data: 'email', class: 'align-middle' },
                        { data: 'phone', class: 'align-middle' },
                        { data: 'role', class: 'align-middle' },
                        { data: 'department_name', class: 'align-middle' },
                        { data: 'is_present', class: 'align-middle' }
                    ]
                } );
                }).catch((e)=>{
                    console.log(e);
                })
            },
            goCreate(){
            this.$router.push({
                name: 'create#employee'
            })
            },
            messageAlert(mes){
                Swal.fire({
                    title: "success!",
                    text: mes,
                    icon: "success"
                });
            }
        },
        
        mounted () {
            this.message = this.$route.query.message;
            this.getData()
            this.messageAlert(this.message)
        }
    }
</script>


