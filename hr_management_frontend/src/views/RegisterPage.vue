<template>

    <div class="container h-100">
		
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-md-9 col-lg-7 col-xl-6">
          <div class="card" style="border-radius: 15px;">
            <div class="card-body p-5">
              <h2 class="text-uppercase text-center mb-5">Create an account</h2>
				<div class="alert alert-danger" role="alert" v-if="error != ''" >
					{{ error }}
				</div>
              <form class="text-start">

                <div class="form-gorup mb-4">
                  <label class="form-label" for="form3Example1cg">Your Name</label>
                  <input type="text" id="form3Example1cg" v-model="user.name" class="form-control form-control-lg" />
                  
                </div>

                <div class="form-group mb-4">
                  <label class="form-label" for="form3Example3cg">Your Email</label>
                  <input type="email" id="form3Example3cg" v-model="user.email" class="form-control form-control-lg" />
                </div>

                <div class="form-group mb-4">
                  <label class="form-label" for="form3Example3cg">Your Phone</label>
                  <input type="number" id="form3Example3cg" v-model="user.phone" class="form-control form-control-lg" />
                  
                </div>

                <div class="form-group mb-4">
					<label class="form-label" for="form3Example3cg">Gender</label>
                  <select class="select form-control form-control-lg" v-model="user.gender">
                    <option  disabled >Gender</option>
                    <option value="female" >Female</option>
                    <option value="male">Male</option>
                  </select>
                   
                </div>

                <div class="form-group mb-4">
					<label class="form-label" for="form3Example4cg">Password</label>
                  <input type="password" id="form3Example4cg" v-model="user.password" class="form-control form-control-lg" />
                  
                </div>

                <div class="form-group mb-4">
					<label class="form-label" for="form3Example4cdg">Repeat your password</label>
                  <input type="password" id="form3Example4cdg" v-model="confirmPassword" class="form-control form-control-lg" />
                  
                </div>


                <div class="d-flex justify-content-center">
                  <button type="button"
                    class="btn btn-success btn-block btn-lg gradient-custom-4 text-body" @click="checkForm()">Register</button>
                </div>

                <p class="text-center text-muted mt-5 mb-0">Have already an account?
					<span class="text-decoration-underline text-info" @click="goLoginPage()">Login here</span>	
				</p>

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
        name: 'RegisterPage',
        data () {
            return {
                user : {
                    name: "",
                    email: "",
                    phone: "",
                    gender: "",
                    password: ""
                },
                error : "",
                confirmPassword: "",
				status : ""
            }
        },
		methods: {
			checkForm () {
				if(this.user.name == "" && this.user.email == "" && this.user.phone == "" && this.user.gender == "" && this.user.password == "" ){
					this.error = "Required something! Check your form"
				}else{
					if(this.user.password !== this.confirmPassword){
						this.error = "confirm password must be match with password!"
					}else{
						this.register();
					}
				}
				
			},
			register(){
				axios.post("http://localhost:8000/api/user/register", this.user).then((response) => {
					console.log(response.data);
					this.status = response.data

					if(this.status == true){
						this.goLoginPage();
					}else{
						this.error = "Email has already used! try with another..."
					}
				})
				.catch(function (error) {
					console.log(error);
				});
			},
			goLoginPage(){
				this.$router.push({
					name: 'login'
				});
			}
		},
    }
</script>

<style lang="stylus" scoped>

</style>
