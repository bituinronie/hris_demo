<template>
    <div class="content">
        <div class="md-layout">
            <div
                class="md-layout-item md-small-size-100 md-size-100 text-right"
            >
                <!-- <md-button class="md-primary md-dense md-raised" @click="searchEmp" v-if="currentPage === 'schedule'">Attach Files</md-button> -->
                <md-button
                    :disabled="showAllTrainings"
                    v-if="$permissions.includes('search training')"
                    class="md-primary md-dense md-raised"
                    @click="getAllTrainings()"
                    >Manage Trainings</md-button
                >
                <md-button
                    :disabled="showMyTrainings"
                    class="md-primary md-dense md-raised"
                    v-if="$permissions.includes('search training')"
                    @click="getMyTrainings()"
                    >My Trainings</md-button
                >
            </div>
        </div>

        <Trainings v-if="showAllTrainings"></Trainings>
        <PortalTrainingEmployee v-if="showMyTrainings"></PortalTrainingEmployee>
    </div>
</template>

<script>
import UserAction from "../mixins/userAction.js";
// const UserAction = () =>
//     import(
//         /* webpackChunkName: "UserAction" */ "../mixins/userAction.js"
//     );
const Trainings = () =>
    import(
        /* webpackChunkName: "Trainings" */ "../pages/Training/Trainings.vue"
    );

const PortalTrainingEmployee = () =>
    import(
        /* webpackChunkName: "PortalTrainingEmployee" */ "../pages/PortalTraining/PortalTrainingEmployee.vue"
    );
// const ListEmployee = () =>
//     import(
//         /* webpackChunkName: "ListEmployee" */ "../pages/Employee/ListEmployee.vue"
//     );
// const DialogCard = () =>
//     import(
//         /* webpackChunkName: "DialogCard" */ "../components/Cards/DialogCard.vue"
//     );
// import DialogCard from "../components/Cards/DialogCard.vue";

let permissions = JSON.parse(localStorage.getItem("permissions"));

export default {
    name: "Training",
    mixins: [UserAction],
    components: {
        // ListEmployee,
        PortalTrainingEmployee,
        // DialogCard,
        Trainings,
    },
    data() {
        return {
            permissions,
            empSearch: false,

            // Trainings Table
            showMyTrainings: true,
            showAllTrainings: false,
        };
    },

    methods: {
        getMyTrainings() {
            this.showMyTrainings = true;
            this.showAllTrainings = false;
        },
        getAllTrainings() {
            this.showAllTrainings = true;
            this.showMyTrainings = false;
        },
    },
};
</script>

<style scoped>
.emp-search {
    float: right;
}
.md-card-header {
    background-color: #042278 !important;
}
</style>
<style lang="scss" scoped>
.md-checkbox {
    display: flex;
}
</style>
