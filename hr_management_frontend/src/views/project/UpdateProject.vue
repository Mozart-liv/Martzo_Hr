<template>
    <div>
        <Header></Header>
        <div class="container">
            <div class="card my-15 ">
                <div class="card-body p-5">
                    <h1 class="mb-5 text-primary">Update Employee</h1>
                    <form class="text-start row">
                        <div class="form-group mb-4">
              <label class="form-label">File</label>
              <input
                type="file"
                @change="fileInput"
                ref="fileInput"
                class="form-control form-control-lg"
                :class="errors.files ? 'is-invalid' : ''"
                multiple
              />
              <div v-if="errors && errors.files" class="text-danger">
                {{ errors.files }}
              </div>
            </div>

            <div class="form-group mb-4">
              <label class="form-label">Start Date</label>
              <input
                type="date"
                v-model="data.start_date"
                class="form-control form-control-lg"
                :class="errors.start_date ? 'is-invalid' : ''"
              />
              <div v-if="errors && errors.start_date" class="text-danger">
                {{ errors.start_date[0] }}
              </div>
            </div>

            <div class="form-group mb-4">
              <label class="form-label">Deadline</label>
              <input
                type="date"
                v-model="data.deadline"
                class="form-control form-control-lg"
                :class="errors.deadline ? 'is-invalid' : ''"
              />
              <div v-if="errors && errors.deadline" class="text-danger">
                {{ errors.deadline[0] }}
              </div>
            </div>

            <div class="form-group mb-4">
              <label class="form-label">Priority</label>
              <select
                class="select form-control form-control-lg"
                :class="errors.priority ? 'is-invalid' : ''"
                v-model="data.priority"
              >
                <option disabled>Priority</option>
                <option value="low">Low</option>
                <option value="medium">Medium</option>
                <option value="high">High</option>
              </select>
              <div v-if="errors && errors.priority" class="text-danger">
                {{ errors.priority[0] }}
              </div>
            </div>

            <div class="form-group mb-4">
              <label class="form-label">Leader</label>
              <select
                class="select form-control form-control-lg"
                :class="errors.leader ? 'is-invalid' : ''"
                v-model="data.leader"
              >
                <option disabled>leader</option>
                <option
                  v-for="(employee, index) in employeeData"
                  :key="index"
                  :value="employee.id"
                >
                  {{ employee.name }}
                </option>
              </select>
              <div v-if="errors && errors.leader" class="text-danger">
                {{ errors.leader[0] }}
              </div>
            </div>

            <div class="form-group mb-4">
              <label class="form-label">Members</label>
              <select
                class="select form-control form-control-lg"
                :class="errors.members ? 'is-invalid' : ''"
                v-model="data.members"
                multiple
              >
                <option disabled>members</option>
                <option
                  v-for="(employee, index) in employeeData"
                  :key="index"
                  :value="employee.id"
                >
                  {{ employee.name }}
                </option>
              </select>
              <div v-if="errors && errors.members" class="text-danger">
                {{ errors.members[0] }}
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
        name: 'UpdateProject',
        components: {
        Header, Footer
       },
        data () {
            return {
                id: "",
                data: {},
                employeeData: [],
                priorityValues: ["low", "medium", "height"],
                errors: {}
            }
        },
        methods: {
            getformData () {
             axios.get("http://localhost:8000/api/employeeList").then((response) => {
                this.employeeData = response.data.employeeData;
                console.log(this.employeeData);
            });
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
