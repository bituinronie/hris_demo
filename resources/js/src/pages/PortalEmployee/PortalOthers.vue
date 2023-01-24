<template>
    <form>
        <md-card>
            <!-- <md-card-header :data-background-color="dataBackgroundColor"> -->
            <md-dialog-alert
                :md-active.sync="saved"
                :md-content="notificationMessage"
                md-confirm-text="Okay"
            />
            <md-card-content style="margin-top: 20px">
                <div class="md-layout">
                    <div class="md-layout-item md-small-size-100 md-size-50">
                        Are you related by consanguinity or affinity to the
                        appointing or recommending authority, or to the chief of
                        bureau or office or to the person who has immediate
                        supervision over you in the Office, Bureau or Department
                        where you will be appointed, within the third degree?
                        <br />
                        <md-radio
                            v-model="relation.ans"
                            :value="conditionTrue"
                            :disabled="isUpdateEmployee === 'false'"
                        >
                            Yes
                        </md-radio>
                        <md-radio
                            v-model="relation.ans"
                            :value="conditionFalse"
                            :disabled="isUpdateEmployee === 'false'"
                        >
                            No
                        </md-radio>
                        <br />
                        <md-field>
                            <md-input
                                v-model="relation.details"
                                type="text"
                                placeholder="If Yes, give details"
                                :disabled="isUpdateEmployee === 'false'"
                            ></md-input>
                        </md-field>
                    </div>

                    <div
                        class="md-layout-item md-small-size-100 md-size-50"
                        style="color: black !important"
                    >
                        Have you resigned from the government service during the
                        three (3)-month period before the last election to
                        promote/actively campaign for a national or local
                        candidate?
                        <br />
                        <md-radio
                            v-model="resignation.ans"
                            :value="conditionTrue"
                            :disabled="isUpdateEmployee === 'false'"
                        >
                            Yes
                        </md-radio>
                        <md-radio
                            v-model="resignation.ans"
                            :value="conditionFalse"
                            :disabled="isUpdateEmployee === 'false'"
                        >
                            No
                        </md-radio>
                        <br />
                        <md-field>
                            <md-input
                                v-model="resignation.details"
                                type="text"
                                placeholder="If Yes, give details"
                                :disabled="isUpdateEmployee === 'false'"
                            ></md-input>
                        </md-field>
                    </div>

                    <div class="md-layout-item md-small-size-100 md-size-50">
                        Are you related by consanguinity or affinity to the
                        appointing or recommending authority, or to the chief of
                        bureau or office or to the person who has immediate
                        supervision over you in the Office, Bureau or Department
                        where you will be appointed, within the fourth degree
                        (for Local Government Unit - Career Employees)?
                        <br />
                        <md-radio
                            v-model="relationLGU.ans"
                            :value="conditionTrue"
                            :disabled="isUpdateEmployee === 'false'"
                        >
                            Yes
                        </md-radio>
                        <md-radio
                            v-model="relationLGU.ans"
                            :value="conditionFalse"
                            :disabled="isUpdateEmployee === 'false'"
                        >
                            No
                        </md-radio>
                        <br />
                        <md-field>
                            <md-input
                                v-model="relationLGU.details"
                                type="text"
                                placeholder="If Yes, give details"
                                :disabled="isUpdateEmployee === 'false'"
                            ></md-input>
                        </md-field>
                    </div>

                    <div class="md-layout-item md-small-size-100 md-size-50">
                        Have you acquired the status of an immigrant or
                        permanent resident of another country?
                        <br />
                        <md-radio
                            v-model="immigrantStatus.ans"
                            :value="conditionTrue"
                            :disabled="isUpdateEmployee === 'false'"
                        >
                            Yes
                        </md-radio>
                        <md-radio
                            v-model="immigrantStatus.ans"
                            :value="conditionFalse"
                            :disabled="isUpdateEmployee === 'false'"
                        >
                            No
                        </md-radio>
                        <br />
                        <md-field>
                            <md-input
                                v-model="immigrantStatus.details"
                                type="text"
                                placeholder="If Yes, give details"
                                :disabled="isUpdateEmployee === 'false'"
                            ></md-input>
                        </md-field>
                    </div>

                    <div class="md-layout-item md-small-size-100 md-size-50">
                        Have you ever been found guilty of any administrative
                        offense?
                        <br />
                        <md-radio
                            v-model="guilty.ans"
                            :value="conditionTrue"
                            :disabled="isUpdateEmployee === 'false'"
                        >
                            Yes
                        </md-radio>
                        <md-radio
                            v-model="guilty.ans"
                            :value="conditionFalse"
                            :disabled="isUpdateEmployee === 'false'"
                        >
                            No
                        </md-radio>
                        <br />
                        <md-field>
                            <md-input
                                v-model="guilty.details"
                                type="text"
                                placeholder="If Yes, give details"
                                :disabled="isUpdateEmployee === 'false'"
                            ></md-input>
                        </md-field>
                    </div>

                    <div class="md-layout-item md-small-size-100 md-size-50">
                        Have you been criminally charged before any court?
                        <br />
                        <md-radio
                            v-model="charge.ans"
                            :value="conditionTrue"
                            :disabled="isUpdateEmployee === 'false'"
                        >
                            Yes
                        </md-radio>
                        <md-radio
                            v-model="charge.ans"
                            :value="conditionFalse"
                            :disabled="isUpdateEmployee === 'false'"
                        >
                            No
                        </md-radio>
                        <br />
                        <md-field>
                            <md-input
                                v-model="charge.details"
                                type="text"
                                placeholder="Criminally Charge Status"
                                :disabled="isUpdateEmployee === 'false'"
                            ></md-input>
                        </md-field>
                    </div>

                    <div class="md-layout-item md-small-size-100 md-size-50">
                        Criminally Charge Date
                        <!-- <md-field> -->
                        <md-datepicker
                            :md-model-type="String"
                            label="Date From"
                            v-model="charge.date"
                            :disabled="isUpdateEmployee === 'false'"
                        >
                        </md-datepicker>
                        <!-- </md-field> -->
                    </div>

                    <div class="md-layout-item md-small-size-100 md-size-50">
                        Have you ever been convicted of any crime or violation
                        of any law, decree, ordinance or regulation by any court
                        or tribunal?
                        <br />
                        <md-radio
                            v-model="convicted.ans"
                            :value="conditionTrue"
                            :disabled="isUpdateEmployee === 'false'"
                        >
                            Yes
                        </md-radio>
                        <md-radio
                            v-model="convicted.ans"
                            :value="conditionFalse"
                            :disabled="isUpdateEmployee === 'false'"
                        >
                            No
                        </md-radio>
                        <br />
                        <md-field>
                            <md-input
                                v-model="convicted.details"
                                type="text"
                                placeholder="If Yes, give details"
                                :disabled="isUpdateEmployee === 'false'"
                            ></md-input>
                        </md-field>
                    </div>

                    <div class="md-layout-item md-small-size-100 md-size-50">
                        Have you ever been separated from the service in any of
                        the following modes: resignation, retirement, dropped
                        from the rolls, termination, end of term, finished
                        contract or phased out (abolition) in the public or
                        private sector?
                        <br />
                        <md-radio
                            v-model="separated.ans"
                            :value="conditionTrue"
                            :disabled="isUpdateEmployee === 'false'"
                        >
                            Yes
                        </md-radio>
                        <md-radio
                            v-model="separated.ans"
                            :value="conditionFalse"
                            :disabled="isUpdateEmployee === 'false'"
                        >
                            No
                        </md-radio>
                        <br />
                        <md-field>
                            <md-input
                                v-model="separated.details"
                                type="text"
                                placeholder="If Yes, give details"
                                :disabled="isUpdateEmployee === 'false'"
                            ></md-input>
                        </md-field>
                    </div>

                    <div class="md-layout-item md-small-size-100 md-size-50">
                        Have you ever been a candidate in a national or local
                        election held within the last year (except Barangay
                        election)?
                        <br />
                        <md-radio
                            v-model="candidate.ans"
                            :value="conditionTrue"
                            :disabled="isUpdateEmployee === 'false'"
                        >
                            Yes
                        </md-radio>
                        <md-radio
                            v-model="candidate.ans"
                            :value="conditionFalse"
                            :disabled="isUpdateEmployee === 'false'"
                        >
                            No
                        </md-radio>
                        <br />
                        <md-field>
                            <md-input
                                v-model="candidate.details"
                                type="text"
                                placeholder="If Yes, give details"
                                :disabled="isUpdateEmployee === 'false'"
                            ></md-input>
                        </md-field>
                    </div>

                    <div
                        class="md-layout-item md-small-size-100 md-size-100"
                        style="margin-bottom: 30px; font-weight: 500"
                    >
                        Pursuant to (a) Indigenous People's Act (RA 8371); (b)
                        Magna Carta for Disabled Persons (RA 7277) and (c) Solo
                        Parents Welfare Act of 2000 (RA 8972), please answer the
                        following items:
                    </div>

                    <div class="md-layout-item md-small-size-100 md-size-33">
                        Are you a member of any indigenous group?
                        <br />
                        <md-radio
                            v-model="indigenous.ans"
                            :value="conditionTrue"
                            :disabled="isUpdateEmployee === 'false'"
                        >
                            Yes
                        </md-radio>
                        <md-radio
                            v-model="indigenous.ans"
                            :value="conditionFalse"
                            :disabled="isUpdateEmployee === 'false'"
                        >
                            No
                        </md-radio>
                        <br />
                        <md-field>
                            <md-input
                                v-model="indigenous.details"
                                type="text"
                                placeholder="If Yes, give details"
                                :disabled="isUpdateEmployee === 'false'"
                            ></md-input>
                        </md-field>
                    </div>

                    <div class="md-layout-item md-small-size-100 md-size-33">
                        Are you a person with disability?
                        <br />
                        <md-radio
                            v-model="disability.ans"
                            :value="conditionTrue"
                            :disabled="isUpdateEmployee === 'false'"
                        >
                            Yes
                        </md-radio>
                        <md-radio
                            v-model="disability.ans"
                            :value="conditionFalse"
                            :disabled="isUpdateEmployee === 'false'"
                        >
                            No
                        </md-radio>
                        <br />
                        <md-field>
                            <md-input
                                v-model="disability.details"
                                type="text"
                                placeholder="If Yes, give details"
                                :disabled="isUpdateEmployee === 'false'"
                            ></md-input>
                        </md-field>
                    </div>

                    <div class="md-layout-item md-small-size-100 md-size-33">
                        Are you a solo parent?
                        <br />
                        <md-radio
                            v-model="soloParent.ans"
                            :value="conditionTrue"
                            :disabled="isUpdateEmployee === 'false'"
                        >
                            Yes
                        </md-radio>
                        <md-radio
                            v-model="soloParent.ans"
                            :value="conditionFalse"
                            :disabled="isUpdateEmployee === 'false'"
                        >
                            No
                        </md-radio>
                        <br />
                        <md-field>
                            <md-input
                                v-model="soloParent.details"
                                type="text"
                                placeholder="If Yes, give details"
                                :disabled="isUpdateEmployee === 'false'"
                            ></md-input>
                        </md-field>
                    </div>

                    <div class="md-layout-item md-small-size-100 md-size-33">
                        <md-field>
                            <label>Government ID Type</label>
                            <md-input
                                v-model="govIDType"
                                type="text"
                                :disabled="isUpdateEmployee === 'false'"
                            ></md-input>
                        </md-field>
                    </div>

                    <div class="md-layout-item md-small-size-100 md-size-33">
                        <md-field>
                            <label>Government ID Number</label>
                            <md-input
                                v-model="govIDNumber"
                                type="text"
                                :disabled="isUpdateEmployee === 'false'"
                            ></md-input>
                        </md-field>
                    </div>

                    <div class="md-layout-item md-small-size-100 md-size-33">
                        <md-datepicker
                            :md-model-type="String"
                            v-model="govIDIssuedDate"
                            label="Issued Date"
                            :disabled="isUpdateEmployee === 'false'"
                            ><label>Issued Date</label></md-datepicker
                        >
                    </div>

                    <div class="md-layout-item md-small-size-100 md-size-33">
                        <md-field>
                            <label>Place Issued</label>
                            <md-input
                                v-model="govPlaceIssued"
                                type="text"
                                :disabled="isUpdateEmployee === 'false'"
                            ></md-input>
                        </md-field>
                    </div>
                </div>
            </md-card-content>
        </md-card>

        <!-- Reference -->
        <md-card>
            <!-- <md-card-header class="md-card-header"> -->

            <!-- </md-card-header> -->
            <md-card-content>
                <h3 class="title">References</h3>
                <div class="md-layout">
                    <div class="md-layout-item md-small-size-100 md-size-100">
                        <md-button
                            @click="addReference"
                            class="md-dense"
                            :disabled="isUpdateEmployee === 'false'"
                        >
                            <!-- <md-icon>plus_one</md-icon> -->
                            Add Reference</md-button
                        >
                    </div>

                    <md-table
                        v-model="references"
                        md-sort="name"
                        md-sort-order="asc"
                        md-card
                        md-fixed-header
                    >
                        <md-table-toolbar>
                            <h1 class="md-title">References</h1>
                        </md-table-toolbar>
                        <md-table-row slot="md-table-row" slot-scope="{ item }">
                            <md-table-cell md-label="Name" md-sort-by="name">{{
                                item.name
                            }}</md-table-cell>
                            <md-table-cell
                                md-label="Address"
                                md-sort-by="address"
                                >{{ item.address }}</md-table-cell
                            >
                            <md-table-cell
                                md-label="Telephone Number"
                                md-sort-by="telephone"
                                >{{ item.telephone }}</md-table-cell
                            >
                            <md-table-cell md-label="Actions">
                                <md-button
                                    class="md-dense md-primary md-raised"
                                    :disabled="isUpdateEmployee === 'false'"
                                    @click="editReference(item.id)"
                                    >✎</md-button
                                >
                                <md-button
                                    class="md-dense md-danger md-raised"
                                    :disabled="isUpdateEmployee === 'false'"
                                    @click="deleteReference(item.id)"
                                    >⌫</md-button
                                >
                            </md-table-cell>
                        </md-table-row>
                    </md-table>

                    <DialogCard v-if="isAddReference">
                        <section slot="header">Add Reference</section>
                        <section slot="body">
                            <form
                                method="post"
                                @submit.prevent="validateAddReference"
                            >
                                <md-field>
                                    <label>Name</label>
                                    <md-input
                                        v-model="reference.name"
                                        type="text"
                                        required
                                        :disabled="isUpdateEmployee === 'false'"
                                    ></md-input>
                                </md-field>
                                <md-field>
                                    <label>Telephone</label>
                                    <md-input
                                        v-model="reference.telephone"
                                        type="number"
                                        required
                                        :disabled="isUpdateEmployee === 'false'"
                                    ></md-input>
                                </md-field>
                                <md-field>
                                    <label>Address</label>
                                    <md-input
                                        v-model="reference.address"
                                        type="text"
                                        required
                                        :disabled="isUpdateEmployee === 'false'"
                                    ></md-input>
                                </md-field>
                                <md-dialog-actions>
                                    <md-button
                                        v-if="!isUpdateReference"
                                        class="md-primary md-dense"
                                        type="submit"
                                        :disabled="isUpdateEmployee === 'false'"
                                    >
                                        Add Reference
                                    </md-button>
                                    <md-button
                                        v-else
                                        class="md-primary md-dense"
                                        :disabled="isUpdateEmployee === 'false'"
                                        @click="updateReference"
                                    >
                                        Update Reference
                                    </md-button>
                                    <md-button
                                        class="md-dense"
                                        @click="addReference"
                                        :disabled="isUpdateEmployee === 'false'"
                                    >
                                        <!-- <md-icon>close</md-icon> -->
                                        ✕ Close</md-button
                                    >
                                </md-dialog-actions>
                            </form>
                        </section>
                    </DialogCard>
                </div>
            </md-card-content>
        </md-card>
        <!-- End Refernce -->

        <!-- Reference -->
        <md-card>
            <!-- <md-card-header class="md-card-header">
                <h4 class="title">Skills, Recognitions and Memberships</h4>
            </md-card-header> -->
            <md-card-content>
                <!-- <h3 class="title">Skills, Recognitions and Memberships</h3> -->
                <div class="md-layout">
                    <div
                        class="md-layout-item md-small-size-100 md-size-100"
                        style="margin-top: 20px !important"
                    >
                        <h3>Skills</h3>
                        <md-chips class="md-primary" v-model="skills">
                        </md-chips>
                        <!-- <ul>
                            <li v-for="s in skills" :key="s.skill">
                                {{ s }}
                            </li>
                        </ul> -->
                        <md-autocomplete
                            v-model="skill"
                            :md-options="paramSkills"
                            :disabled="isUpdateEmployee === 'false'"
                        >
                            <label>Type Skills Here</label>
                        </md-autocomplete>
                        <md-button
                            class="md-dense"
                            @click="addSkill"
                            :disabled="isUpdateEmployee === 'false'"
                        >
                            Add Skill
                        </md-button>
                        <!-- <md-button
                            class="md-dense md-danger"
                            @click="clearSkill"
                            :disabled="isUpdateEmployee === 'false'"
                        >
                            Clear
                        </md-button> -->
                    </div>

                    <div class="md-layout-item md-small-size-100 md-size-100">
                        <h3>Recognition</h3>
                        <md-chips class="md-primary" v-model="recognitions">
                        </md-chips>
                        <!-- <ul>
                            <li v-for="r in recognitions" :key="r">
                                {{ r }}
                            </li>
                        </ul> -->
                        <md-autocomplete
                            v-model="recognition"
                            :md-options="paramRecognitions"
                            :disabled="isUpdateEmployee === 'false'"
                        >
                            <label>Type Recognitions Here</label>
                        </md-autocomplete>
                        <md-button
                            class="md-dense"
                            @click="addRecognition"
                            :disabled="isUpdateEmployee === 'false'"
                        >
                            Add Recognition
                        </md-button>
                        <!-- <md-button
                            class="md-dense md-danger"
                            @click="clearRecognition"
                            :disabled="isUpdateEmployee === 'false'"
                        >
                            Clear
                        </md-button> -->
                    </div>

                    <div class="md-layout-item md-small-size-100 md-size-100">
                        <h3>Memberships</h3>
                        <md-chips class="md-primary" v-model="memberships">
                        </md-chips>
                        <!-- <ul>
                            <li v-for="m in memberships" :key="m">
                                {{ m }}
                            </li>
                        </ul> -->
                        <md-autocomplete
                            v-model="member"
                            :md-options="paramMemberships"
                            :disabled="isUpdateEmployee === 'false'"
                        >
                            <label>Type Membership Here</label>
                        </md-autocomplete>
                        <md-button
                            class="md-dense"
                            @click="addMembership"
                            :disabled="isUpdateEmployee === 'false'"
                        >
                            Add Membership</md-button
                        >
                        <!-- <md-button
                            class="md-dense md-danger"
                            @click="clearMembership"
                            :disabled="isUpdateEmployee === 'false'"
                        >
                            Clear
                        </md-button> -->
                    </div>

                    <div
                        class="md-layout-item md-size-100 text-right"
                        style="margin-top: 50px"
                    >
                        <span v-if="isUpdateEmployee === 'false'"
                            >Updating of record is disabled.</span
                        >
                        <md-button
                            v-else
                            class="md-raised md-success md-dense"
                            @click="updateOthersEmployeeRecord"
                            :disabled="
                                isUpdateEmployee === 'false' || isUpdating
                            "
                        >
                            <!-- <md-icon>save</md-icon> -->
                            {{ btnMessage }}</md-button
                        >
                    </div>
                </div>
            </md-card-content>
        </md-card>
        <!-- End Refernce -->
    </form>
</template>
<script>
// import DialogCard from "../../components/Cards/DialogCard.vue";
const DialogCard = () =>
    import(
        /* webpackChunkName: "DialogCard" */ "../../components/Cards/DialogCard.vue"
    );
import userAction from "../../mixins/userAction.js";
import axios from "axios";
export default {
    components: {
        DialogCard,
    },
    mixins: [userAction],
    name: "PersonalInformation",
    props: {
        dataBackgroundColor: {
            type: String,
            default: "",
        },
    },
    data() {
        return {
            isAddReference: false,
            govIDType: null,
            govIDNumber: null,
            govIDIssuedDate: null,
            govPlaceIssued: null,
            relation: {
                ans: false,
                details: null,
            },
            resignation: {
                ans: false,
                details: null,
            },
            relationLGU: {
                ans: false,
                details: null,
            },
            immigrantStatus: {
                ans: false,
                details: null,
            },
            guilty: {
                ans: false,
                details: null,
            },
            indigenous: {
                ans: false,
                details: null,
            },
            disability: {
                ans: false,
                details: null,
            },
            soloParent: {
                ans: false,
                details: null,
            },
            charge: {
                ans: false,
                details: null,
                status: null,
                date: null,
            },
            convicted: {
                ans: false,
                details: null,
            },
            separated: {
                ans: true,
                details: null,
            },
            candidate: {
                ans: false,
                details: null,
            },
            reference: {
                name: null,
                address: null,
                telephone: null,
            },
            references: [],
            skill: null,
            skills: [],
            recognition: null,
            recognitions: [],
            member: null,
            memberships: [],

            //References
            isUpdateReference: false,
            updateReferenceId: null,
            conditionTrue: true,
            conditionFalse: false,

            //Required for updating
            email: null,
            employee_number: null,
            last_name: null,
            first_name: null,
            birth_date: null,
            gender: null,
            civil_status: null,

            //Property for updating
            saved: false,
            isUpdating: false,
            notificationMessage: null,
            btnMessage: "Update Other Information",

            isUpdateEmployee: false,

            //For Auto Complete
            paramMemberships: [],
            paramSkills: [],
            paramRecognitions: [],
        };
    },
    methods: {
        addReference() {
            this.reference.name = null;
            this.reference.address = null;
            this.reference.telephone = null;
            this.isUpdateReference = false;
            this.isAddReference = !this.isAddReference;
        },

        //Get Others information
        async getEmployeeRecord() {
            const getToken = localStorage.getItem("token");
            this.baseUrl = localStorage.getItem("base_url");
            this.baseUrl = this.baseUrl + "/api/employee/portal/search/";

            const options = {
                method: "GET",
                url: this.baseUrl,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + getToken,
                },
            };

            let resp;
            await axios
                .request(options)
                .then((response) => {
                    console.log(response.data);
                    resp = response;
                })
                .catch((error) => {
                    console.error(error);
                    resp = error.response;
                });

            if (resp.status === 200) {
                this.govIDType = resp.data.government_id_type;
                this.govIDNumber = resp.data.government_id_number;
                this.govIDIssuedDate = resp.data.issued_date;
                this.govPlaceIssued = resp.data.issued_place;
                this.relation.ans = resp.data.is_affiliated_third;
                this.relation.details = resp.data.affiliated_third;
                this.relationLGU.ans = resp.data.is_affiliated_fourth;
                this.relationLGU.details = resp.data.affiliated_fourth;
                this.immigrantStatus.ans = resp.data.is_immigrant;
                this.immigrantStatus.details = resp.data.immigrant;
                this.guilty.ans = resp.data.is_found_guilty;
                this.guilty.details = resp.data.ound_guilty;
                this.indigenous.ans = resp.data.is_indigenous;
                this.indigenous.details = resp.data.indigenous;
                this.disability.ans = resp.data.is_disabled;
                this.disability.details = resp.data.disabled;
                this.soloParent.ans = resp.data.is_solo;
                this.soloParent.details = resp.data.solo;
                this.charge.ans = resp.data.is_criminally_charged;
                this.charge.details = resp.data.criminally_charged_status;
                this.charge.date = resp.data.criminally_charged_date;
                this.convicted.ans = resp.data.is_convicted;
                this.convicted.details = resp.data.convicted;
                this.separated.ans = resp.data.is_separated_service;
                this.separated.details = resp.data.separated_service;
                this.candidate.ans = resp.data.is_candidate;
                this.candidate.details = resp.data.candidate;
                this.resignation.ans = resp.data.is_resigned;
                this.resignation.details = resp.data.resigned;
                this.skills = resp.data.skills;
                this.memberships = resp.data.memberships;
                this.recognitions = resp.data.recognitions;
                //Required for updating
                this.email = resp.data.email;
                this.employee_number = resp.data.employee_number;
                this.last_name = resp.data.last_name;
                this.first_name = resp.data.first_name;
                this.birth_date = resp.data.birth_date;
                this.gender = resp.data.gender;
                this.civil_status = resp.data.civil_status;
            }

            console.log(resp);
            await this.getPortalParameter();
            // if (this.memberships === null) {
            //     this.memberships = ['MEMBERSHIPS']
            // }
            // if (this.skills === null) {
            //     this.skills = ['SKILLS']
            // }
            // if (this.recognitions === null) {
            //     this.recognitions = ['RECOGNITIONS']
            // }
        },

        //Get Portal Paramaters
        async getPortalParameter() {
            const getToken = localStorage.getItem("token");
            this.baseUrl = localStorage.getItem("base_url");
            this.baseUrl = this.baseUrl + "/api/employee/portal/parameter/";

            const options = {
                method: "GET",
                url: this.baseUrl,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + getToken,
                },
            };

            axios
                .request(options)
                .then((response) => {
                    this.paramMemberships = response.data.memberships;
                    this.paramSkills = response.data.skills;
                    this.paramRecognitions = response.data.recognitions;
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        //Update Employee Record
        async updateOthersEmployeeRecord() {
            this.isUpdating = true;
            this.btnMessage = "Updating...";
            const getToken = localStorage.getItem("token");
            this.baseUrl = localStorage.getItem("base_url");
            this.baseUrl = this.baseUrl + "/api/employee/portal/update/";

            const options = {
                method: "PUT",
                url: this.baseUrl,
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    Authorization: "Bearer " + getToken,
                },
                data: {
                    isResetPassword: true,
                    employee_number: this.employee_number,
                    last_name: this.last_name,
                    first_name: this.first_name,
                    birth_date: this.birth_date,
                    gender: this.gender,
                    civil_status: this.civil_status,
                    email: this.email,
                    is_affiliated_third: this.relation.ans,
                    affiliated_third: this.relation.details,
                    is_affiliated_fourth: this.relationLGU.ans,
                    affiliated_fourth: this.relationLGU.details,
                    is_found_guilty: this.guilty.ans,
                    found_guilty: this.guilty.details,
                    is_criminally_charged: this.charge.ans,
                    criminally_charged_date: this.charge.date,
                    criminally_charged_status: this.charge.details,
                    is_convicted: this.convicted.ans,
                    convicted: this.convicted.details,
                    is_separated_service: this.separated.ans,
                    separated_service: this.separated.details,
                    is_candidate: this.candidate.ans,
                    candidate: this.candidate.details,
                    is_resigned: this.resignation.ans,
                    resigned: this.resignation.details,
                    is_immigrant: this.immigrantStatus.ans,
                    immigrant: this.immigrantStatus.details,
                    is_indigenous: this.indigenous.ans,
                    indigenous: this.indigenous.details,
                    is_disabled: this.disability.ans,
                    disabled: this.disability.details,
                    is_solo: this.soloParent.ans,
                    solo: this.soloParent.details,
                    government_id_type: this.govIDType,
                    government_id_number: this.govIDNumber,
                    issued_date: this.govIDIssuedDate,
                    issued_place: this.govPlaceIssued,
                    // memberships: ['member 1'],
                    // skills: ['skill 1'],
                    // recognitions: ['recognition 1']
                },
            };

            await axios
                .request(options)
                .then((response) => {
                    console.log(response.data);
                    this.getEmployeeRecord();
                })
                .catch((error) => {
                    console.error(error.response);
                });

            this.isUpdating = false;
            this.btnMessage = "Update Other Information";
            await this.addSkill();
            await this.addMembership();
            await this.addRecognition();
            this.saved = true;
            this.notificationMessage = "Updating Other Information Done";
        },

        // Get References
        async getReferences() {
            const getToken = localStorage.getItem("token");
            this.baseUrl = localStorage.getItem("base_url");
            this.baseUrl =
                this.baseUrl + "/api/employee/reference/portal/search/";

            const options = {
                method: "GET",
                url: this.baseUrl,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + getToken,
                },
            };

            let resp;
            await axios
                .request(options)
                .then((response) => {
                    console.log(response.data);
                    resp = response;
                })
                .catch((error) => {
                    console.error(error);
                    resp = error.response;
                });

            if (resp.status === 200) {
                this.references = resp.data.data;
            }
        },

        //Edit Reference
        async editReference(id) {
            this.updateReferenceId = id;
            const getToken = localStorage.getItem("token");
            this.baseUrl = localStorage.getItem("base_url");
            this.baseUrl =
                this.baseUrl + "/api/employee/reference/portal/search/" + id;

            const options = {
                method: "GET",
                url: this.baseUrl,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + getToken,
                },
            };

            let resp;
            await axios
                .request(options)
                .then((response) => {
                    console.log(response.data);
                    resp = response;
                })
                .catch((error) => {
                    console.error(error);
                    resp = error.response;
                });

            if (resp.status === 200) {
                this.addReference();
                this.isUpdateReference = true;
                this.reference.name = resp.data.name;
                this.reference.address = resp.data.address;
                this.reference.telephone = resp.data.telephone;
            }
        },

        //Delete Reference
        async deleteReference(id) {
            const getToken = localStorage.getItem("token");
            this.baseUrl = localStorage.getItem("base_url");
            this.baseUrl =
                this.baseUrl + "/api/employee/reference/portal/delete/" + id;

            const options = {
                method: "DELETE",
                url: this.baseUrl,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + getToken,
                },
            };

            await axios
                .request(options)
                .then((response) => {
                    console.log(response.data);
                })
                .catch((error) => {
                    console.error(error);
                });

            await this.getReferences();
        },

        //Update Reference
        async updateReference() {
            const getToken = localStorage.getItem("token");
            this.baseUrl = localStorage.getItem("base_url");
            this.baseUrl =
                this.baseUrl +
                "/api/employee/reference/portal/update/" +
                this.updateReferenceId;

            const options = {
                method: "PUT",
                url: this.baseUrl,
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    Authorization: "Bearer " + getToken,
                },
                data: {
                    name: this.reference.name,
                    address: this.reference.address,
                    telephone: this.reference.telephone,
                },
            };

            await axios
                .request(options)
                .then((response) => {
                    console.log(response.data);
                    this.getReferences();
                })
                .catch((error) => {
                    console.error(error.response);
                });

            this.addReference();
        },

        //Add Reference
        async validateAddReference() {
            const getToken = localStorage.getItem("token");
            this.baseUrl = localStorage.getItem("base_url");
            this.baseUrl =
                this.baseUrl + "/api/employee/reference/portal/create/";

            const options = {
                method: "POST",
                url: this.baseUrl,
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    Authorization: "Bearer " + getToken,
                },
                data: {
                    name: this.reference.name,
                    address: this.reference.address,
                    telephone: this.reference.telephone,
                },
            };

            axios
                .request(options)
                .then(function (response) {
                    console.log(response.data);
                })
                .catch(function (error) {
                    console.error(error);
                });
            this.addReference();
            await this.getReferences();
        },

        //Add Skill
        async addSkill() {
            if (this.skills === null) {
                this.skills = [this.skill];
            } else {
                if (this.skill === null) {
                    // Do nothing
                } else {
                    this.skills.push(this.skill);
                }
            }

            const getToken = localStorage.getItem("token");
            this.baseUrl = localStorage.getItem("base_url");
            this.baseUrl = this.baseUrl + "/api/employee/portal/update/";

            const options = {
                method: "PUT",
                url: this.baseUrl,
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    Authorization: "Bearer " + getToken,
                },
                data: {
                    isResetPassword: true,
                    employee_number: this.employee_number,
                    last_name: this.last_name,
                    first_name: this.first_name,
                    birth_date: this.birth_date,
                    gender: this.gender,
                    civil_status: this.civil_status,
                    email: this.email,
                    skills: this.skills.map(String),
                },
            };

            await axios
                .request(options)
                .then((response) => {
                    console.log(response.data);
                })
                .catch((error) => {
                    console.error(error.response);
                });

            await this.getEmployeeRecord();

            this.skill = null;
        },

        //Clear Skill
        async clearSkill() {
            const getToken = localStorage.getItem("token");
            this.baseUrl = localStorage.getItem("base_url");
            this.baseUrl = this.baseUrl + "/api/employee/portal/update/";

            const options = {
                method: "PUT",
                url: this.baseUrl,
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    Authorization: "Bearer " + getToken,
                },
                data: {
                    isResetPassword: true,
                    employee_number: this.employee_number,
                    last_name: this.last_name,
                    first_name: this.first_name,
                    birth_date: this.birth_date,
                    gender: this.gender,
                    civil_status: this.civil_status,
                    email: this.email,
                    skills: null,
                },
            };

            await axios
                .request(options)
                .then((response) => {
                    console.log(response.data);
                })
                .catch((error) => {
                    console.error(error.response);
                });

            await this.getEmployeeRecord();
            this.skill = null;
        },

        //Add Memberships
        async addMembership() {
            if (this.memberships === null) {
                this.memberships = [this.member];
            } else {
                if (this.member === null) {
                    // Do nothing
                } else {
                    this.memberships.push(this.member);
                }
            }

            const getToken = localStorage.getItem("token");
            this.baseUrl = localStorage.getItem("base_url");
            this.baseUrl = this.baseUrl + "/api/employee/portal/update/";

            const options = {
                method: "PUT",
                url: this.baseUrl,
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    Authorization: "Bearer " + getToken,
                },

                data: {
                    isResetPassword: true,
                    employee_number: this.employee_number,
                    last_name: this.last_name,
                    first_name: this.first_name,
                    birth_date: this.birth_date,
                    gender: this.gender,
                    civil_status: this.civil_status,
                    email: this.email,
                    memberships: this.memberships.map(String),
                },
            };

            await axios
                .request(options)
                .then((response) => {
                    console.log(response.data);
                })
                .catch((error) => {
                    console.error(error.response);
                });
            await this.getEmployeeRecord();
            this.member = null;
        },

        //Clear Membership
        async clearMembership() {
            const getToken = localStorage.getItem("token");
            this.baseUrl = localStorage.getItem("base_url");
            this.baseUrl = this.baseUrl + "/api/employee/portal/update/";

            const options = {
                method: "PUT",
                url: this.baseUrl,
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    Authorization: "Bearer " + getToken,
                },
                data: {
                    isResetPassword: true,
                    employee_number: this.employee_number,
                    last_name: this.last_name,
                    first_name: this.first_name,
                    birth_date: this.birth_date,
                    gender: this.gender,
                    civil_status: this.civil_status,
                    email: this.email,
                    memberships: null,
                },
            };

            await axios
                .request(options)
                .then((response) => {
                    console.log(response.data);
                })
                .catch((error) => {
                    console.error(error.response);
                });

            await this.getEmployeeRecord();
            this.member = null;
        },

        //Add Recognition
        async addRecognition() {
            if (this.recognitions === null) {
                this.recognitions = [this.recognition];
            } else {
                if (this.recognition === null) {
                    // do nothing
                } else {
                    this.recognitions.push(this.recognition);
                }
            }

            const getToken = localStorage.getItem("token");
            this.baseUrl = localStorage.getItem("base_url");
            this.baseUrl = this.baseUrl + "/api/employee/portal/update/";

            const options = {
                method: "PUT",
                url: this.baseUrl,
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    Authorization: "Bearer " + getToken,
                },

                data: {
                    isResetPassword: true,
                    employee_number: this.employee_number,
                    last_name: this.last_name,
                    first_name: this.first_name,
                    birth_date: this.birth_date,
                    gender: this.gender,
                    civil_status: this.civil_status,
                    email: this.email,
                    recognitions: this.recognitions.map(String),
                },
            };

            await axios
                .request(options)
                .then((response) => {
                    console.log(response.data);
                })
                .catch((error) => {
                    console.error(error.response);
                });
            await this.getEmployeeRecord();
            this.recognition = null;
        },

        //Clear Recognition
        async clearRecognition() {
            const getToken = localStorage.getItem("token");
            this.baseUrl = localStorage.getItem("base_url");
            this.baseUrl = this.baseUrl + "/api/employee/portal/update/";

            const options = {
                method: "PUT",
                url: this.baseUrl,
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    Authorization: "Bearer " + getToken,
                },
                data: {
                    isResetPassword: true,
                    employee_number: this.employee_number,
                    last_name: this.last_name,
                    first_name: this.first_name,
                    birth_date: this.birth_date,
                    gender: this.gender,
                    civil_status: this.civil_status,
                    email: this.email,
                    recognitions: null,
                },
            };

            await axios
                .request(options)
                .then((response) => {
                    console.log(response.data);
                })
                .catch((error) => {
                    console.error(error.response);
                });

            await this.getEmployeeRecord();
            this.recognition = null;
        },
    },

    async mounted() {
        await this.getEmployeeRecord();
        await this.getReferences();
        this.isUpdateEmployee = localStorage.getItem("isUpdateEmployee");
    },
};
</script>
<style scoped>
.md-card-header {
    background-color: #042278 !important;
}
.dob {
    margin-top: -20px;
}
md-radio {
    color: black !important;
}
.md-theme-default .md-body-1 {
    color: black !important;
}
.md-radio-label {
    color: black !important;
}
</style>
