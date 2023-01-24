export default {
    methods: {
        logOut() {
            window.localStorage.clear();
            window.sessionStorage.clear();
            this.$router.go({ name: "login" });
            // this.$router.push();
        },
    },
};
