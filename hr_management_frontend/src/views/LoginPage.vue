<template>
    <div class="container h-100">
		
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-md-9 col-lg-7 col-xl-6">
          <div class="card" style="border-radius: 15px;">
            <div class="card-body p-5">
              <h2 class="text-uppercase text-center mb-5">Create an account</h2>
              <form class="text-start">

                 <div class="form-group mb-4">
                    <label class="form-label">Email</label>
                    <input type="email" v-model="user.email" class="form-control form-control-lg" :class="errors.email ? 'is-invalid' : ''" />
                    <div v-if="errors && errors.email" class="text-danger">
                        {{ errors.email[0] }} 
                    </div>
                  </div>

                <div class="form-group mb-4">
                    <label class="form-label" for="form3Example4cg">Password</label>
                    <input type="password" v-model="user.password" id="form3Example4cg" class="form-control form-control-lg" :class="errors.password ? 'is-invalid' : ''" />
                    <div v-if="errors && errors.password" class="text-danger">
                        {{ errors.password[0] }} 
                    </div>
                </div>


                <div class="d-flex justify-content-center">
                  <button type="button"
                    class="btn btn-success btn-block btn-lg gradient-custom-4 text-body" @click="login()">Login</button>
                </div>

                <p class="text-center text-muted mt-5 mb-0">Haven't account yet?
               <span class="text-decoration-underline text-info" @click="registerPage()">Register here</span>	</p>
                  <div v-if="errors.message" class="text-danger">
                      {{ errors.message }}
                  </div>
              </form>

            </div>
          </div>
        </div>
      </div>
    </div>
</template>

<script>
	import axios from 'axios';
    export default {
        data () {
            return {
                user: {
                    email: "",
                    password: ""
                },
                errors: {}
            }
        },
        methods: {
          login(){
                axios.post("http://localhost:8000/api/user/login", this.user).then((response)=>{
                  if(response.data.status == true){
                    this.setData(response);
                    this.goHomePage();
                  }else{
                    this.errors.message = response.data.message
                  }
                }).catch((e)=>{
                console.log(e);
                if(e.response.status == 422){
                    this.errors = e.response.data.errors;
                }
            })
          },
          setData(response){
            this.$store.dispatch('setUserData', response.data.user);
            this.$store.dispatch('setToken', response.data.token);
          },
          goHomePage(){
            this.$router.push({
              name: 'home'
            })
          },
          registerPage(){
            this.$router.push({
              name: 'register'
            })
          }
        }
    }
</script>
