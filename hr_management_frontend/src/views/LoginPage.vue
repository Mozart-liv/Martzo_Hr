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

                <div class="form-group mb-4">
                  <label class="form-label" for="form3Example3cg">Your Email</label>
                  <input type="email" id="form3Example3cg" v-model="user.email" class="form-control form-control-lg" />
                </div>

                <div class="form-group mb-4">
					<label class="form-label" for="form3Example4cg">Password</label>
                  <input type="password" id="form3Example4cg" v-model="user.password" class="form-control form-control-lg" />
                  
                </div>


                <div class="d-flex justify-content-center">
                  <button type="button"
                    class="btn btn-success btn-block btn-lg gradient-custom-4 text-body" @click="checkForm()">Login</button>
                </div>

                <p class="text-center text-muted mt-5 mb-0">Haven't account yet?
				<span class="text-decoration-underline text-info" @click="registerPage()">Register here</span>	</p>

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
				error: ""   
            }
        },
        methods: {
            checkForm () {
                if(this.user.email == "" && this.user.password == "" ){
					this.error = "Required something! Check your form"
				}else{
					this.login()
				}
            },
            login(){
                axios.post("http://localhost:8000/api/user/login", this.user).then((response)=>{
                  console.log(response);
                    if(!response.data.message){
						this.error = "Wrong password! try again"
					}else{
						this.setData(response);
						this.goHomePage()

					}
                })
            },
			setData(response){
				this.$store.dispatch('setUserData', response.data.user);
				this.$store.dispatch('setLoginStatus', response.data.message);
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
