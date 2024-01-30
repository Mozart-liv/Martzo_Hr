<template>
    <div >
        <Header></Header>
        <h1 v-if="!login">Login please</h1>
        <h1 v-else>Home Page</h1>
        <Footer></Footer>
    </div>
</template>

<script>
    import Header from '../views/AppHeader.vue';
    import Footer from '../views/FooterPage.vue';
    import { mapGetters } from "vuex";
    export default {
        name: 'HomePage',
       components: {
        Header, Footer
       },
        data () {
            return {
                login: false
            }
        },
        computed: {
            ...mapGetters(["userInfo", "getToken"]),
        },
        methods: {
            checkLogin () {
                
                if(this.getToken !== ""){
                    this.login = true
                }

            }
        },
        mounted () {
            this.checkLogin()
        }
    }
</script>

<style lang="stylus" scoped>

</style>
