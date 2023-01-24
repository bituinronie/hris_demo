export default {
    beforeMount() {
        console.log(process.env.MIX_APP_URL)

        //Set Base URL; URL and Port
        // localStorage.setItem('base_url', 'http://127.0.0.1:8000')
        localStorage.setItem('base_url', 'http://127.0.0.1:8088')
        // localStorage.setItem("base_url", process.env.MIX_APP_URL);
        // localStorage.setItem("app_name", process.env.MIX_APP_NAME);

        const getToken = localStorage.getItem('token')
        console.log(getToken)
        if (getToken === null) {
            //Do Nothing
        } else {
            this.$router.push({ name: 'Dashboard' })
        }
    },
}
