import { mapState } from "vuex";

export default {
    data() {
        return {
            isUpdate: false,
            empSelected: false,
        };
    },
    // computed: mapState({
    //     userAction: state => state.userStatusAction
    //     }),
    computed: {
        ...mapState({
            userAction: (state) => state.userStatusAction,
            empSelectionID: (state) => state.currentSelectionUserId,
            tabSelection: (state) => state.currentTabSelection,
            empSelectionName: (state) => state.currentSelectionUserName,
        }),
        newCurrentUserAction: function () {
            let messageCurrentAction = null;
            console.log(this.userAction);
            if (this.userAction === "add") {
                messageCurrentAction =
                    "You are currently adding a new employee";
                this.empSelected = false;
                this.isUpdate = false;
            }
            if (this.userAction === "emp_selected") {
                messageCurrentAction =
                    "You are currently viewing the information of this employee";
                this.empSelected = true;
                this.isUpdate = false;
            }
            if (this.userAction === "edit") {
                messageCurrentAction =
                    "You are currently updating the profile of this employee";
                this.empSelected = false;
                this.isUpdate = true;
            }
            return messageCurrentAction;
        },
        newCurrentTabSelection: {
            get: function () {
                return this.tabSelection;
            },
            set: function (tabName) {
                this.tabSelection = tabName;
            },
        },
    },
};
