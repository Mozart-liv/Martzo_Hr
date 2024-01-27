<template>
    <div>
    <div class="footer-menu position-fixed w-100 bottom-0 bg-grey">
          <div class="row justify-content-center">
            <div class="col-md-8 p-2 d-flex justify-content-between">
              <a href="">
                <i class="fas fa-home"></i>
              </a>
              <a href="">
                <i class="fas fa-home"></i>
              </a>
              <div @click="profile()" class="d-flex flex-column align-center">
                <i class="fas fa-user"></i>
                Profile
              </div>
            </div>
          </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'FooterPage',
        methods: {
          profile(){
          this.$router.push({
            name: 'profile'
          })
        },
        }
    }
</script>

<style lang="stylus" scoped>

</style>
