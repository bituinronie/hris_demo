<template>
    <div class="content">
        <div class="md-layout">
            <div
                class="md-layout-item md-medium-size-100 md-size-100 md-layout"
            >
                <DialogCard v-if="isSearchPos">
                    <section slot="header">Search Positions</section>
                    <section slot="body">
                        <SearchPositions
                            v-on:close-dialog="searchPositions"
                        ></SearchPositions>
                        <form>
                            <md-dialog-actions>
                                <!-- <md-button class="md-primary md-dense" type="submit">Search Employee</md-button > -->
                                <md-button
                                    class="md-dense md-danger"
                                    @click="searchPositions"
                                    >Close</md-button
                                >
                            </md-dialog-actions>
                        </form>
                    </section>
                </DialogCard>
                <div class="md-layout-item md-small-size-100 md-size-50">
                    {{ userActionMessage }}
                </div>

                <div class="md-layout-item md-small-size-100 md-size-50">
                    <md-button
                        class="md-raised md-dense md-primary emp-search"
                        @click="searchPositions"
                        v-if="$permissions.includes('search position')"
                    >
                        ⚑ Positions
                    </md-button>
                    <md-button
                        class="md-raised md-dense md-primary emp-search"
                        @click="addPosition"
                        v-if="$permissions.includes('write position')"
                    >
                        Add Position
                    </md-button>
                    <md-button
                        v-if="
                            userAction === 'edit' &&
                            $permissions.includes('print position')
                        "
                        class="md-raised md-dense md-warning emp-search"
                        @click="isPrintPosition = !isPrintPosition"
                    >
                        <label style="color: black">Print Position</label>
                    </md-button>
                </div>
            </div>
            <form method="post" @submit.prevent="validateAddPosition">
                <md-dialog-alert
                    class="md-body-1"
                    :md-active.sync="created"
                    :md-content="notificationMessage"
                    md-confirm-text="Okay"
                />
                <md-card>
                    <md-card-header class="md-card-header">
                        <h4 class="title">Complete the position description</h4>
                        <!-- <p class="category">Complete the position description</p> -->
                    </md-card-header>
                    <md-card-content>
                        <div
                            class="
                                md-layout-item
                                md-medium-size-100
                                md-size-100
                                md-layout
                            "
                        >
                            <div
                                class="
                                    md-layout-item md-small-size-100 md-size-50
                                "
                            >
                                <!-- Position Title -->
                                <md-field>
                                    <label>Position Title</label>
                                    <md-input v-model="form.title" required>
                                    </md-input>
                                </md-field>

                                <!-- Item Number -->
                                <md-field>
                                    <label>Item Number</label>
                                    <md-input
                                        v-model="form.item_number"
                                        required
                                    >
                                    </md-input>
                                </md-field>

                                <!-- Salary Grade -->
                                <md-field>
                                    <label>Salary Grade</label>
                                    <md-select
                                        v-model="form.salary_grade_id"
                                        @md-selected="getSalaryGrade"
                                    >
                                        <md-option
                                            v-for="sg in param.salary_grade"
                                            :key="sg.salary_grade_id"
                                            :value="sg.salary_grade_id"
                                            >{{ sg.salary_grade }}</md-option
                                        >
                                    </md-select>
                                </md-field>

                                <!-- Department / Division -->
                                <md-field>
                                    <label>Department / Division</label>
                                    <md-input disabled> </md-input>
                                </md-field>

                                <!-- Division -->
                                <DialogCard v-if="divSearch">
                                    <section slot="header">
                                        Select Division
                                    </section>
                                    <section slot="body">
                                        <ListDivision
                                            v-on:close-dialog="getDivNameAndId"
                                        ></ListDivision>
                                        <form>
                                            <md-dialog-actions>
                                                <md-button
                                                    class="md-dense"
                                                    @click="searchDiv"
                                                    >Close</md-button
                                                >
                                            </md-dialog-actions>
                                        </form>
                                    </section>
                                </DialogCard>
                                <md-field>
                                    <label>Division</label>
                                    <md-input
                                        v-model="form.division_name"
                                        disabled
                                    >
                                    </md-input>
                                    <md-button
                                        class="md-raised md-primary"
                                        @click="searchDiv"
                                        >☰</md-button
                                    >
                                </md-field>

                                <!-- Level -->
                                <md-field>
                                    <label>Level</label>
                                    <md-select v-model="form.level">
                                        <md-option
                                            v-for="l in param.level"
                                            :key="l"
                                            :value="l"
                                            >{{ l }}</md-option
                                        >
                                    </md-select>
                                </md-field>

                                <!-- Employment Status -->
                                <md-field>
                                    <label>Employment Status</label>
                                    <md-select
                                        v-model="form.employment_status_id"
                                    >
                                        <md-option
                                            v-for="l in param.employment_status"
                                            :key="l.id"
                                            :value="l.id"
                                            >{{ l.code }}</md-option
                                        >
                                    </md-select>
                                </md-field>
                            </div>

                            <!-- 2nd Column -->
                            <div
                                class="
                                    md-layout-item md-small-size-100 md-size-50
                                "
                            >
                                <!-- Former Position -->
                                <md-field>
                                    <label>Former Position</label>
                                    <md-input v-model="form.former_position">
                                    </md-input>
                                </md-field>

                                <!-- Place of Work -->
                                <md-field>
                                    <label>Place of Work</label>
                                    <md-input v-model="form.place_of_work">
                                    </md-input>
                                </md-field>

                                <!-- Salary Authorized -->
                                <md-field>
                                    <label>Salary Authorized</label>
                                    <md-input
                                        v-model="form.salary_autorized"
                                        disabled
                                    >
                                    </md-input>
                                </md-field>

                                <!-- Position Title of Immediate Supervisor -->
                                <DialogCard v-if="posSearch">
                                    <section slot="header">
                                        Select Position
                                    </section>
                                    <section slot="body">
                                        <ListPosition
                                            v-on:close-dialog="getPosNameAndId"
                                        ></ListPosition>
                                        <form>
                                            <md-dialog-actions>
                                                <md-button
                                                    class="md-dense md-danger"
                                                    @click="searchPos"
                                                    >✕ Close</md-button
                                                >
                                            </md-dialog-actions>
                                        </form>
                                    </section>
                                </DialogCard>
                                <md-field>
                                    <label
                                        >Position Title of Immediate
                                        Supervisor</label
                                    >
                                    <md-input
                                        v-model="form.supervisor_name"
                                        disabled
                                    >
                                    </md-input>
                                    <md-button
                                        class="md-raised md-primary"
                                        @click="searchPos"
                                        >☰</md-button
                                    >
                                </md-field>

                                <!-- Division -->
                                <md-field>
                                    <label
                                        >Position Title of Next Higher
                                        Supervisor</label
                                    >
                                    <md-input
                                        v-model="form.nextSupervisorName"
                                        disabled
                                    >
                                    </md-input>
                                </md-field>

                                <!-- Classification -->
                                <md-field>
                                    <label>Classification</label>
                                    <md-select v-model="form.classification">
                                        <md-option
                                            v-for="c in param.classification"
                                            :key="c"
                                            :value="c"
                                            >{{ c }}</md-option
                                        >
                                    </md-select>
                                </md-field>

                                <!-- Funding Source -->
                                <md-field>
                                    <label>Funding Source</label>
                                    <md-select v-model="form.funding_source_id">
                                        <md-option
                                            v-for="l in param.funding_source"
                                            :key="l.id"
                                            :value="l.id"
                                            >{{ l.description }}</md-option
                                        >
                                    </md-select>
                                </md-field>
                            </div>
                        </div>
                    </md-card-content>
                </md-card>

                <md-card>
                    <md-card-header class="md-card-header">
                        <h4 class="title">
                            Position Title, and Item of those direcelty
                            Supervised
                        </h4>
                        <!-- <p class="category">Complete the position description</p> -->
                    </md-card-header>
                    <md-card-content>
                        <div
                            class="
                                md-layout-item
                                md-medium-size-100
                                md-size-100
                                md-layout
                            "
                        >
                            <div
                                class="
                                    md-layout-item md-small-size-100 md-size-50
                                "
                            >
                                <!-- Position Title -->
                                <md-field>
                                    <label>Position Title</label>
                                    <md-textarea
                                        v-model="form.supervised_position_title"
                                        required
                                    >
                                    </md-textarea>
                                </md-field>
                            </div>

                            <!-- 2nd Column -->
                            <div
                                class="
                                    md-layout-item md-small-size-100 md-size-50
                                "
                            >
                                <!-- Item Number -->
                                <md-field>
                                    <label>Item Number</label>
                                    <md-textarea
                                        v-model="form.supervised_item_number"
                                        required
                                    >
                                    </md-textarea>
                                </md-field>
                            </div>
                        </div>
                    </md-card-content>
                </md-card>

                <md-card>
                    <md-card-header class="md-card-header">
                        <h4 class="title">
                            Contacts, Clients and Stakeholders
                        </h4>
                        <!-- <p class="category">Complete the position description</p> -->
                    </md-card-header>
                    <md-card-content>
                        <div
                            class="
                                md-layout-item
                                md-medium-size-100
                                md-size-100
                                md-layout
                            "
                        >
                            <div
                                class="
                                    md-layout-item md-small-size-100 md-size-25
                                "
                                style="color: black !important"
                            >
                                <h5>Executive Material</h5>
                                <br /><label>Executive / Managerial</label
                                ><br />
                                <md-radio
                                    v-model="form.contact_internal_executive"
                                    :value="form.occasional"
                                    style="color: black !important"
                                    >Occasional</md-radio
                                >
                                <md-radio
                                    v-model="form.contact_internal_executive"
                                    :value="form.frequent"
                                    style="color: black !important"
                                    >Frequent</md-radio
                                >

                                <br /><label>Non-Supervisors</label><br />
                                <md-radio
                                    v-model="
                                        form.contact_internal_non_supervisor
                                    "
                                    :value="form.occasional"
                                    style="color: black !important"
                                    >Occasional</md-radio
                                >
                                <md-radio
                                    v-model="
                                        form.contact_internal_non_supervisor
                                    "
                                    :value="form.frequent"
                                    style="color: black !important"
                                    >Frequent</md-radio
                                >
                            </div>

                            <div
                                class="
                                    md-layout-item md-small-size-100 md-size-25
                                "
                                style="color: black !important"
                            >
                                <h5>-</h5>
                                <br /><label>Supervisors</label><br />
                                <md-radio
                                    v-model="form.contact_internal_supervisor"
                                    :value="form.occasional"
                                    style="color: black !important"
                                    >Occasional</md-radio
                                >
                                <md-radio
                                    v-model="form.contact_internal_supervisor"
                                    :value="form.frequent"
                                    style="color: black !important"
                                    >Frequent</md-radio
                                >

                                <br /><label>Staff</label><br />
                                <md-radio
                                    v-model="form.contact_internal_staff"
                                    :value="form.occasional"
                                    style="color: black !important"
                                    >Occasional</md-radio
                                >
                                <md-radio
                                    v-model="form.contact_internal_staff"
                                    :value="form.frequent"
                                    style="color: black !important"
                                    >Frequent</md-radio
                                >
                            </div>

                            <div
                                class="
                                    md-layout-item md-small-size-100 md-size-25
                                "
                                style="color: black !important"
                            >
                                <h5>External</h5>
                                <br /><label>General Public</label><br />
                                <md-radio
                                    v-model="form.contact_external_public"
                                    :value="form.occasional"
                                    style="color: black !important"
                                    >Occasional</md-radio
                                >
                                <md-radio
                                    v-model="form.contact_external_public"
                                    :value="form.frequent"
                                    style="color: black !important"
                                    >Frequent</md-radio
                                >

                                <br /><label>Other Agencies</label><br />
                                <md-radio
                                    v-model="form.contact_external_agencies"
                                    :value="form.occasional"
                                    style="color: black !important"
                                    >Occasional</md-radio
                                >
                                <md-radio
                                    v-model="form.contact_external_agencies"
                                    :value="form.frequent"
                                    style="color: black !important"
                                    >Frequent</md-radio
                                >
                            </div>

                            <div
                                class="
                                    md-layout-item md-small-size-100 md-size-25
                                "
                                style="color: black !important"
                            >
                                <h5>-</h5>
                                <md-field>
                                    <label>Others</label>
                                    <md-input
                                        v-model="form.contact_external_others"
                                    >
                                    </md-input>
                                </md-field>
                            </div>
                        </div>
                    </md-card-content>
                </md-card>

                <md-card>
                    <md-card-content>
                        <div
                            class="
                                md-layout-item
                                md-medium-size-100
                                md-size-100
                                md-layout
                            "
                        >
                            <div
                                class="
                                    md-layout-item md-small-size-100 md-size-25
                                "
                                style="color: black !important"
                            >
                                <h5>Working Conditions</h5>
                                <label>Office Work</label><br />
                                <md-radio
                                    v-model="form.office_work"
                                    :value="form.occasional"
                                    style="color: black !important"
                                    >Occasional</md-radio
                                >
                                <md-radio
                                    v-model="form.ofice_work"
                                    :value="form.frequent"
                                    style="color: black !important"
                                    >Frequent</md-radio
                                >

                                <br /><label>Field Work</label><br />
                                <md-radio
                                    v-model="form.field_work"
                                    :value="form.occasional"
                                    style="color: black !important"
                                    >Occasional</md-radio
                                >
                                <md-radio
                                    v-model="form.field_work"
                                    :value="form.frequent"
                                    style="color: black !important"
                                    >Frequent</md-radio
                                >
                                <br />
                                <md-field>
                                    <label>Others</label>
                                    <md-input v-model="form.other_work">
                                    </md-input>
                                </md-field>
                            </div>

                            <!-- 2nd Column -->
                            <div
                                class="
                                    md-layout-item md-small-size-100 md-size-75
                                "
                            >
                                <!-- Item Number -->
                                <md-field>
                                    <label
                                        >Brief Description of the General
                                        Function of the Unit or Section</label
                                    >
                                    <md-textarea
                                        v-model="form.general_function"
                                        required
                                    >
                                    </md-textarea>
                                </md-field>
                                <md-field>
                                    <label
                                        >Brief Description of the General
                                        Function of the Position</label
                                    >
                                    <md-textarea
                                        v-model="form.job_summary"
                                        required
                                    >
                                    </md-textarea>
                                </md-field>
                            </div>
                        </div>
                    </md-card-content>
                </md-card>

                <md-card>
                    <md-card-header class="md-card-header">
                        <h4 class="title">Qualification Standards</h4>
                    </md-card-header>
                    <md-card-content>
                        <div
                            class="
                                md-layout-item
                                md-medium-size-100
                                md-size-100
                                md-layout
                            "
                        >
                            <div
                                class="
                                    md-layout-item md-small-size-100 md-size-25
                                "
                            >
                                <!-- Education -->
                                <md-field>
                                    <label>Education</label>
                                    <md-textarea
                                        v-model="form.education"
                                        required
                                    >
                                    </md-textarea>
                                </md-field>
                            </div>

                            <!-- 2nd Column -->
                            <div
                                class="
                                    md-layout-item md-small-size-100 md-size-25
                                "
                            >
                                <!-- Experience -->
                                <md-field>
                                    <label>Experience</label>
                                    <md-textarea
                                        v-model="form.experience"
                                        required
                                    >
                                    </md-textarea>
                                </md-field>
                            </div>

                            <!-- 3rd Column -->
                            <div
                                class="
                                    md-layout-item md-small-size-100 md-size-25
                                "
                            >
                                <!-- Training -->
                                <md-field>
                                    <label>Training</label>
                                    <md-textarea
                                        v-model="form.training"
                                        required
                                    >
                                    </md-textarea>
                                </md-field>
                            </div>

                            <!-- 4th Column -->
                            <div
                                class="
                                    md-layout-item md-small-size-100 md-size-25
                                "
                            >
                                <!-- Training -->
                                <md-field>
                                    <label>Eligibility</label>
                                    <md-textarea
                                        v-model="form.eligibility"
                                        required
                                    >
                                    </md-textarea>
                                </md-field>
                            </div>
                        </div>

                        <div
                            class="
                                md-layout-item
                                md-medium-size-100
                                md-size-100
                                md-layout
                            "
                        >
                            <div
                                class="
                                    md-layout-item md-small-size-100 md-size-75
                                "
                            >
                                <!-- Core Competencies -->
                                <md-field>
                                    <label>Core Competencies</label>
                                    <md-textarea
                                        v-model="form.core_competencies"
                                        required
                                    >
                                    </md-textarea>
                                </md-field>
                            </div>

                            <!-- 2nd Column -->
                            <div
                                class="
                                    md-layout-item md-small-size-100 md-size-25
                                "
                            >
                                <!-- Experience -->
                                <md-field>
                                    <label>Competency Level</label>
                                    <md-textarea
                                        v-model="form.core_compentency_level"
                                        required
                                    >
                                    </md-textarea>
                                </md-field>
                            </div>
                        </div>

                        <div
                            class="
                                md-layout-item
                                md-medium-size-100
                                md-size-100
                                md-layout
                            "
                        >
                            <div
                                class="
                                    md-layout-item md-small-size-100 md-size-75
                                "
                            >
                                <!-- Leadership Competencies -->
                                <md-field>
                                    <label>Leadership Competencies</label>
                                    <md-textarea
                                        v-model="form.leadership_compentencies"
                                        required
                                    >
                                    </md-textarea>
                                </md-field>
                            </div>

                            <!-- 2nd Column -->
                            <div
                                class="
                                    md-layout-item md-small-size-100 md-size-25
                                "
                            >
                                <!-- Competency Level -->
                                <md-field>
                                    <label>Competency Level</label>
                                    <md-textarea
                                        v-model="
                                            form.leadership_compentency_level
                                        "
                                        required
                                    >
                                    </md-textarea>
                                </md-field>
                            </div>
                        </div>
                    </md-card-content>
                </md-card>

                <md-card>
                    <md-card-header class="md-card-header">
                        <h4 class="title">
                            Statement of Duties and Responsibilities (Technical
                            Competencies)
                        </h4>
                    </md-card-header>
                    <md-card-content>
                        <div
                            class="
                                md-layout-item
                                md-medium-size-100
                                md-size-100
                                md-layout
                            "
                        >
                            <div
                                class="
                                    md-layout-item md-small-size-100 md-size-25
                                "
                            >
                                <!-- Education -->
                                <md-field>
                                    <label>Percentage of Working Time</label>
                                    <md-textarea
                                        v-model="form.percentage_working_time"
                                        required
                                    >
                                    </md-textarea>
                                </md-field>
                            </div>

                            <!-- 2nd Column -->
                            <div
                                class="
                                    md-layout-item md-small-size-100 md-size-50
                                "
                            >
                                <!-- Experience -->
                                <md-field>
                                    <label
                                        >State the duties and responsibilities
                                        here</label
                                    >
                                    <md-textarea
                                        v-model="form.duties_responsibilities"
                                        required
                                    >
                                    </md-textarea>
                                </md-field>
                            </div>

                            <!-- 3rd Column -->
                            <div
                                class="
                                    md-layout-item md-small-size-100 md-size-25
                                "
                            >
                                <!-- Training -->
                                <md-field>
                                    <label>Competency Level</label>
                                    <md-textarea
                                        v-model="form.duties_competency_level"
                                        required
                                    >
                                    </md-textarea>
                                </md-field>
                            </div>
                        </div>
                    </md-card-content>
                </md-card>

                <md-card>
                    <md-card-header class="md-card-header">
                        <h4 class="title">Equipments</h4>
                    </md-card-header>
                    <md-card-content>
                        <div
                            class="
                                md-layout-item
                                md-medium-size-100
                                md-size-100
                                md-layout
                            "
                        >
                            <div
                                class="
                                    md-layout-item md-small-size-100 md-size-100
                                "
                            >
                                <!-- Education -->
                                <md-field>
                                    <label>Add Equipments</label>
                                    <!-- disabled, post request only accept array -->
                                    <md-textarea
                                        v-model="form.equipments"
                                        disabled
                                    >
                                    </md-textarea>
                                </md-field>
                            </div>
                        </div>
                    </md-card-content>
                </md-card>
                <md-button
                    v-if="
                        !isPositionUpdate &&
                        $permissions.includes('write position')
                    "
                    class="md-primary md-dense"
                    type="submit"
                    :disabled="isSaving"
                    >{{ btnMessage }}</md-button
                >
                <md-button
                    v-else
                    class="md-primary md-dense"
                    @click="updatePosition"
                    :disabled="isSaving"
                    >{{ btnMessage }}</md-button
                >
            </form>
        </div>
        <DialogCard v-if="isPrintPosition">
            <section slot="header">Signature Field</section>
            <section slot="body">
                <md-field>
                    <label>Employee Name</label>
                    <md-input v-model="signatureFieldEmployeeName"> </md-input>
                </md-field>
                <md-field>
                    <label>Supervisor Name</label>
                    <md-input v-model="signatureFieldSupervisorName">
                    </md-input>
                </md-field>
                <md-dialog-actions>
                    <md-button
                        class="md-primary md-dense"
                        @click="genereatePrintPosition"
                        >Generate Doocument</md-button
                    >
                    <md-button
                        class="md-dense"
                        @click="isPrintPosition = !isPrintPosition"
                        >Close</md-button
                    >
                </md-dialog-actions>
            </section>
        </DialogCard>
    </div>
</template>

<script>
const ListDivision = () =>
    import(
        /* webpackChunkName: "ListDivision" */ "../pages/Positions/ListDivision.vue"
    );
const ListPosition = () =>
    import(
        /* webpackChunkName: "ListPosition" */ "../pages/Positions/ListPosition.vue"
    );
const SearchPositions = () =>
    import(
        /* webpackChunkName: "SearchPositions" */ "../pages/Positions/SearchPositions.vue"
    );
const DialogCard = () =>
    import(
        /* webpackChunkName: "DialogCard" */ "../components/Cards/DialogCard.vue"
    );
// import ListDivision from "../pages/Positions/ListDivision.vue";
// import ListPosition from "../pages/Positions/ListPosition.vue";
// import SearchPositions from "../pages/Positions/SearchPositions.vue";
// import DialogCard from "../components/Cards/DialogCard.vue";
import axios from "axios";
export default {
    name: "Positions",
    components: {
        // DialogCard,
        DialogCard,
        ListDivision,
        ListPosition,
        SearchPositions,
    },
    data() {
        return {
            form: {
                // Position description
                title: null,
                item_number: null,
                salary_grade_id: null,
                salary_autorized: null,
                division_name: null,
                division_id: null,
                level: null,
                employment_status_id: null,
                former_position: null,
                place_of_work: null,
                supervisor_name: null,
                supervisor_id: null,
                classification: null,
                funding_source_id: null,
                // Position title and item number of those directly supervised
                supervised_position_title: null,
                supervised_item_number: null,

                // Contacts, clients and stakeholders
                contact_internal_executive: null,
                contact_internal_non_supervisor: null,
                contact_internal_supervisor: null,
                contact_internal_staff: null,
                contact_external_public: null,
                contact_external_agencies: null,
                contact_external_others: null,

                // Working conditions
                office_work: null,
                field_work: null,
                other_work: null,
                general_function: null,
                job_summary: null,

                // Qualification standards
                education: null,
                experience: null,
                training: null,
                eligibility: null,
                core_competencies: null,
                core_compentency_level: null,
                leadership_compentencies: null,
                leadership_compentency_level: null,

                // Statement of competency and responsibilities
                percentage_working_time: null,
                duties_responsibilities: null,
                duties_competency_level: null,
                equipments: null,

                // Radio button
                occasional: "OCCASIONAL",
                frequent: "FREQUENT",

                positionName: null,
            },

            //Get Position
            position: {},

            // Dialog message
            created: false,
            notificationMessage: null,

            // Params
            param: [],

            // Division search
            divSearch: false,

            // Position search
            posSearch: false,
            isSearchPos: false,

            //Position User Action
            userAction: "",
            isPositionUpdate: false,
            positionId: null,
            userActionMessage: "You are currently adding a new position",
            isSaving: false,
            btnMessage: "Save Position",

            //Print Position
            isPrintPosition: false,
            signatureFieldEmployeeName: null,
            signatureFieldSupervisorName: null,
        };
    },
    methods: {
        // Search division toggle
        searchDiv() {
            this.divSearch = !this.divSearch;
        },

        // Get div name and id
        getDivNameAndId() {
            this.form.division_name = localStorage.getItem("division_name");
            this.form.division_id = localStorage.getItem("division_id");
            this.searchDiv();
        },

        // Search position toggle from Form
        searchPos() {
            this.posSearch = !this.posSearch;
        },

        // Get pos name and id
        getPosNameAndId() {
            this.form.supervisor_name = localStorage.getItem("position_name");
            this.supervisor_id = localStorage.getItem("position_id");
            this.searchPos();
        },

        searchPositions() {
            this.isSearchPos = !this.isSearchPos;
        },

        // Save position
        async validateAddPosition() {
            this.isSaving = true;
            this.btnMessage = "Saving...";
            const getToken = localStorage.getItem("token");
            this.baseUrl = localStorage.getItem("base_url");
            this.baseUrl = this.baseUrl + "/api/position/create";

            const options = {
                method: "POST",
                url: this.baseUrl,
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    Authorization: "Bearer " + getToken,
                },
                data: {
                    // Position description
                    title: this.form.title,
                    item_number: this.form.item_number,
                    salary_grade_id: this.form.salary_grade_id,
                    division_name: this.form.division_name,
                    division_id: localStorage.getItem("division_id"),
                    level: this.form.level,
                    employment_status_id: this.form.employment_status_id,
                    former_position: this.form.former_position,
                    place_of_work: this.form.place_of_work,
                    supervisor_name: this.form.supervisor_name,
                    supervisor_id: localStorage.getItem("position_id"),
                    classification: this.form.classification,
                    funding_source_id: this.form.funding_source_id,

                    // Position title and item number of those directly supervised
                    supervised_position_title:
                        this.form.supervised_position_title,
                    supervised_item_number: this.form.supervised_item_number,

                    // Contacts, clients and stakeholders
                    contact_internal_executive:
                        this.form.contact_internal_executive,
                    contact_internal_non_supervisor:
                        this.form.contact_internal_non_supervisor,
                    contact_internal_supervisor:
                        this.form.contact_internal_supervisor,
                    contact_internal_staff: this.form.contact_internal_staff,
                    contact_external_public: this.form.contact_external_public,
                    contact_external_agencies:
                        this.form.contact_external_agencies,
                    contact_external_others: this.form.contact_external_others,

                    // Working conditions
                    office_work: this.form.office_work,
                    field_work: this.form.field_work,
                    other_work: this.form.other_work,
                    general_function: this.form.general_function,
                    job_summary: this.form.job_summary,

                    // Qualification standards
                    education: this.form.education,
                    experience: this.form.experience,
                    training: this.form.training,
                    eligibility: this.form.eligibility,
                    core_competencies: this.form.core_competencies,
                    core_compentency_level: this.form.core_compentency_level,
                    leadership_compentencies:
                        this.form.leadership_compentencies,
                    leadership_compentency_level:
                        this.form.leadership_compentency_level,

                    // Statement of competency and responsibilities
                    percentage_working_time: this.form.percentage_working_time,
                    duties_responsibilities: this.form.duties_responsibilities,
                    duties_competency_level: this.form.duties_competency_level,
                    equipments: this.form.equipments,
                },
            };

            let resp = await this.axiosRequest(options);
            this.notificationMessage =
                resp === 422
                    ? "One or more errors in the fields."
                    : "Position has been created.";
            if (resp === 422) {
                // Do Nothing
            } else {
                await this.emptyFormInput();
            }
            this.created = true;
            this.isSaving = false;
            this.btnMessage = "Save Position";

            // let resp = await this.errAxiosRequest(options);
            // this.notificationMessage = (resp === 422) ? "One or more errors in the fields." : "Position has been created."
            // await this.emptyFormInput();
            // this.created = true;
        },

        async emptyFormInput() {
            // Empty form
            // Position description
            (this.form.title = ""),
                (this.form.item_number = ""),
                // this.form.salary_grade_id = "",
                (this.form.division_name = ""),
                (this.form.level = ""),
                (this.form.employment_status_id = ""),
                (this.form.former_position = ""),
                (this.form.place_of_work = ""),
                (this.form.supervisor_name = ""),
                (this.form.classification = ""),
                // Position title and item number of those directly supervised
                (this.form.supervised_position_title = ""),
                (this.form.supervised_item_number = ""),
                // Contacts, clients and stakeholders
                (this.form.contact_internal_executive = ""),
                (this.form.contact_internal_non_supervisor = ""),
                (this.form.contact_internal_supervisor = ""),
                (this.form.contact_internal_staff = ""),
                (this.form.contact_external_public = ""),
                (this.form.contact_external_agencies = ""),
                (this.form.contact_external_others = ""),
                // Working conditions
                (this.form.office_work = ""),
                (this.form.field_work = ""),
                (this.form.other_work = ""),
                (this.form.general_function = ""),
                (this.form.job_summary = ""),
                // Qualification standards
                (this.form.education = ""),
                (this.form.experience = ""),
                (this.form.training = ""),
                (this.form.eligibility = ""),
                (this.form.core_competencies = ""),
                (this.form.core_compentency_level = ""),
                (this.form.leadership_compentencies = ""),
                (this.form.leadership_compentency_level = ""),
                // Statement of competency and responsibilities
                (this.form.percentage_working_time = ""),
                (this.form.duties_responsibilities = ""),
                (this.form.duties_competency_level = ""),
                (this.form.equipments = "");
        },

        // get positions
        async getPosition() {
            let positionID = localStorage.getItem("selectedPositionID");
            const getToken = localStorage.getItem("token");
            this.baseUrl = localStorage.getItem("base_url");
            this.baseUrl = this.baseUrl + "/api/position/search/" + positionID;

            this.position = await axios
                .get(this.baseUrl, {
                    headers: {
                        Authorization: "Bearer " + getToken,
                        Accept: "application/json",
                    },
                })
                .catch((e) => {
                    console.log(e);
                });
            this.position = this.position.data;

            this.form.title = this.position.title;
            this.form.item_number = this.position.item_number;
            this.form.salary_grade_id = this.position.sg.salary_grade_id;
            this.form.salary_autorized = this.position.sg.salary;
            this.form.division_name = this.position.div.name;
            this.form.division_id = this.position.div.division_id;
            this.form.level = this.position.level;
            this.form.employment_status_id = this.position.employmentStatus.id;
            this.form.former_position = this.position.former_position;
            this.form.place_of_work = this.position.place_of_work;
            this.form.supervisor_name = this.position.immediateSupervisor.name;
            this.form.classification = this.position.classification;
            (this.form.funding_source_id = this.position.fundingSource.id),
                // Position title and item number of those directly supervised
                (this.form.supervised_position_title =
                    this.position.supervised_position_title);
            this.form.supervised_item_number =
                this.position.supervised_item_number;

            // Contacts, clients and stakeholders
            this.form.contact_internal_executive =
                this.position.contact_internal_executive;
            this.form.contact_internal_non_supervisor =
                this.position.contact_internal_non_supervisor;
            this.form.contact_internal_supervisor =
                this.position.contact_internal_supervisor;
            this.form.contact_internal_staff =
                this.position.contact_internal_staff;
            this.form.contact_external_public =
                this.position.contact_external_public;
            this.form.contact_external_agencies =
                this.position.contact_external_agencies;
            this.form.contact_external_others =
                this.position.contact_external_others;

            // Working conditions
            this.form.office_work = this.position.office_work;
            this.form.field_work = this.position.field_work;
            this.form.other_work = this.position.other_work;
            this.form.general_function = this.position.general_function;
            this.form.job_summary = this.position.job_summary;

            // Qualification standards
            this.form.education = this.position.education;
            this.form.experience = this.position.experience;
            this.form.training = this.position.training;
            this.form.eligibility = this.position.eligibility;
            this.form.core_competencies = this.position.core_competencies;
            this.form.core_compentency_level =
                this.position.core_compentency_level;
            this.form.leadership_compentencies =
                this.position.leadership_compentencies;
            this.form.leadership_compentency_level =
                this.position.leadership_compentency_level;

            // Statement of competency and responsibilities
            this.form.percentage_working_time =
                this.position.percentage_working_time;
            this.form.duties_responsibilities =
                this.position.duties_responsibilities;
            this.form.duties_competency_level =
                this.position.duties_competency_level;
            this.form.equipments = this.position.equipments;
        },

        //Update Position
        async updatePosition() {
            this.isSaving = true;
            this.btnMessage = "Updating...";
            let positionID = localStorage.getItem("selectedPositionID");
            const getToken = localStorage.getItem("token");
            this.baseUrl = localStorage.getItem("base_url");
            this.baseUrl = this.baseUrl + "/api/position/update/" + positionID;

            const options = {
                method: "PUT",
                url: this.baseUrl,
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    Authorization: "Bearer " + getToken,
                },
                data: {
                    // Position description
                    title: this.form.title,
                    item_number: this.form.item_number,
                    salary_grade_id: this.form.salary_grade_id,
                    division_name: this.form.division_name,
                    division_id: this.form.division_id,
                    level: this.form.level,
                    employment_status_id: this.form.employment_status_id,
                    former_position: this.form.former_position,
                    place_of_work: this.form.place_of_work,
                    supervisor_name: this.form.supervisor_name,
                    supervisor_id: localStorage.getItem("position_id"),
                    classification: this.form.classification,
                    funding_source_id: this.form.funding_source_id,

                    // Position title and item number of those directly supervised
                    supervised_position_title:
                        this.form.supervised_position_title,
                    supervised_item_number: this.form.supervised_item_number,

                    // Contacts, clients and stakeholders
                    contact_internal_executive:
                        this.form.contact_internal_executive,
                    contact_internal_non_supervisor:
                        this.form.contact_internal_non_supervisor,
                    contact_internal_supervisor:
                        this.form.contact_internal_supervisor,
                    contact_internal_staff: this.form.contact_internal_staff,
                    contact_external_public: this.form.contact_external_public,
                    contact_external_agencies:
                        this.form.contact_external_agencies,
                    contact_external_others: this.form.contact_external_others,

                    // Working conditions
                    office_work: this.form.office_work,
                    field_work: this.form.field_work,
                    other_work: this.form.other_work,
                    general_function: this.form.general_function,
                    job_summary: this.form.job_summary,

                    // Qualification standards
                    education: this.form.education,
                    experience: this.form.experience,
                    training: this.form.training,
                    eligibility: this.form.eligibility,
                    core_competencies: this.form.core_competencies,
                    core_compentency_level: this.form.core_compentency_level,
                    leadership_compentencies:
                        this.form.leadership_compentencies,
                    leadership_compentency_level:
                        this.form.leadership_compentency_level,

                    // Statement of competency and responsibilities
                    percentage_working_time: this.form.percentage_working_time,
                    duties_responsibilities: this.form.duties_responsibilities,
                    duties_competency_level: this.form.duties_competency_level,
                    equipments: this.form.equipments,
                },
            };

            await axios
                .request(options)
                .then((response) => {
                    console.log(response.data);
                    this.notificationMessage = "Position has been updated.";
                    this.created = true;
                })
                .catch((error) => {
                    console.error(error.response);
                    this.notificationMessage =
                        "There is an error processing the update. Please try again later.";
                    this.created = true;
                });

            this.isSaving = false;
            this.btnMessage = "Update Position";
        },
        //Get Parameters
        async getParam() {
            const getToken = localStorage.getItem("token");
            this.baseUrl = localStorage.getItem("base_url");
            this.baseUrl = this.baseUrl + "/api/position/parameter";
            const options = {
                method: "GET",
                url: this.baseUrl,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer" + getToken,
                },
            };

            let newParam = await this.axiosRequest(options);
            this.param = newParam.data;
            console.log(this.param);
        },

        //Get Salary Grade
        async getSalaryGrade() {
            const getToken = localStorage.getItem("token");
            this.baseUrl = localStorage.getItem("base_url");
            this.baseUrl = this.baseUrl + "/api/position/parameter";
            const options = {
                method: "GET",
                url: this.baseUrl,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer" + getToken,
                },
            };

            const newParam = await this.axiosRequest(options);
            const salaryGrade = newParam.data.salary_grade;
            let getSalary = salaryGrade.find(
                (item) => item.salary_grade_id === this.form.salary_grade_id
            );
            this.form.salary_autorized = getSalary.salary;
        },

        //Set Add Position
        addPosition() {
            localStorage.setItem("positionId", null);
            localStorage.setItem("currentPositionAction", null);
            this.$router.go();
        },

        async genereatePrintPosition() {
            let printToken = null;
            this.baseUrl = localStorage.getItem("base_url");

            let parentURL = this.baseUrl;
            const getToken = localStorage.getItem("token");
            this.baseUrl = this.baseUrl + "/api/token/generate";

            const options = {
                method: "POST",
                url: this.baseUrl,
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    Authorization: "Bearer " + getToken,
                },
                data: {
                    permission: "print position",
                    model_name: {
                        positionId: this.positionId,
                        employeeName: this.signatureFieldEmployeeName,
                        supervisorName: this.signatureFieldSupervisorName,
                    },
                },
            };

            axios
                .request(options)
                .then((response) => {
                    console.log(response.data);
                    printToken = response.data.message;
                    console.log(printToken);

                    //New Tab to generate the Report
                    parentURL =
                        parentURL +
                        "/generate/report/1/single/pdf/" +
                        printToken;
                    window.open(parentURL, "_blank");
                })
                .catch(function (error) {
                    console.error(error);
                });
        },
        //Call Axios
        async axiosRequest(options) {
            let getResp;
            await axios
                .request(options)
                .then((response) => {
                    getResp = response;
                })
                .catch((error) => {
                    console.log(error.response);
                    getResp = error.response.status;
                });
            return getResp;
        },

        //Error Submission Axios Request
        async errAxiosRequest(options) {
            let getResp;
            await axios
                .request(options)
                .then((response) => {
                    getResp = response.data.data;
                })
                .catch((error) => {
                    getResp = error.response.status;
                });
            return getResp;
        },
    },

    async mounted() {
        await this.getParam();
    },

    async created() {
        this.userAction = localStorage.getItem("currentPositionAction");

        if (this.userAction === "edit") {
            this.isPositionUpdate = true;
            this.positionId = localStorage.getItem("positionId");
            this.userActionMessage = "Update position";
            this.btnMessage = "Update Position";
            await this.getPosition();
        }
    },

    beforeMount() {
        if (localStorage.getItem("role") === "Employee") {
            this.$router.push({ name: "Dashboard" });
        }
    },
};
</script>

<style scoped>
.md-card-header {
    background-color: #042278 !important;
    margin-bottom: 20px !important;
}
.emp-search {
    float: right;
}
.md-theme-default {
    color: white !important;
}

.md-theme-default .md-body-1 {
    color: black !important;
}
</style>
