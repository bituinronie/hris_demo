require("../assets/scss/material-dashboard.scss");
const DashboardLayout = () =>
    import(
        /* webpackChunkName: "DashboardLayout" */ "../pages/Layout/DashboardLayout.vue"
    );
const Dashboard = () =>
    import(/* webpackChunkName: "Dashboard" */ "../pages/Dashboard.vue");
const TableList = () =>
    import(/* webpackChunkName: "TableList" */ "../pages/TableList.vue");
const Typography = () =>
    import(/* webpackChunkName: "Typography" */ "../pages/Typography.vue");
const Icons = () =>
    import(/* webpackChunkName: "Icons" */ "../pages/Icons.vue");
const Maps = () => import(/* webpackChunkName: "Maps" */ "../pages/Maps.vue");
const Notifications = () =>
    import(
        /* webpackChunkName: "Notifications" */ "../pages/Notifications.vue"
    );
const UpgradeToPRO = () =>
    import(/* webpackChunkName: "UpgradeToPRO" */ "../pages/UpgradeToPRO.vue");
const Employees = () =>
    import(/* webpackChunkName: "Employees" */ "../pages/Employees.vue");
const History = () =>
    import(/* webpackChunkName: "History" */ "../pages/History.vue");
const Reports = () =>
    import(/* webpackChunkName: "Reports" */ "../pages/Reports.vue");
const Login = () => import(/* UpgradeToPRO: "Login" */ "../pages/Login.vue");
const Positions = () =>
    import(/* webpackChunkName: "Positions" */ "../pages/Positions.vue");
const Schedule = () =>
    import(/* webpackChunkName: "Schedule" */ "../pages/Schedule.vue");
const Users = () =>
    import(/* webpackChunkName: "Users" */ "../pages/Users.vue");
const Settings = () =>
    import(/* webpackChunkName: "Settings" */ "../pages/Settings.vue");
const PreLoader = () =>
    import(/* webpackChunkName: "PreLoader" */ "../components/Preloader.vue");
const PortalSchedule = () =>
    import(
        /* webpackChunkName: "PortalSchedule" */ "../pages/PortalSchedule/PortalSchedule.vue"
    );
const Request = () =>
    import(/* webpackChunkName: "Request" */ "../pages/Request.vue");
const PortalRequest = () =>
    import(
        /* webpackChunkName: "PortalRequest" */ "../pages/PortalRequest/PortalRequest.vue"
    );

const Training = () =>
    import(/* webpackChunkName: "Training" */ "../pages/Training.vue");
const PortalTraining = () =>
    import(
        /* webpackChunkName: "PortalTraining" */ "../pages/PortalTraining/PortalTrainingEmployee.vue"
    );

//Appraisal
const Appraisal = () =>
    import(/* webpackChunkName: "Appraisal" */ "../pages/Appraisal.vue");

//Relations
const Relations = () =>
    import(/* webpackChunkName: "Relations" */ "../pages/Relations.vue");

//Applicant Matrix
const ApplicantMatrix = () =>
    import(
        /* webpackChunkName: "ApplicantMatrix" */ "../pages/ApplicantMatrix.vue"
    );

//Email Request Approving
const RequestApprovalURI = () =>
    import(
        /* webpackChunkName: "ApplicantMatrix" */ "../pages/ExternalAPI/RequestApprovalURI.vue"
    );
const routes = [
    {
        path: "/preloader",
        name: "preloader",
        component: PreLoader,
    },
    {
        // mode: 'history',
        path: "/",
        redirect: {
            name: "login",
        },
    },
    {
        path: "/login",
        name: "login",
        component: Login,
    },
    {
        path: "/request_approval_uri",
        name: "request_approval_uri",
        component: RequestApprovalURI,
    },
    {
        // mode: 'history',
        path: "/",
        component: DashboardLayout,
        redirect: "/employee",
        children: [
            {
                path: "dashboard",
                name: "Dashboard",
                component: Dashboard,
            },
            {
                path: "employee",
                name: "Employees",
                component: Employees,
                meta: {
                    permissions: ["employee"],
                },
            },
            {
                path: "history",
                name: "History",
                component: History,
                meta: {
                    permissions: ["service record"],
                },
            },
            {
                path: "schedule",
                name: "Schedule",
                component: Schedule,
                meta: {
                    permissions: [
                        "schedule",
                        "dtr",
                        "employee schedule",
                        "special date",
                    ],
                },
            },
            {
                path: "request",
                name: "Request",
                component: Request,
                meta: {
                    permissions: ["request"],
                },
            },
            {
                path: "portal-request",
                name: "Portal Request",
                component: PortalRequest,
                meta: {
                    permissions: ["portal request"],
                },
            },
            {
                path: "portal-schedule",
                name: "Employee Schedule",
                component: PortalSchedule,
                meta: {
                    permissions: ["portal employee schedule"],
                },
            },
            {
                path: "positions",
                name: "Positions",
                component: Positions,
                meta: {
                    permissions: ["position"],
                },
            },
            {
                path: "training",
                name: "Training",
                component: Training,
                meta: {
                    permissions: ["training"],
                },
            },
            {
                path: "portal-training",
                name: "Portal Training",
                component: PortalTraining,
                meta: {
                    permissions: ["portal training"],
                },
            },
            {
                path: "appraisal",
                name: "Appraisal",
                component: Appraisal,
            },
            {
                path: "relations",
                name: "Relations",
                component: Relations,
            },
            {
                path: "users",
                name: "Users",
                component: Users,
                meta: {
                    permissions: ["user"],
                },
            },
            {
                path: "reports",
                name: "Reports",
                component: Reports,
                meta: {
                    permissions: ["print"],
                },
            },
            {
                path: "applicant-matrix",
                name: "Applicant Matrix",
                component: ApplicantMatrix,
                meta: {
                    permissions: ["applicant"],
                },
            },
            {
                path: "settings",
                name: "Settings",
                component: Settings,
                meta: {
                    permissions: [
                        "setting",
                        "employee group",
                        "division",
                        "salary grade",
                        "request type",
                        "approver",
                    ],
                },
            },
            {
                path: "table",
                name: "Table List",
                component: TableList,
            },
            {
                path: "typography",
                name: "Typography",
                component: Typography,
            },
            {
                path: "icons",
                name: "Icons",
                component: Icons,
            },
            {
                path: "maps",
                name: "Maps",
                meta: {
                    hideFooter: true,
                },
                component: Maps,
            },
            {
                path: "notifications",
                name: "Notifications",
                component: Notifications,
            },
        ],
    },
];

export default routes;
