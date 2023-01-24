<template>
    <div class="content">
        <div class="md-layout">
            <div class="md-layout-item md-small-size-100 md-size-25">
                <!-- <label
                    v-if="userAction === 'emp_selected'"
                > -->
                <!-- <label>
                    <h5>
                        Request for:
                        <label style="text-transform: uppercase !important">{{
                            fullName
                        }}</label>
                    </h5>
                </label> -->
            </div>
            <div class="md-layout-item md-small-size-100 md-size-75 text-right">
                <md-button
                    class="md-dense md-raised md-primary"
                    @click="addApplication()"
                    v-if="$permissions.includes('write applicant')"
                    >Add Application</md-button
                >
                <md-button
                    class="md-dense md-raised md-primary"
                    @click="isPrintApplication = !isPrintApplication"
                    v-if="$permissions.includes('print applicant')"
                    >Print</md-button
                >
            </div>
        </div>

        <!-- Form Application -->
        <div
            class="md-layout-item md-small-size-100 md-size-100"
            v-if="isAddApplication"
        >
            <md-card>
                <md-card-header class="md-card-header">
                    <h4 v-if="!isUpdateApplication" class="title">
                        New Application Matrix - Form
                    </h4>
                    <h4 v-else class="title">
                        {{ firstName }} {{ lastName }} - Applicant Matrix
                    </h4>
                </md-card-header>
                <md-card-content>
                    <div class="md-layout" style="margin-top: 20px !important">
                        <div
                            class="md-layout-item md-small-size-100 md-size-50"
                        >
                            <md-field>
                                <label>First Name</label>
                                <md-input
                                    v-model="firstName"
                                    type="text"
                                    required
                                ></md-input>
                            </md-field>
                        </div>
                        <div
                            class="md-layout-item md-small-size-100 md-size-50"
                        >
                            <md-field>
                                <label>Last Name</label>
                                <md-input
                                    v-model="lastName"
                                    type="text"
                                    required
                                ></md-input>
                            </md-field>
                        </div>
                        <div
                            class="md-layout-item md-small-size-100 md-size-50"
                        >
                            <md-field>
                                <label>Middle Name</label>
                                <md-input
                                    v-model="middleName"
                                    type="text"
                                ></md-input>
                            </md-field>
                        </div>
                        <div
                            class="md-layout-item md-small-size-100 md-size-50"
                        >
                            <md-field>
                                <label>Name Extension</label>
                                <md-select v-model="nameExtension">
                                    <md-option value="">N/A</md-option>
                                    <md-option
                                        v-for="ne in param.nameExtension"
                                        :key="ne"
                                        :value="ne"
                                        >{{ ne }}</md-option
                                    >
                                </md-select>
                            </md-field>
                        </div>
                        <div
                            class="md-layout-item md-small-size-100 md-size-50"
                        >
                            <md-field>
                                <label>Civil Status</label>
                                <md-select v-model="civilStatus">
                                    <md-option
                                        v-for="cv in param.civilStatus"
                                        :key="cv"
                                        :value="cv"
                                        >{{ cv }}</md-option
                                    >
                                </md-select>
                            </md-field>
                        </div>
                        <div
                            class="md-layout-item md-small-size-100 md-size-50"
                        >
                            <md-datepicker
                                :md-model-type="String"
                                label="Date of Birth"
                                v-model="birthdate"
                                ><label>Date of Birth</label></md-datepicker
                            >
                        </div>
                        <div
                            class="md-layout-item md-small-size-100 md-size-50"
                        >
                            <md-field>
                                <label>Height meters (m)</label>
                                <md-input
                                    v-model="height"
                                    maxlength="3"
                                    type="number"
                                ></md-input>
                            </md-field>
                        </div>
                        <div
                            class="md-layout-item md-small-size-100 md-size-50"
                        >
                            <md-field>
                                <label>Gender</label>
                                <md-select v-model="gender">
                                    <md-option
                                        v-for="g in param.gender"
                                        :key="g"
                                        :value="g"
                                        >{{ g }}</md-option
                                    >
                                </md-select>
                            </md-field>
                        </div>
                        <div
                            class="md-layout-item md-small-size-100 md-size-50"
                        >
                            <md-field>
                                <label>Address</label>
                                <md-input
                                    v-model="address"
                                    type="text"
                                    required
                                ></md-input>
                            </md-field>
                        </div>
                        <div
                            class="md-layout-item md-small-size-100 md-size-50"
                        >
                            <md-field>
                                <label>Contact Number</label>
                                <md-input
                                    v-model="contactNumber"
                                    type="text"
                                    required
                                ></md-input>
                            </md-field>
                        </div>
                        <div
                            class="md-layout-item md-small-size-100 md-size-50"
                        >
                            <md-field>
                                <label>Email Address</label>
                                <md-input
                                    v-model="email"
                                    type="email"
                                    required
                                ></md-input>
                            </md-field>
                        </div>
                        <div
                            class="md-layout-item md-small-size-100 md-size-50"
                        >
                            <md-field>
                                <label>Position / Previous Position</label>
                                <md-input
                                    v-model="currentPosition"
                                    type="text"
                                ></md-input>
                            </md-field>
                        </div>
                        <div
                            class="md-layout-item md-small-size-100 md-size-50"
                        >
                            <md-field>
                                <label>Employment Status</label>
                                <md-input
                                    v-model="employmentStatus"
                                    type="text"
                                ></md-input>
                            </md-field>
                        </div>
                        <div
                            class="md-layout-item md-small-size-100 md-size-50"
                        >
                            <md-field>
                                <label
                                    >No. of Years in the present Position /
                                    Previous Company</label
                                >
                                <md-input
                                    v-model="yearsInCurrentPosition"
                                    type="text"
                                ></md-input>
                            </md-field>
                        </div>
                        <!-- College -->
                        <div
                            class="md-layout-item md-small-size-100 md-size-100"
                        >
                            College
                            <md-button
                                class="md-warning md-raised md-dense"
                                style="float: right; color: black !important"
                                @click="isAddCollege = true"
                                v-if="$permissions.includes('write applicant')"
                                >Add College</md-button
                            >
                            <md-table v-model="college" md-card>
                                <md-table-empty-state
                                    md-label="No current college"
                                >
                                </md-table-empty-state>

                                <md-table-row
                                    slot="md-table-row"
                                    slot-scope="{ item, index }"
                                >
                                    <md-table-cell md-label="Course">{{
                                        item.course
                                    }}</md-table-cell>
                                    <md-table-cell md-label="School">{{
                                        item.school
                                    }}</md-table-cell>
                                    <md-table-cell md-label="Year Graduated">{{
                                        item.yearGraduated
                                    }}</md-table-cell>
                                    <md-table-cell md-label="Units">{{
                                        item.units
                                    }}</md-table-cell>
                                    <md-table-cell md-label="Actions">
                                        <md-button
                                            class="md-danger md-raised"
                                            @click="deleteCollege(index)"
                                            >⌫</md-button
                                        >
                                    </md-table-cell>
                                </md-table-row>
                            </md-table>
                        </div>

                        <!-- Work Experience -->
                        <div
                            class="md-layout-item md-small-size-100 md-size-100"
                        >
                            Work Experience
                            <md-button
                                class="md-warning md-raised md-dense"
                                style="float: right; color: black !important"
                                @click="isAddWorkExperience = true"
                                v-if="$permissions.includes('write applicant')"
                                >Add work experience</md-button
                            >
                            <md-table v-model="workExperience" md-card>
                                <md-table-empty-state
                                    md-label="No current work experience"
                                >
                                </md-table-empty-state>

                                <md-table-row
                                    slot="md-table-row"
                                    slot-scope="{ item, index }"
                                >
                                    <md-table-cell md-label="Position">{{
                                        item.position
                                    }}</md-table-cell>
                                    <md-table-cell md-label="Company">{{
                                        item.company
                                    }}</md-table-cell>
                                    <md-table-cell md-label="Date From">{{
                                        item.dateFrom
                                    }}</md-table-cell>
                                    <md-table-cell md-label="Date To">{{
                                        item.dateTo
                                    }}</md-table-cell>
                                    <md-table-cell md-label="Actions">
                                        <md-button
                                            class="md-danger md-raised"
                                            @click="deleteWorkExperience(index)"
                                            >⌫</md-button
                                        >
                                    </md-table-cell>
                                </md-table-row>
                            </md-table>
                        </div>
                        <div
                            class="md-layout-item md-small-size-100 md-size-100"
                        >
                            Trainings
                            <md-button
                                class="md-warning md-raised md-dense"
                                style="float: right; color: black !important"
                                @click="isAddTraining = true"
                                v-if="$permissions.includes('write applicant')"
                                >Add training</md-button
                            >
                            <md-table v-model="training" md-card>
                                <md-table-empty-state
                                    md-label="No current trainings"
                                >
                                </md-table-empty-state>

                                <md-table-row
                                    slot="md-table-row"
                                    slot-scope="{ item, index }"
                                >
                                    <md-table-cell md-label="Title">{{
                                        item.title
                                    }}</md-table-cell>
                                    <md-table-cell md-label="Hours">{{
                                        item.hours
                                    }}</md-table-cell>
                                    <md-table-cell md-label="Year">{{
                                        item.year
                                    }}</md-table-cell>
                                    <md-table-cell md-label="Actions">
                                        <md-button
                                            class="md-danger md-raised"
                                            @click="deleteTraining(index)"
                                            >⌫</md-button
                                        >
                                    </md-table-cell>
                                </md-table-row>
                            </md-table>
                        </div>

                        <div
                            class="md-layout-item md-small-size-100 md-size-50"
                        >
                            <md-field>
                                <label>Position Title</label>
                                <md-input
                                    v-model="positionTitle"
                                    type="text"
                                ></md-input>
                            </md-field>
                        </div>

                        <div
                            class="md-layout-item md-small-size-100 md-size-50"
                        >
                            <md-field>
                                <label>Vacant on Positions</label>
                                <md-input
                                    v-model="vacantOnPositions"
                                    type="number"
                                ></md-input>
                            </md-field>
                        </div>

                        <!-- Place of Assignment -->
                        <div
                            class="md-layout-item md-small-size-100 md-size-50"
                        >
                            <md-field>
                                <label>Place of Assignment</label>
                                <md-input
                                    v-model="placeOfAssignment"
                                    type="text"
                                ></md-input>
                            </md-field>
                        </div>

                        <!-- Date of Publication -->
                        <div
                            class="md-layout-item md-small-size-100 md-size-50"
                        >
                            <md-datepicker
                                :md-model-type="String"
                                label="Date of Publication"
                                v-model="dateOfPublication"
                                ><label
                                    >Date of Publication</label
                                ></md-datepicker
                            >
                        </div>

                        <!-- Position Education -->
                        <div
                            class="md-layout-item md-small-size-100 md-size-50"
                        >
                            <md-field>
                                <label>Position Education</label>
                                <md-input
                                    v-model="positionEducation"
                                    type="text"
                                ></md-input>
                            </md-field>
                        </div>

                        <!-- Position Training -->
                        <div
                            class="md-layout-item md-small-size-100 md-size-50"
                        >
                            <md-field>
                                <label>Position Training</label>
                                <md-input
                                    v-model="positionTraining"
                                    type="text"
                                ></md-input>
                            </md-field>
                        </div>

                        <!-- Position Experience -->
                        <div
                            class="md-layout-item md-small-size-100 md-size-50"
                        >
                            <md-field>
                                <label>Position Experience</label>
                                <md-input
                                    v-model="positionExperience"
                                    type="text"
                                ></md-input>
                            </md-field>
                        </div>

                        <!-- Position Eligibility -->
                        <div
                            class="md-layout-item md-small-size-100 md-size-50"
                        >
                            <md-field>
                                <label>Position Eligibility</label>
                                <md-input
                                    v-model="positionEligibility"
                                    type="text"
                                ></md-input>
                            </md-field>
                        </div>

                        <!-- Date Received -->
                        <div
                            class="md-layout-item md-small-size-100 md-size-50"
                        >
                            <md-datepicker
                                :md-model-type="String"
                                label="Date Received"
                                v-model="dateReceived"
                                ><label>Date Received</label></md-datepicker
                            >
                        </div>

                        <!-- Remarks -->
                        <div
                            class="md-layout-item md-small-size-100 md-size-50"
                        >
                            <md-field>
                                <label>Remarks</label>
                                <md-input
                                    v-model="remarks"
                                    type="text"
                                ></md-input>
                            </md-field>
                        </div>

                        <div
                            class="md-layout-item md-size-100 text-right"
                            v-if="$permissions.includes('write applicant')"
                        >
                            <md-button
                                v-if="isUpdateApplication"
                                class="md-raised md-primary md-dense"
                                :disabled="isUpdatingApplication"
                                @click="validateUpdateApplication()"
                            >
                                <!-- <md-icon>login</md-icon> -->
                                {{ updateBtnMessage }}</md-button
                            >

                            <md-button
                                v-else
                                class="md-raised md-primary md-dense"
                                :disabled="isAddingApplication"
                                @click="validateAddApplication()"
                            >
                                <!-- <md-icon>login</md-icon> -->
                                {{ addBtnMessage }}</md-button
                            >
                            <!-- <md-button
                            class="md-dense md-danger"
                            @click="isAddApplication = false"
                            >✕ Close</md-button
                        > -->
                        </div>
                    </div>
                </md-card-content>
            </md-card>
        </div>

        <!-- Application Summary -->
        <div class="md-layout" v-if="$permissions.includes('search applicant')">
            <!-- Application Summary -->
            <div class="md-layout-item md-small-size-100 md-size-100">
                <md-card>
                    <md-card-header
                        class="md-card-header"
                        style="margin-bottom: 20px"
                    >
                        <h4 class="title">Application Records</h4>
                    </md-card-header>
                    <!-- <md-card-content v-if="userAction === 'emp_selected' "> -->
                    <md-card-content>
                        <div class="md-layout">
                            <div
                                class="
                                    md-layout-item md-small-size-100 md-size-100
                                "
                            >
                                <md-table v-model="applications" md-card>
                                    <md-table-toolbar>
                                        <div class="md-toolbar-section-start">
                                            <!-- <h1 class="md-title">Users</h1> -->
                                        </div>

                                        <md-field
                                            class="md-toolbar-section-end"
                                        >
                                            <!-- <md-input placeholder="Search by name..." v-model="search" @input="searchOnTable" /> -->
                                            <md-input
                                                placeholder="Search..."
                                                v-model="searchValue"
                                            />
                                            <md-button
                                                class="md-primary md-dense"
                                                style="
                                                    margin-bottom: 10px !important;
                                                "
                                                @click="
                                                    getApplicationUsingSearch()
                                                "
                                                :disabled="isSearching"
                                            >
                                                {{ btnSearch }}
                                            </md-button>
                                        </md-field>
                                    </md-table-toolbar>

                                    <md-table-empty-state
                                        md-label="No applications found"
                                    >
                                        <!-- <md-button
                                            class="md-primary md-raised"
                                            @click="isAddApplication = true"
                                            >Create new application</md-button
                                        > -->
                                    </md-table-empty-state>

                                    <md-table-row
                                        slot="md-table-row"
                                        slot-scope="{ item }"
                                    >
                                        <md-table-cell
                                            md-label="Date Received"
                                            md-sort-by="dateReceived"
                                            >{{
                                                item.dateReceived
                                            }}</md-table-cell
                                        >
                                        <md-table-cell
                                            md-label="Name"
                                            md-sort-by="fullName"
                                            >{{ item.fullName }}</md-table-cell
                                        >
                                        <md-table-cell
                                            md-label="Civil Status"
                                            md-sort-by="civilStatus"
                                            >{{
                                                item.civilStatus
                                            }}</md-table-cell
                                        >
                                        <md-table-cell
                                            md-label="Age"
                                            md-sort-by="age"
                                            >{{ item.age }}</md-table-cell
                                        >
                                        <md-table-cell
                                            md-label="Height"
                                            md-sort-by="height"
                                            >{{ item.height }}</md-table-cell
                                        >
                                        <md-table-cell
                                            md-label="Gender"
                                            md-sort-by="gender"
                                            >{{ item.gender }}</md-table-cell
                                        >
                                        <md-table-cell
                                            md-label="Address"
                                            md-sort-by="address"
                                            >{{ item.address }}</md-table-cell
                                        >
                                        <md-table-cell
                                            md-label="Contact Number"
                                            md-sort-by="contactNumber"
                                            >{{
                                                item.contactNumber
                                            }}</md-table-cell
                                        >
                                        <md-table-cell
                                            md-label="Email"
                                            md-sort-by="email"
                                            >{{ item.email }}</md-table-cell
                                        >
                                        <md-table-cell
                                            md-label="Position Title"
                                            md-sort-by="positionTitle"
                                            >{{
                                                item.positionTitle
                                            }}</md-table-cell
                                        >
                                        <md-table-cell
                                            md-label="Remarks"
                                            md-sort-by="remarks"
                                            >{{ item.remarks }}</md-table-cell
                                        >
                                        <md-table-cell
                                            md-label="Actions"
                                            md-sort-by="actions"
                                        >
                                            <md-button
                                                class="md-primary md-dense"
                                                @click="
                                                    editApplication(item.id)
                                                "
                                            >
                                                ✎
                                            </md-button>
                                            <md-button
                                                class="md-danger md-dense"
                                                @click="
                                                    deleteApplication(item.id)
                                                "
                                            >
                                                ⌫
                                            </md-button>
                                        </md-table-cell>
                                    </md-table-row>
                                </md-table>
                            </div>
                        </div>
                    </md-card-content>
                </md-card>
            </div>
        </div>

        <!-- Dialog boxes here and UI improvement -->
        <!-- <DialogCard>
            <section slot="header">Add Application</section>
            <section slot="body">
                <form @submit.prevent="validateAddApplication()">


                    <md-dialog-actions>

                    </md-dialog-actions>
                </form>
            </section>
        </DialogCard> -->

        <!-- Add College -->
        <DialogCard v-if="isAddCollege">
            <section slot="header">Add College</section>
            <section slot="body">
                <form @submit.prevent="validateAddCollege()">
                    <md-field>
                        <label>Course</label>
                        <md-input
                            v-model="formCollege.course"
                            type="text"
                            required
                        ></md-input>
                    </md-field>
                    <md-field>
                        <label>School</label>
                        <md-input
                            v-model="formCollege.school"
                            type="text"
                            required
                        ></md-input>
                    </md-field>
                    <md-field>
                        <label>Year Graduated</label>
                        <md-input
                            v-model="formCollege.yearGraduated"
                            type="number"
                            maxlength="4"
                            required
                        ></md-input>
                    </md-field>
                    <md-field>
                        <label>Units</label>
                        <md-input
                            v-model="formCollege.units"
                            type="number"
                            required
                        ></md-input>
                    </md-field>
                    <md-dialog-actions>
                        <md-button
                            class="md-raised md-primary md-dense"
                            @click="validateAddCollege()"
                        >
                            Add College
                        </md-button>
                        <md-button
                            class="md-dense md-danger"
                            @click="isAddCollege = false"
                            >✕ Close</md-button
                        >
                    </md-dialog-actions>
                </form>
            </section>
        </DialogCard>

        <!-- Add Work Experience -->
        <DialogCard v-if="isAddWorkExperience">
            <section slot="header">Add Work Experience</section>
            <section slot="body">
                <form @submit.prevent="validateAddWorkExperience()">
                    <md-field>
                        <label>Position</label>
                        <md-input
                            v-model="formWorkExperience.position"
                            type="text"
                            required
                        ></md-input>
                    </md-field>
                    <md-field>
                        <label>Company</label>
                        <md-input
                            v-model="formWorkExperience.company"
                            type="text"
                            required
                        ></md-input>
                    </md-field>
                    <br />
                    <label>Date From:</label>
                    <md-field>
                        <label>Select Month</label>
                        <md-select v-model="formWorkExperience.dateFromMonth">
                            <md-option value="01">January</md-option>
                            <md-option value="02">February</md-option>
                            <md-option value="03">March</md-option>
                            <md-option value="04">April</md-option>
                            <md-option value="05">May</md-option>
                            <md-option value="06">June</md-option>
                            <md-option value="07">July</md-option>
                            <md-option value="08">August</md-option>
                            <md-option value="09">September</md-option>
                            <md-option value="10">October</md-option>
                            <md-option value="11">November</md-option>
                            <md-option value="12">December</md-option>
                        </md-select>
                    </md-field>
                    <md-field>
                        <label>Date From Year</label>
                        <md-input
                            v-model="formWorkExperience.dateFromYear"
                            type="number"
                            required
                            maxlength="4"
                        ></md-input>
                    </md-field>
                    <br />
                    <label>Date To:</label>
                    <md-field>
                        <label>Select Month</label>
                        <md-select v-model="formWorkExperience.dateToMonth">
                            <md-option value="01">January</md-option>
                            <md-option value="02">February</md-option>
                            <md-option value="03">March</md-option>
                            <md-option value="04">April</md-option>
                            <md-option value="05">May</md-option>
                            <md-option value="06">June</md-option>
                            <md-option value="07">July</md-option>
                            <md-option value="08">August</md-option>
                            <md-option value="09">September</md-option>
                            <md-option value="10">October</md-option>
                            <md-option value="11">November</md-option>
                            <md-option value="12">December</md-option>
                        </md-select>
                    </md-field>
                    <md-field>
                        <label>Date To Year</label>
                        <md-input
                            v-model="formWorkExperience.dateToYear"
                            type="number"
                            required
                            maxlength="4"
                        ></md-input>
                    </md-field>
                    <!-- <md-datepicker
                            :md-model-type="String"
                            label="Date From"
                            v-model="formWorkExperience.dateFrom"
                            ><label>Date From</label></md-datepicker
                        >      -->
                    <!-- <md-datepicker
                            :md-model-type="String"
                            label="Date To"
                            v-model="formWorkExperience.dateTo"
                            ><label>Date To</label></md-datepicker
                        >                                                                -->

                    <md-dialog-actions>
                        <md-button
                            class="md-raised md-primary md-dense"
                            @click="validateAddWorkExperience()"
                        >
                            Add Work Experience
                        </md-button>

                        <md-button
                            class="md-dense md-danger"
                            @click="isAddWorkExperience = false"
                            >✕ Close</md-button
                        >
                    </md-dialog-actions>
                </form>
            </section>
        </DialogCard>

        <!-- Add Training -->
        <DialogCard v-if="isAddTraining">
            <section slot="header">Add Training</section>
            <section slot="body">
                <form @submit.prevent="validateAddTraining()">
                    <md-field>
                        <label>Title</label>
                        <md-input
                            v-model="formTraining.title"
                            type="text"
                            required
                        ></md-input>
                    </md-field>
                    <md-field>
                        <label>Hours</label>
                        <md-input
                            v-model="formTraining.hours"
                            type="number"
                            required
                        ></md-input>
                    </md-field>
                    <md-field>
                        <label>Year</label>
                        <md-input
                            v-model="formTraining.year"
                            type="number"
                            required
                            maxlength="4"
                        ></md-input>
                    </md-field>
                    <md-dialog-actions>
                        <md-button
                            class="md-raised md-primary md-dense"
                            @click="validateAddTraining()"
                        >
                            Add Training
                        </md-button>

                        <md-button
                            class="md-dense md-danger"
                            @click="isAddTraining = false"
                            >✕ Close</md-button
                        >
                    </md-dialog-actions>
                </form>
            </section>
        </DialogCard>

        <!-- Delete Application -->
        <DialogCard v-if="isDeleteApplication">
            <section slot="header">Delete this application</section>
            <section slot="body">
                <label>You cannot undo the changes. Proceed?</label>
                <md-dialog-actions>
                    <md-button
                        class="md-raised md-danger md-dense"
                        @click="validateDeleteApplication()"
                        :disabled="isDeletingApplication"
                    >
                        {{ deleteBtnMessage }}
                    </md-button>

                    <md-button
                        class="md-dense md-warning"
                        style="color: black !important"
                        @click="isDeleteApplication = !isDeleteApplication"
                        >✕ Cancel Deletion</md-button
                    >
                </md-dialog-actions>
            </section>
        </DialogCard>

        <!-- Print Application -->
        <DialogCard v-if="isPrintApplication">
            <section slot="header">Print Application</section>
            <section slot="body">
                <md-field>
                    <label>Position Name</label>
                    <md-select v-model="positionName">
                        <md-option
                            v-for="position in param.positionTitle"
                            :key="position.positionTitle"
                            :value="position.positionTitle"
                            >{{ position.positionTitle }}</md-option
                        >
                    </md-select>
                </md-field>

                <!-- <md-field>
                    <label>Position Name</label>
                    <md-input
                        v-model="positionName"
                        type="text"
                        required
                    ></md-input>
                </md-field> -->
                <md-dialog-actions>
                    <md-button
                        class="md-raised md-primary md-dense"
                        @click="printApplication()"
                    >
                        Confirm Print Application
                    </md-button>

                    <md-button
                        class="md-dense md-danger"
                        @click="isPrintApplication = !isPrintApplication"
                        >✕ Cancel</md-button
                    >
                </md-dialog-actions>
            </section>
        </DialogCard>

        <md-snackbar
            :md-position="'center'"
            :md-duration="5000"
            :md-active.sync="fireSnackbar"
            md-persistent
        >
            <span>{{ messageSnackbar }}</span>
            <md-button
                class="md-warning md-dense"
                @click="fireSnackbar = false"
            >
                <label style="color: black">Dismiss</label>
            </md-button>
        </md-snackbar>
    </div>
</template>

<script>
let baseUrl = localStorage.getItem("base_url");
let token = localStorage.getItem("token");
import UserAction from "../mixins/userAction.js";
import axios from "axios";
const DialogCard = () =>
    import(
        /* webpackChunkName: "DialogCard" */ "../components/Cards/DialogCard.vue"
    );
export default {
    name: "ApplicationMatrix",
    mixins: [UserAction],
    components: {
        DialogCard,
    },
    data() {
        return {
            //Fields for the api
            firstName: "John",
            lastName: "Doe",
            middleName: "Mid",
            nameExtension: null,
            birthdate: "2020-01-01",
            height: 0,
            gender: "MALE",
            address: "Angeles City",
            contactNumber: "09101010100",
            civilStatus: "SINGLE",
            email: "sample@sample.com",
            currentPosition: "Teacher",
            employmentStatus: "Permanent",
            yearsInCurrentPosition: "2",
            college: [],
            workExperience: [],
            training: [],
            positionTitle: "Professional Title",
            vacantOnPositions: 0,
            placeOfAssignment: "Angeles City nga ang kulit",
            dateOfPublication: "2020-01-01",
            positionEducation: "Ewan e",
            positionTraining: "Position Training hehehe",
            positionExperience: "Position Experience hehehe",
            positionEligibility: "Eligible hehehe",
            dateReceived: "2020-01-01",
            remarks: null,
            formWorkExperience: {
                position: null,
                company: null,
                dateFrom: null,
                dateTo: null,
                dateFromYear: "2020",
                dateFromMonth: "01",
                dateToYear: "2021",
                dateToMonth: "02",
            },
            formTraining: {
                title: null,
                hours: null,
                year: null,
            },
            formCollege: {
                course: null,
                school: null,
                yearGraduated: "2020",
                units: null,
            },

            //Fields for the api
            // firstName: null,
            // lastName: null,
            // middleName: null,
            // nameExtension: null,
            // birthdate: '2020-01-01',
            // height: 0,
            // gender: 'MALE',
            // address: null,
            // contactNumber: null,
            // civilStatus: null,
            // email: null,
            // currentPosition: null,
            // employmentStatus: null,
            // yearsInCurrentPosition: null,
            // college: [],
            // workExperience: [],
            // training: [],
            // positionTitle: null,
            // vacantOnPositions: 0,
            // placeOfAssignment: null,
            // dateOfPublication: '2020-01-01',
            // positionEducation: null,
            // positionTraining: null,
            // positionExperience: null,
            // positionEligibility: null,
            // dateReceived: '2020-01-01',
            // remarks: null,
            // formWorkExperience: {
            //     position: null,
            //     company: null,
            //     dateFrom: null,
            //     dateTo: null
            // dateFromYear: '2020',
            // dateFromMonth: '01',
            // dateToYear: '2021',
            // dateToMonth: '01'
            // },
            // formTraining: {
            //     title: null,
            //     hours: null,
            //     year: null
            // },
            // formCollege: {
            //     course: null,
            //     school: null,
            //     yearGraduated: null,
            //     units: null,
            // },

            //UI
            fireSnackbar: false,
            messageSnackbar: null,
            isAddApplication: true,
            isAddingApplication: false,
            btnSearch: "Search",
            searchValue: null,
            isSearching: false,
            addBtnMessage: "Confirm Add Application",
            param: [],
            isAddWorkExperience: false,
            isAddTraining: false,
            isAddCollege: false,
            isUpdateApplication: false,
            isUpdatingApplication: false,
            updateID: null,
            updateBtnMessage: "Confirm Update Application",
            isDeleteApplication: false,
            isDeletingApplication: false,
            deleteBtnMessage: "Confirm Deletion of Application",
            deleteID: null,
            //Table
            applications: null,

            //Print
            positionName: null,
            isPrintApplication: false,
        };
    },

    methods: {
        //Add Application
        addApplication() {
            this.resetData();
            this.isUpdateApplication = false;
        },
        //Edit Application
        async editApplication(id) {
            this.isUpdateApplication = true;
            this.updateID = id;
            let newURL = baseUrl + "/api/applicant/search/" + this.updateID;
            const options = {
                method: "GET",
                url: newURL,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + token,
                },
            };

            await axios
                .request(options)
                .then((response) => {
                    let applicant = response.data;
                    this.firstName = applicant.firstName;
                    this.lastName = applicant.lastName;
                    this.middleName = applicant.middleName;
                    this.nameExtension = applicant.nameExtension;
                    this.birthdate = applicant.birthdate;
                    this.height = applicant.height;
                    this.gender = applicant.gender;
                    this.address = applicant.address;
                    this.contactNumber = applicant.contactNumber;
                    this.civilStatus = applicant.civilStatus;
                    this.email = applicant.email;
                    this.currentPosition = applicant.currentPosition;
                    this.employmentStatus = applicant.employmentStatus;
                    this.yearsInCurrentPosition =
                        applicant.yearsInCurrentPosition;
                    this.college = applicant.college;
                    this.workExperience = applicant.workExperience;
                    this.training = applicant.training;
                    this.positionTitle = applicant.positionTitle;
                    this.vacantOnPositions = applicant.vacantOnPositions;
                    this.placeOfAssignment = applicant.placeOfAssignment;
                    this.dateOfPublication = applicant.dateOfPublication;
                    this.positionEducation = applicant.positionEducation;
                    this.positionTraining = applicant.positionTraining;
                    this.positionExperience = applicant.positionExperience;
                    this.positionEligibility = applicant.positionEligibility;
                    this.dateReceived = applicant.dateReceived;
                    this.remarks = applicant.remarks;
                    this.fireSnackbar = true;
                    this.messageSnackbar =
                        "Information has been pulled out for this applicant. Please refer to the form above. Thank you";
                    console.log(response.data);
                })
                .catch((error) => {
                    this.fireSnackbar = true;
                    this.messageSnackbar =
                        "There is an error getting the information of the applicant. Please try again.";
                    console.error(error);
                });
        },

        //Delete Application
        deleteApplication(id) {
            this.isDeleteApplication = true;
            this.deleteID = id;
        },

        //Validate Delete Application
        async validateDeleteApplication() {
            this.resetData();
            this.isUpdateApplication = false;
            this.isDeletingApplication = true;
            this.deleteBtnMessage = "Deleting...";
            let newURL = baseUrl + "/api/applicant/delete/" + this.deleteID;
            const options = {
                method: "DELETE",
                url: newURL,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + token,
                },
            };

            await axios
                .request(options)
                .then((response) => {
                    this.fireSnackbar = true;
                    this.messageSnackbar =
                        "Deletion of application successful!";
                    console.log(response.data);
                })
                .catch((error) => {
                    this.fireSnackbar = true;
                    this.messageSnackbar =
                        "There is an issue deleting the information. Please try again";
                    console.error(error);
                });

            await this.getApplications();
            this.isDeleteApplication = false;
            this.isDeletingApplication = false;
            this.deleteBtnMessage = "Confirm Deletion of Application";
        },
        //Update Application
        async validateUpdateApplication() {
            this.isUpdatingApplication = true;
            this.updateBtnMessage = "Updating...";
            let newURL = baseUrl + "/api/applicant/update/" + this.updateID;
            const options = {
                method: "PUT",
                url: newURL,
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    Authorization: "Bearer " + token,
                },
                data: {
                    firstName: this.firstName,
                    lastName: this.lastName,
                    middleName: this.middleName,
                    nameExtension: this.nameExtension,
                    civilStatus: this.civilStatus,
                    birthdate: this.birthdate,
                    height: this.height,
                    gender: this.gender,
                    address: this.address,
                    contactNumber: this.contactNumber,
                    email: this.email,
                    currentPosition: this.currentPosition,
                    employmentStatus: this.employmentStatus,
                    yearsInCurrentPosition: this.yearsInCurrentPosition,
                    college: this.college,
                    workExperience: this.workExperience,
                    training: this.training,
                    positionTitle: this.positionTitle,
                    vacantOnPositions: this.vacantOnPositions,
                    placeOfAssignment: this.placeOfAssignment,
                    dateOfPublication: this.dateOfPublication,
                    positionEducation: this.positionEducation,
                    positionTraining: this.positionTraining,
                    positionExperience: this.positionExperience,
                    positionEligibility: this.positionEligibility,
                    remarks: this.remarks,
                    dateReceived: this.dateReceived,
                },
            };

            await axios
                .request(options)
                .then((response) => {
                    this.isUpdatingApplication = false;
                    this.updateBtnMessage = "Confirm Update Application";
                    this.fireSnackbar = true;
                    this.messageSnackbar =
                        "Updating applicant information successful!";
                    console.log(response.data);
                })
                .catch((error) => {
                    this.isUpdatingApplication = false;
                    this.updateBtnMessage = "Confirm Update Application";
                    this.fireSnackbar = true;
                    this.messageSnackbar =
                        "There is an error updating the applicant information. Please try again";
                    console.error(error);
                });

            await this.getApplications();
        },

        //Add Application
        async validateAddApplication() {
            this.isAddingApplication = true;
            this.addBtnMessage = "Adding...";
            let newURL = baseUrl + "/api/applicant/create";
            const options = {
                method: "POST",
                url: newURL,
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    Authorization: "Bearer " + token,
                },
                data: {
                    firstName: this.firstName,
                    lastName: this.lastName,
                    middleName: this.middleName,
                    nameExtension: this.nameExtension,
                    civilStatus: this.civilStatus,
                    birthdate: this.birthdate,
                    height: this.height,
                    gender: this.gender,
                    address: this.address,
                    contactNumber: this.contactNumber,
                    email: this.email,
                    currentPosition: this.currentPosition,
                    employmentStatus: this.employmentStatus,
                    yearsInCurrentPosition: this.yearsInCurrentPosition,
                    college: this.college,
                    workExperience: this.workExperience,
                    training: this.training,
                    positionTitle: this.positionTitle,
                    vacantOnPositions: this.vacantOnPositions,
                    placeOfAssignment: this.placeOfAssignment,
                    dateOfPublication: this.dateOfPublication,
                    positionEducation: this.positionEducation,
                    positionTraining: this.positionTraining,
                    positionExperience: this.positionExperience,
                    positionEligibility: this.positionEligibility,
                    dateReceived: this.dateReceived,
                    remarks: this.remarks,
                },
            };

            await axios
                .request(options)
                .then((response) => {
                    this.fireSnackbar = true;
                    this.messageSnackbar = "Adding of application success!";
                    this.resetData();
                    console.log(response.data);
                })
                .catch((error) => {
                    this.fireSnackbar = true;
                    this.messageSnackbar =
                        "There is an error procesing your request. Please try again";
                    console.error(error);
                });
            await this.getApplications();
            this.addBtnMessage = "Confirm Add Application";
            this.isAddingApplication = false;
        },

        //Get Applications
        async getApplications() {
            let newURL = baseUrl + "/api/applicant/search";
            const options = {
                method: "GET",
                url: newURL,
                params: {
                    perPage: "30",
                },
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + token,
                },
            };

            await axios
                .request(options)
                .then((response) => {
                    this.applications = response.data.data;
                    console.log(response.data);
                })
                .catch((error) => {
                    console.error(error);
                });
        },

        //Get Application using Search
        async getApplicationUsingSearch() {
            this.isSearching = true;
            this.btnSearch = "Searching...";
            let newURL = baseUrl + "/api/applicant/search";
            const options = {
                method: "GET",
                url: newURL,
                params: {
                    perPage: "30",
                    searchValue: this.searchValue,
                },
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + token,
                },
            };

            await axios
                .request(options)
                .then((response) => {
                    this.applications = response.data.data;
                    console.log(response.data);
                })
                .catch((error) => {
                    console.error(error);
                });

            this.isSearching = false;
            this.btnSearch = "Search";
        },

        //Validate Add Work Experience
        async validateAddWorkExperience() {
            this.formWorkExperience.dateFrom =
                this.formWorkExperience.dateFromYear +
                "-" +
                this.formWorkExperience.dateFromMonth;
            this.formWorkExperience.dateTo =
                this.formWorkExperience.dateToYear +
                "-" +
                this.formWorkExperience.dateToMonth;
            let newWorkExperience = {
                position: this.formWorkExperience.position,
                company: this.formWorkExperience.company,
                dateFrom: this.formWorkExperience.dateFrom,
                dateTo: this.formWorkExperience.dateTo,
            };
            this.workExperience.push(newWorkExperience);
            this.isAddWorkExperience = false;
            this.formWorkExperience.position = null;
            this.formWorkExperience.company = null;
            this.formWorkExperience.dateFrom = null;
            this.formWorkExperience.dateTo = null;
            this.formWorkExperience.dateFromYear = "2020";
            this.formWorkExperience.dateFromMonth = "01";
            this.formWorkExperience.dateToYear = "2021";
            this.formWorkExperience.dateToMonth = "02";
            console.log(this.workExperience);
        },

        //Delete Work Experience
        async deleteWorkExperience(itemId) {
            this.workExperience.splice(itemId, 1);
        },

        //Validate Add Trainings
        async validateAddTraining() {
            let newTraining = {
                title: this.formTraining.title,
                hours: this.formTraining.hours,
                year: this.formTraining.year,
            };
            this.training.push(newTraining);
            this.isAddTraining = false;
            this.formTraining.title = null;
            this.formTraining.hours = null;
            this.formTraining.year = null;
        },

        //Delete Training
        deleteTraining(itemId) {
            this.training.splice(itemId, 1);
        },

        //Add College
        async validateAddCollege() {
            let newCollege = {
                course: this.formCollege.course,
                school: this.formCollege.school,
                yearGraduated: this.formCollege.yearGraduated,
                units: this.formCollege.units,
            };
            this.college.push(newCollege);
            this.isAddCollege = false;
            this.formCollege.course = null;
            this.formCollege.school = null;
            this.formCollege.yearGraduated = "2020";
            this.formCollege.units = null;
        },

        //Delete College
        deleteCollege(itemId) {
            this.college.splice(itemId, 1);
        },

        //Get Parameters
        async getParameters() {
            this.param = null;
            let newURL = baseUrl + "/api/applicant/parameter";
            const options = {
                method: "GET",
                url: newURL,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + token,
                },
            };

            await axios
                .request(options)
                .then((response) => {
                    this.param = response.data;
                    console.log(response.data);
                })
                .catch((error) => {
                    console.error(error);
                });
        },

        //Print Application
        async printApplication() {
            let newURL = baseUrl + "/api/token/generate/";

            const options = {
                method: "POST",
                url: newURL,
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    Authorization: "Bearer " + token,
                },
                data: {
                    permission: "print applicant",
                    model_name: {
                        positionName: this.positionName,
                    },
                },
            };

            await axios
                .request(options)
                .then((response) => {
                    console.log(response.data);
                    let printToken = response.data.message;

                    //New Tab to generate report
                    let parentURL =
                        baseUrl + "/generate/report/8/single/am/" + printToken;
                    window.open(parentURL, "_blank");
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        //Reset Data
        async resetData() {
            (this.firstName = null),
                (this.lastName = null),
                (this.middleName = null),
                (this.nameExtension = null),
                (this.birthdate = "2020-01-01"),
                (this.height = 0),
                (this.gender = "MALE"),
                (this.address = null),
                (this.contactNumber = null),
                (this.civilStatus = null),
                (this.email = null),
                (this.currentPosition = null),
                (this.employmentStatus = null),
                (this.yearsInCurrentPosition = null),
                (this.college = []),
                (this.workExperience = []),
                (this.training = []),
                (this.positionTitle = null),
                (this.vacantOnPositions = 0),
                (this.placeOfAssignment = null),
                (this.dateOfPublication = "2020-01-01"),
                (this.positionEducation = null),
                (this.positionTraining = null),
                (this.positionExperience = null),
                (this.positionEligibility = null),
                (this.dateReceived = "2020-01-01");
        },
    },
    async beforeMount() {
        await this.resetData();
        await this.getParameters();
        await this.getApplications();
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
