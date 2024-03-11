<template>
    <div>
        <Header title="Employee update"></Header>
        <div class="container">
            <div class="card my-15 ">
                <div class="card-body p-5">
                    <h1 class="mb-5 text-primary">Update Employee</h1>
                    <form class="text-start row">
                        <div class="col-md-6 px-3">
                            <div class="form-gorup mb-4">
                                <label class="form-label" >Employee ID</label>
                                <input type="text" v-model="data.employee_id" class="form-control form-control-lg" :class="errors.employee_id ? 'is-invalid' : ''" >
                                <div v-if="errors && errors.employee_id" class="text-danger">
                                    {{ errors.employee_id[0] }} 
                                </div>
                            </div>
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

                            <div class="form-gorup mb-4">
                                <label class="form-label" for="form3Example1cg">Nrc Number</label>
                                <input type="text" v-model="data.nrc" class="form-control form-control-lg" :class="errors.nrc ? 'is-invalid' : ''" />    
                                <div v-if="errors && errors.nrc" class="text-danger">
                                    {{ errors.nrc[0] }} 
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
                                <label class="form-label">Image</label>
                                <input type="file" @change="imgInput" ref="fileInput" class="form-control form-control-lg" :class="errors.img ? 'is-invalid' : ''" />    
                                <div v-if="errors && errors.img" class="text-danger">
                                    {{ errors.img }} 
                                </div>
                            </div>

                            <div class="form-group mb-4">
                                <label class="form-label">Date of Join</label>
                                <input type="date" v-model="data.date_of_join" class="form-control form-control-lg" :class="errors.date_of_join ? 'is-invalid' : ''" />    
                                
                            </div>

                            <div class="form-group mb-4">
                                <label class="form-label">Gender</label>
                                <select class="select form-control form-control-lg" v-model="data.gender" :class="errors.gender ? 'is-invalid' : ''" >
                                    <option  disabled >Gender</option>
                                    <option value="female" >Female</option>
                                    <option value="male">Male</option>
                                </select>
                                <div v-if="errors && errors.gender" class="text-danger">
                                    {{ errors.gender[0] }} 
                                </div>
                            </div>

                            <div class="form-group mb-4">
                                <label class="form-label">Department</label>
                                <select class="select form-control form-control-lg" v-model="data.department_id" :class="errors.department_id ? 'is-invalid' : ''" > 
                                    <option  disabled >Department</option>
                                    <option v-for="(department, index) in departmentData" :key="index" :value="department.id">{{ department.title }}</option>
                                </select>
                                <div v-if="errors && errors.department_id" class="text-danger">
                                    {{ errors.department_id[0] }} 
                                </div>
                            </div>

                            <div class="form-group mb-4">
                                <label class="form-label">Role</label>
                                <select class="select form-control form-control-lg" v-model="data.role_id" :class="errors.role_id ? 'is-invalid' : ''" >
                                    <option  disabled >Role</option>
                                    <option v-for="(role, index) in roleData" :key="index" :value="role.id" >{{ role.title }}</option>
                                </select>
                                <div v-if="errors && errors.role_id" class="text-danger">
                                    {{ errors.role_id[0] }} 
                                </div>
                            </div>

                            <div class="form-group mb-4">
                                <label class="form-label">Is Present?</label>
                                <select class="select form-control form-control-lg" v-model="data.is_present" :class="errors.is_present ? 'is-invalid' : ''" >
                                    <option  disabled >Is present</option>
                                    <option value="1">Present</option>
                                    <option value="0">Leave</option>
                                </select>
                                <div v-if="errors && errors.is_present" class="text-danger">
                                    {{ errors.is_present[0] }} 
                                </div>
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
        name: 'UpdateEmployee',
        components: {
        Header, Footer
       },
        data () {
            return {
                id: "",
                data: {},
                departmentData: [],
                roleData: [],
                errors: {}
            }
        },
        methods: {
            getformData () {
            axios.get('http://localhost:8000/api/employee/formData').then((response)=>{
                    this.departmentData = response.data.department;
                    this.roleData = response.data.role;
                })
            },
            getOldData(id){
                axios.get("http://localhost:8000/api/employee/userData/" + id).then((response)=>{
                    console.log(response);
                    this.data = response.data
                }).catch((e)=>{
                    console.log(e);
                })
            },
            imgInput(event){
             let file = this.$refs.fileInput.files[0];
            let allow = ['image/jpeg', 'image/png', 'image/jpg'];

            if (!allow.includes(file.type)) {
                this.errors = {img: 'Invalid file type. Only jpeg, png, and gif are allowed.'};
            }else{
                this.errors.img = null;
                this.data.img = event.target.files[0];
            }
            },
            UpdateEmployee(){
                 const form = new FormData();
                form.append('id', this.id)
                form.append('employee_id', this.data.employee_id);
                form.append('name', this.data.name);
                form.append('email', this.data.email);
                form.append('password', this.data.password);
                form.append('phone', this.data.phone);
                form.append('nrc', this.data.nrc);
                form.append('img', this.data.img);
                form.append('address', this.data.address);
                form.append('date_of_join', this.data.date_of_join);
                form.append('gender', this.data.gender);
                form.append('department_id', this.data.department_id);
                form.append('role_id', this.data.role_id);
                form.append('is_present', this.data.is_present);
                axios.post("http://localhost:8000/api/employee/update", form).then((response)=>{
                    if(response.data.status == true){
                    this.$router.push({
                        name: 'employee',
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
            this.getformData();
            this.getOldData(this.id);
        }
    }
</script>

<style lang="stylus" scoped>

</style>
