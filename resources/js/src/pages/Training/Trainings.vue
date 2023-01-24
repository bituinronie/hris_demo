<template>
    <div>
        <div class="md-layout">
            <!--  My Trainings -->
            <div class="md-layout-item md-small-size-100 md-size-100">
                <md-card>
                    <md-card-header
                        class="md-card-header"
                        style="margin-bottom: 20px"
                    >
                        <h4 class="title">Manage Trainings</h4>
                    </md-card-header>
                    <!-- <md-card-content v-if="userAction === 'emp_selected' "> -->
                    <md-card-content>
                        <div class="md-layout">
                            <div
                                class="
                                    md-layout-item md-small-size-100 md-size-100
                                "
                            >
                                <md-button
                                    class="md-raised md-dense md-primary"
                                    @click="isAddTraining = true"
                                    v-if="
                                        $permissions.includes('write training')
                                    "
                                >
                                    Add Training
                                </md-button>

                                <md-button
                                    class="md-raised md-dense md-warning"
                                    style="color: black !important"
                                    v-if="
                                        $permissions.includes('print training')
                                    "
                                >
                                    Print Summary
                                </md-button>
                            </div>
                            <div class="md-layout-item md-size-100">
                                <md-table
                                    v-model="trainings"
                                    md-card
                                    md-sort="id"
                                    md-sort-order="asc"
                                >
                                    <md-table-toolbar>
                                        <div
                                            class="md-toolbar-section-start"
                                        ></div>
                                        <md-field
                                            class="md-toolbar-section-end"
                                        >
                                            <md-input
                                                placeholder="Search"
                                                v-model="searchValue"
                                                @keyup="
                                                    (e) => {
                                                        if (
                                                            e.target.value == ''
                                                        ) {
                                                            getTrainings(
                                                                `/api/training/search`
                                                            );
                                                        }
                                                    }
                                                "
                                            />
                                            <md-button
                                                class="md-primary md-dense"
                                                style="
                                                    margin-bottom: 10px !important;
                                                "
                                                @click="
                                                    getTrainings(
                                                        `/api/training/search`
                                                    )
                                                "
                                                :disabled="isSearchingTraining"
                                            >
                                                {{ btnSearchTraining }}
                                            </md-button>
                                        </md-field>
                                    </md-table-toolbar>
                                    <md-table-empty-state
                                        :md-description="`No Record`"
                                    >
                                    </md-table-empty-state>

                                    <md-table-row>
                                        <md-table-head></md-table-head>
                                        <md-table-head>Program</md-table-head>
                                        <md-table-head
                                            >Type of LD</md-table-head
                                        >
                                        <md-table-head
                                            >Sponsored by</md-table-head
                                        >
                                        <md-table-head
                                            >Conducted by</md-table-head
                                        >
                                        <md-table-head>Location</md-table-head>
                                        <md-table-head>Actions</md-table-head>
                                    </md-table-row>
                                    <template
                                        v-for="(trainingVal, i) in trainings"
                                    >
                                        <md-table-row :key="i + 'a'">
                                            <md-table-cell>
                                                <md-button
                                                    class="
                                                        md-icon-button
                                                        md-primary
                                                    "
                                                    @click="
                                                        trainingId =
                                                            trainingVal.id;
                                                        expandTable();
                                                    "
                                                >
                                                    <md-icon>{{
                                                        expandedTableId ==
                                                        trainingVal.id
                                                            ? "expand_more"
                                                            : "chevron_right"
                                                    }}</md-icon>
                                                </md-button>
                                            </md-table-cell>
                                            <md-table-cell>
                                                {{ trainingVal.program }}
                                            </md-table-cell>
                                            <md-table-cell>
                                                {{ trainingVal.type_of_ld }}
                                            </md-table-cell>
                                            <md-table-cell>
                                                {{ trainingVal.sponsored_by }}
                                            </md-table-cell>
                                            <md-table-cell>
                                                {{ trainingVal.conducted_by }}
                                            </md-table-cell>
                                            <md-table-cell>
                                                {{ trainingVal.location }}
                                            </md-table-cell>
                                            <md-table-cell>
                                                <md-button
                                                    v-if="
                                                        !trainingVal.isDeleted &&
                                                        $permissions.includes(
                                                            'write training'
                                                        )
                                                    "
                                                    class="md-dense md-warning"
                                                    style="
                                                        color: black !important;
                                                    "
                                                    @click="
                                                        isAddDate = true;
                                                        trainingId =
                                                            trainingVal.id;
                                                        resetDate();
                                                    "
                                                    >Add Date</md-button
                                                >
                                                <md-button
                                                    v-if="
                                                        !trainingVal.isDeleted &&
                                                        $permissions.includes(
                                                            'write training'
                                                        )
                                                    "
                                                    class="md-dense md-primary"
                                                    @click="
                                                        isEditTraining = true;
                                                        training = trainingVal;
                                                        trainingId =
                                                            trainingVal.id;
                                                    "
                                                    >Edit</md-button
                                                >
                                                <md-button
                                                    v-if="
                                                        !trainingVal.isDeleted &&
                                                        $permissions.includes(
                                                            'delete training'
                                                        )
                                                    "
                                                    class="md-dense md-danger"
                                                    @click="
                                                        isDeleteTraining = true;
                                                        trainingId =
                                                            trainingVal.id;
                                                    "
                                                    >Delete</md-button
                                                >
                                                <md-button
                                                    v-if="
                                                        trainingVal.isDeleted &&
                                                        $permissions.includes(
                                                            'restore training'
                                                        )
                                                    "
                                                    class="md-dense md-warning"
                                                    style="
                                                        color: black !important;
                                                    "
                                                    @click="
                                                        isRestoreTraining = true;
                                                        trainingId =
                                                            trainingVal.id;
                                                    "
                                                    >Restore</md-button
                                                >
                                            </md-table-cell>
                                        </md-table-row>
                                        <md-table-row
                                            :key="i + 'b'"
                                            v-if="
                                                expandedTableId ==
                                                trainingVal.id
                                            "
                                        >
                                            <md-table-cell
                                                colspan="7"
                                                style="
                                                    background-color: #eeeeee;
                                                "
                                            >
                                                <div class="md-layout">
                                                    <div
                                                        class="
                                                            md-layout-item
                                                            md-size-100
                                                        "
                                                    >
                                                        <p
                                                            style="
                                                                margin-bottom: 10px;
                                                            "
                                                        >
                                                            <strong
                                                                >DESCRIPTION:
                                                            </strong>
                                                        </p>
                                                        <br />
                                                        <p
                                                            v-if="
                                                                trainingVal.description
                                                            "
                                                            v-html="
                                                                trainingVal.description
                                                            "
                                                        ></p>
                                                        <span v-else>NONE</span>
                                                    </div>
                                                    <div
                                                        class="
                                                            md-layout-item
                                                            md-size-100
                                                        "
                                                        style="margin-top: 20px"
                                                    >
                                                        <md-table
                                                            class="md-dense"
                                                            md-card
                                                            v-model="dates"
                                                        >
                                                            <md-table-empty-state
                                                                :md-description="`No Record`"
                                                            >
                                                            </md-table-empty-state>
                                                            <md-table-row
                                                                slot="md-table-row"
                                                                slot-scope="{
                                                                    item,
                                                                }"
                                                            >
                                                                <md-table-cell
                                                                    md-label="Date"
                                                                >
                                                                    {{
                                                                        item.dateToDisplay
                                                                    }}
                                                                </md-table-cell>
                                                                <md-table-cell
                                                                    md-label="Number of Hours"
                                                                >
                                                                    {{
                                                                        item.number_of_hours
                                                                    }}
                                                                </md-table-cell>
                                                                <md-table-cell
                                                                    md-label="Employees Assigned"
                                                                >
                                                                    {{
                                                                        item.employeesAssignedCount
                                                                    }}
                                                                </md-table-cell>
                                                                <md-table-cell
                                                                    md-label="Actions"
                                                                >
                                                                    <md-button
                                                                        class="
                                                                            md-dense
                                                                            md-warning
                                                                        "
                                                                        style="
                                                                            color: black !important;
                                                                        "
                                                                        @click="
                                                                            trainingId =
                                                                                trainingVal.id;
                                                                            date =
                                                                                item;
                                                                            getEmployees(
                                                                                `/api/training/date/parameter/`
                                                                            );
                                                                            isEmployeeAssignment = true;
                                                                        "
                                                                        v-if="
                                                                            $permissions.includes(
                                                                                'write training'
                                                                            )
                                                                        "
                                                                        >Assign</md-button
                                                                    >
                                                                    <md-button
                                                                        class="
                                                                            md-dense
                                                                            md-primary
                                                                        "
                                                                        @click="
                                                                            trainingId =
                                                                                trainingVal.id;
                                                                            openEditDate(
                                                                                item
                                                                            );
                                                                        "
                                                                        v-if="
                                                                            $permissions.includes(
                                                                                'write training'
                                                                            )
                                                                        "
                                                                        >Edit</md-button
                                                                    >
                                                                    <md-button
                                                                        v-if="
                                                                            item.employeesAssignedCount >
                                                                                0 &&
                                                                            $permissions.includes(
                                                                                'search training'
                                                                            )
                                                                        "
                                                                        class="
                                                                            md-dense
                                                                            md-primary
                                                                        "
                                                                        @click="
                                                                            date =
                                                                                item;
                                                                            trainingId =
                                                                                trainingVal.id;
                                                                            getEmployeeTrainings();
                                                                            isEmployeeTrainings = true;
                                                                        "
                                                                        >View
                                                                        Employee
                                                                        Trainings</md-button
                                                                    >
                                                                    <md-button
                                                                        v-if="
                                                                            item.isOkToDelete &&
                                                                            $permissions.includes(
                                                                                'delete training'
                                                                            )
                                                                        "
                                                                        class="
                                                                            md-dense
                                                                            md-danger
                                                                        "
                                                                        @click="
                                                                            isDeleteDate = true;
                                                                            date =
                                                                                item;
                                                                            trainingId =
                                                                                trainingVal.id;
                                                                        "
                                                                        >Delete</md-button
                                                                    >
                                                                </md-table-cell>
                                                            </md-table-row>
                                                        </md-table>
                                                    </div>
                                                    <div
                                                        class="
                                                            md-layout-item
                                                            md-size-100
                                                            text-right
                                                        "
                                                        style="margin: 20px 0px"
                                                    >
                                                        <label
                                                            v-for="(
                                                                link, i
                                                            ) in dateLinks"
                                                            :key="i"
                                                        >
                                                            <md-button
                                                                class="
                                                                    button-paginate
                                                                    md-warning
                                                                "
                                                                @click="
                                                                    getDates(
                                                                        link.url
                                                                    )
                                                                "
                                                                :disabled="
                                                                    link.active ||
                                                                    link.url ===
                                                                        null
                                                                "
                                                            >
                                                                <label
                                                                    style="
                                                                        color: black !important;
                                                                    "
                                                                    v-html="
                                                                        link.label
                                                                    "
                                                                ></label>
                                                            </md-button>
                                                        </label>
                                                    </div>
                                                </div>
                                            </md-table-cell>
                                        </md-table-row>
                                    </template>
                                </md-table>
                            </div>
                            <div class="md-layout-item md-size-100 text-right">
                                <label v-for="(link, i) in links" :key="i">
                                    <md-button
                                        class="button-paginate md-warning"
                                        @click="getTrainings(link.url)"
                                        :disabled="
                                            link.active || link.url === null
                                        "
                                    >
                                        <label
                                            style="color: black !important"
                                            v-html="link.label"
                                        ></label>
                                    </md-button>
                                </label>
                            </div>
                        </div>
                    </md-card-content>
                </md-card>
            </div>
        </div>

        <!-- Add Training -->
        <DialogCard v-if="isAddTraining">
            <section slot="header">Add Training</section>
            <section slot="body" class="dCardBody">
                <form method="post" @submit.prevent="addTraining()">
                    <md-field>
                        <label>Program</label>
                        <md-input
                            v-model="training.program"
                            required
                        ></md-input>
                    </md-field>
                    <md-datepicker
                        md-placeholder="Enter date"
                        :md-immediately="true"
                        :md-model-type="String"
                        v-model="training.date_from"
                        required
                        ><label>Date From*</label></md-datepicker
                    >
                    <md-datepicker
                        :md-model-type="String"
                        :md-immediately="true"
                        md-placeholder="Enter date"
                        required
                        v-model="training.date_to"
                        ><label>Date To*</label></md-datepicker
                    >
                    <md-field>
                        <label>Number of Hours</label>
                        <md-input
                            v-model="training.number_of_hours"
                            required
                            type="number"
                        ></md-input>
                    </md-field>
                    <md-field>
                        <label>Type of LD</label>
                        <md-input
                            v-model="training.type_of_ld"
                            required
                        ></md-input>
                    </md-field>
                    <md-field>
                        <label>Sponsored By</label>
                        <md-input v-model="training.sponsored_by"></md-input>
                    </md-field>
                    <md-field>
                        <label>Conducted By</label>
                        <md-input v-model="training.conducted_by"></md-input>
                    </md-field>
                    <md-field>
                        <label for="obVenue">Location</label>
                        <md-select
                            v-model="training.location"
                            name="OB Venue"
                            id="obVenue"
                        >
                            <md-option value="LOCAL">LOCAL</md-option>
                            <md-option value="FOREIGN">FOREIGN</md-option>
                        </md-select>
                    </md-field>
                    <md-field>
                        <label>Description and Requirements</label>
                        <editor v-model="training.description" />
                    </md-field>

                    <md-dialog-actions>
                        <md-button
                            class="md-dense md-raised md-success"
                            type="submit"
                            :disabled="
                                training.program &&
                                training.date_to &&
                                training.date_from &&
                                training.number_of_hours &&
                                training.type_of_ld
                                    ? false
                                    : true
                            "
                        >
                            Save</md-button
                        >
                        <md-button
                            class="md-dense md-raised md-danger"
                            @click="
                                isAddTraining = false;
                                isEditTraining = false;
                            "
                        >
                            <!-- <md-icon>close</md-icon> -->
                            ✕ Cancel</md-button
                        >
                    </md-dialog-actions>
                </form>
            </section>
        </DialogCard>

        <!-- Edit Training -->
        <DialogCard v-if="isEditTraining">
            <section slot="header">Edit Training</section>
            <section slot="body" class="dCardBody">
                <form method="put" @submit.prevent="editTraining()">
                    <md-field>
                        <label>Program</label>
                        <md-input
                            v-model="training.program"
                            required
                        ></md-input>
                    </md-field>
                    <md-field>
                        <label>Type of LD</label>
                        <md-input
                            v-model="training.type_of_ld"
                            required
                        ></md-input>
                    </md-field>
                    <md-field>
                        <label>Sponsored By</label>
                        <md-input v-model="training.sponsored_by"></md-input>
                    </md-field>
                    <md-field>
                        <label>Conducted By</label>
                        <md-input v-model="training.conducted_by"></md-input>
                    </md-field>
                    <md-field>
                        <label>Location</label>
                        <md-select v-model="training.location">
                            <md-option value="LOCAL">LOCAL</md-option>
                            <md-option value="FOREIGN">FOREIGN</md-option>
                        </md-select>
                    </md-field>
                    <md-field>
                        <label>Description and Requirements</label>
                        <editor
                            v-model="training.description"
                            :modelValue="training.description"
                        />
                    </md-field>
                    <md-dialog-actions>
                        <md-button
                            class="md-dense md-raised md-success"
                            type="submit"
                            @click="editTraining()"
                            :disabled="
                                training.program && training.type_of_ld
                                    ? false
                                    : true
                            "
                        >
                            Save</md-button
                        >
                        <md-button
                            class="md-dense md-raised md-danger"
                            @click="
                                isAddTraining = false;
                                isEditTraining = false;
                            "
                        >
                            <!-- <md-icon>close</md-icon> -->
                            ✕ Cancel</md-button
                        >
                    </md-dialog-actions>
                </form>
            </section>
        </DialogCard>

        <!-- Add Date -->
        <DialogCard v-if="isAddDate">
            <section slot="header">Add Date for Training</section>
            <section slot="body" class="dCardBody">
                <form method="post" @submit.prevent="addDate()">
                    <md-datepicker
                        md-placeholder="Enter date"
                        :md-immediately="true"
                        :md-model-type="String"
                        v-model="date.date_from"
                        required
                        ><label>Date From*</label></md-datepicker
                    >
                    <md-datepicker
                        :md-model-type="String"
                        :md-immediately="true"
                        md-placeholder="Enter date"
                        required
                        v-model="date.date_to"
                        ><label>Date To*</label></md-datepicker
                    >
                    <md-field>
                        <label>Number of Hours</label>
                        <md-input
                            v-model="date.number_of_hours"
                            required
                            type="number"
                        ></md-input>
                    </md-field>
                    <md-dialog-actions>
                        <md-button
                            class="md-dense md-raised md-success"
                            type="submit"
                            :disabled="
                                date.date_from &&
                                date.date_to &&
                                date.number_of_hours
                                    ? false
                                    : true
                            "
                        >
                            Save</md-button
                        >
                        <md-button
                            class="md-dense md-raised md-danger"
                            @click="isAddDate = false"
                        >
                            ✕ Cancel</md-button
                        >
                    </md-dialog-actions>
                </form>
            </section>
        </DialogCard>

        <!-- Delete Training -->
        <DialogCard v-if="isDeleteTraining">
            <section slot="header">Delete Training?</section>
            <section slot="body">
                <form method="post" @submit.prevent="deleteTraining()">
                    <md-dialog-actions>
                        <md-button
                            class="md-dense md-raised md-success"
                            type="submit"
                        >
                            Delete
                        </md-button>
                        <md-button
                            class="md-dense md-raised md-warning"
                            style="color: black !important"
                            @click="isDeleteTraining = false"
                        >
                            No, I changed my mind</md-button
                        >
                    </md-dialog-actions>
                </form>
            </section>
        </DialogCard>

        <!-- Restore Training -->
        <DialogCard v-if="isRestoreTraining">
            <section slot="header">Restore Training?</section>
            <section slot="body">
                <form method="post" @submit.prevent="restoreTraining()">
                    <md-dialog-actions>
                        <md-button
                            class="md-dense md-raised md-success"
                            type="submit"
                        >
                            Restore
                        </md-button>
                        <md-button
                            class="md-dense md-raised md-warning"
                            style="color: black !important"
                            @click="isRestoreTraining = false"
                        >
                            No, I changed my mind</md-button
                        >
                    </md-dialog-actions>
                </form>
            </section>
        </DialogCard>

        <!-- Edit Date -->
        <DialogCard v-if="isEditDate">
            <section slot="header">Edit Date</section>
            <section slot="body" class="dCardBody">
                <form method="put" @submit.prevent="editDate()">
                    <md-datepicker
                        md-placeholder="Enter date"
                        :md-immediately="true"
                        :md-model-type="String"
                        v-model="updatedDate.updated_date_from"
                        required
                        ><label>Date From*</label></md-datepicker
                    >
                    <md-datepicker
                        :md-model-type="String"
                        :md-immediately="true"
                        md-placeholder="Enter date"
                        required
                        v-model="updatedDate.updated_date_to"
                        ><label>Date To*</label></md-datepicker
                    >
                    <md-field>
                        <label>Number of Hours</label>
                        <md-input
                            v-model="updatedDate.updated_number_of_hours"
                            required
                            type="number"
                        ></md-input>
                    </md-field>
                    <md-dialog-actions>
                        <md-button
                            class="md-dense md-raised md-success"
                            type="submit"
                            :disabled="
                                updatedDate.updated_date_from &&
                                updatedDate.updated_date_to &&
                                updatedDate.updated_number_of_hours
                                    ? false
                                    : true
                            "
                        >
                            Save</md-button
                        >
                        <md-button
                            class="md-dense md-raised md-danger"
                            @click="isEditDate = false"
                        >
                            ✕ Cancel</md-button
                        >
                    </md-dialog-actions>
                </form>
            </section>
        </DialogCard>

        <!-- Delete Date -->
        <DialogCard v-if="isDeleteDate">
            <section slot="header">Delete Date?</section>
            <section slot="body">
                <form method="post" @submit.prevent="deleteDate()">
                    <md-dialog-actions>
                        <md-button
                            class="md-dense md-raised md-success"
                            type="submit"
                        >
                            Delete
                        </md-button>
                        <md-button
                            class="md-dense md-raised md-warning"
                            style="color: black !important"
                            @click="isDeleteDate = false"
                        >
                            No, I changed my mind</md-button
                        >
                    </md-dialog-actions>
                </form>
            </section>
        </DialogCard>

        <!-- Employee Assignment -->
        <DialogCard v-if="isEmployeeAssignment">
            <section slot="header">Assign Employee</section>
            <section slot="body" class="dCardBody">
                <form method="post" @submit.prevent="assignEmployee()">
                    <md-card>
                        <md-card-content>
                            <div class="md-layout">
                                <div class="md-layout-item md-size-100">
                                    <md-table
                                        class="md-dense"
                                        v-model="filteredEmployees"
                                    >
                                        <md-table-toolbar>
                                            <div
                                                class="md-toolbar-section-start"
                                            ></div>
                                            <md-field
                                                class="md-toolbar-section-end"
                                            >
                                                <md-input
                                                    placeholder="Search"
                                                    v-model="
                                                        searchEmployeeValue
                                                    "
                                                    @keyup="
                                                        (e) => {
                                                            if (
                                                                e.target
                                                                    .value == ''
                                                            ) {
                                                                getEmployees(
                                                                    '/api/training/date/parameter/'
                                                                );
                                                            }
                                                        }
                                                    "
                                                />
                                                <md-button
                                                    class="md-primary md-dense"
                                                    style="
                                                        margin-bottom: 10px !important;
                                                    "
                                                    @click="
                                                        getEmployees(
                                                            '/api/training/date/parameter/'
                                                        )
                                                    "
                                                >
                                                    Search
                                                </md-button>
                                            </md-field>
                                        </md-table-toolbar>
                                        <!-- <md-table-toolbar>
                                        <md-field md-clearable class="md-toolbar-section-end">
                                        <md-input placeholder="Search" v-model="searchEmployeeValue" @input="searchEmployee" />
                                        </md-field>
                                    </md-table-toolbar> -->
                                        <md-table-empty-state
                                            :md-description="`No Record`"
                                        >
                                        </md-table-empty-state>
                                        <md-table-row>
                                            <md-table-head>
                                                <md-checkbox
                                                    style="
                                                        margin: 5px 0px 0px 5px;
                                                    "
                                                    v-model="selectAll"
                                                    @change="selectAllEmployees"
                                                ></md-checkbox>
                                                <!-- <md-button class="md-dense md-primary md-simple" @click="selectAllEmployees()">
                                                {{ this.filteredEmployees.every(val => this.selectedEmployees.includes(val.id)) ? 'Deselect All' : 'Select All' }}
                                            </md-button> -->
                                            </md-table-head>
                                            <md-table-head
                                                >Employee Number</md-table-head
                                            >
                                            <md-table-head>Name</md-table-head>
                                            <md-table-head
                                                >Date of Birth</md-table-head
                                            >
                                        </md-table-row>
                                        <md-table-row
                                            v-for="(
                                                item, i
                                            ) in filteredEmployees"
                                            :key="i"
                                            md-auto-select
                                        >
                                            <md-table-cell>
                                                <md-checkbox
                                                    v-model="selectedEmployees"
                                                    :value="item.id"
                                                ></md-checkbox>
                                            </md-table-cell>
                                            <md-table-cell>
                                                {{ item.employee_number }}
                                            </md-table-cell>
                                            <md-table-cell>
                                                {{ item.name }}
                                            </md-table-cell>
                                            <md-table-cell>
                                                {{ item.dateOfBirth }}
                                            </md-table-cell>
                                        </md-table-row>
                                    </md-table>
                                    <!-- <md-table class="md-dense" v-model="filteredEmployees" @md-selected="onSelect">
                                    <md-table-toolbar>
                                        <md-field md-clearable class="md-toolbar-section-end">
                                        <md-input placeholder="Search" v-model="searchEmployeeValue" @input="searchEmployee" />
                                        </md-field>
                                    </md-table-toolbar>
                                    <md-table-empty-state :md-description="`No Record`">
                                    </md-table-empty-state>
                                    <md-table-row slot="md-table-row" slot-scope="{ item }" md-selectable="multiple" md-auto-select :md-disabled="item.isTick">
                                            <md-table-cell md-label="">
                                               
                                            </md-table-cell>
                                            <md-table-cell md-label="Employee Number">
                                                {{ item.employee_number }}
                                            </md-table-cell>
                                            <md-table-cell md-label="Name">
                                                {{ item.name }}
                                            </md-table-cell>
                                            <md-table-cell md-label="Date of Birth">
                                                {{ item.dateOfBirth }}
                                            </md-table-cell>
                                    </md-table-row>
                                </md-table>    -->
                                </div>
                                <div
                                    class="
                                        md-layout-item md-size-100
                                        text-right
                                    "
                                >
                                    <label
                                        v-for="(link, i) in employeeLinks"
                                        :key="i"
                                    >
                                        <md-button
                                            class="button-paginate md-warning"
                                            @click="getEmployees(link.url)"
                                            :disabled="
                                                link.active || link.url === null
                                            "
                                        >
                                            <label
                                                style="color: black !important"
                                                v-html="link.label"
                                            ></label>
                                        </md-button>
                                    </label>
                                </div>
                            </div>
                        </md-card-content>
                    </md-card>
                    <md-dialog-actions>
                        <md-button
                            class="md-dense md-raised md-success"
                            type="submit"
                        >
                            Save</md-button
                        >
                        <md-button
                            class="md-dense md-raised md-danger"
                            @click="
                                isEmployeeAssignment = false;
                                searchEmployeeValue = null;
                            "
                        >
                            ✕ Cancel</md-button
                        >
                    </md-dialog-actions>
                </form>
            </section>
        </DialogCard>

        <!-- View Employees Training -->
        <DialogCard v-if="isEmployeeTrainings">
            <section slot="header">Employees Training</section>
            <section slot="body" class="dCardBody">
                <div class="md-layout">
                    <div class="md-layout-item md-size-100">
                        <md-table
                            md-card
                            class="md-dense"
                            v-model="filteredEmployeeTrainings"
                        >
                            <md-table-toolbar>
                                <div class="md-toolbar-section-start"></div>
                                <md-field class="md-toolbar-section-end">
                                    <md-input
                                        placeholder="Search"
                                        v-model="searchEmployeeTrainingValue"
                                        @keyup="
                                            (e) => {
                                                if (e.target.value == '') {
                                                    searchEmployeeTrainings();
                                                }
                                            }
                                        "
                                    />
                                    <md-button
                                        class="md-primary md-dense"
                                        style="margin-bottom: 10px !important"
                                        @click="searchEmployeeTrainings()"
                                    >
                                        Search
                                    </md-button>
                                </md-field>
                            </md-table-toolbar>
                            <md-table-empty-state :md-description="`No Record`">
                            </md-table-empty-state>
                            <md-table-row slot="md-table-row" slot-scope="{ item }">
                                    <md-table-cell md-label="Employee Number">
                                        {{ item.employee_number }}
                                    </md-table-cell>
                                    <md-table-cell md-label="Name">
                                        {{ item.name }}
                                    </md-table-cell>
                                    <md-table-cell md-label="Date of Birth">
                                        {{ item.dateOfBirth }}
                                    </md-table-cell>
                                    <md-table-cell md-label="Certificate of Training">
                                        <md-button
                                            v-if="item.certificateOfAppearance"
                                            class="md-dense md-primary"
                                            @click="viewImage(item.certificateOfAppearance)"
                                            >View</md-button
                                        >
                                        <div
                                            v-else
                                            style="text-align: center"
                                        >
                                            No attachment provided
                                        </div>
                                    </md-table-cell>
                                    <md-table-cell md-label="Post Training Report">
                                        <md-button
                                            v-if="item.postTrainingReport"
                                            class="md-dense md-primary"
                                            @click="viewImage(item.postTrainingReport)"
                                            >View</md-button
                                        >
                                        <div
                                            v-else
                                            style="text-align: center"
                                        >
                                            No attachment provided
                                        </div>
                                    </md-table-cell>
                            </md-table-row>
                        </md-table>
                    </div>
                </div>
                <md-dialog-actions>
                    <md-button
                        class="md-dense md-raised md-danger"
                        @click="
                            isEmployeeTrainings = false;
                            searchEmployeeTrainingValue = null;
                        "
                    >
                        ✕ Close</md-button
                    >
                </md-dialog-actions>
            </section>
        </DialogCard>

        <!-- Dialog Cards Here -->

        <md-snackbar
            :md-position="'center'"
            :md-duration="2000"
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
import axios from "axios";
import Editor from "../../components/Editor.vue";

let token = localStorage.getItem("token");
let baseUrl = localStorage.getItem("base_url");

const DialogCard = () =>
    import(
        /* webpackChunkName: "DialogCard" */ "../../components/Cards/DialogCard.vue"
    );

export default {
    components: {
        DialogCard,
        Editor,
    },
    data() {
        return {
            trainings: [],
            dates: [],
            employees: [],
            filteredEmployees: [],
            employeeTrainings: [],
            filteredEmployeeTrainings: [],
            selectedEmployees: [],
            training: {
                program: null,
                date_from: null,
                date_to: null,
                number_of_hours: null,
                type_of_ld: null,
                sponsored_by: null,
                conducted_by: null,
                location: null,
                description: null,
            },
            date: {
                date_from: null,
                date_to: null,
                number_of_hours: null,
            },
            updatedDate: {
                updated_date_from: null,
                updated_date_to: null,
                updated_number_of_hours: null,
            },

            postTrainingReport: null,
            certificateOfAppearance: null,

            // Snackkbar
            fireSnackbar: false,
            messageSnackbar: "",

            employeeTrainingId: null,
            trainingId: null,

            // dialogs
            isAddTraining: false,
            isAddDate: false,
            isEditTraining: false,
            isDeleteTraining: false,
            isRestoreTraining: false,

            isDeleteDate: false,
            isEditDate: false,
            isEmployeeAssignment: false,
            isEmployeeTrainings: false,

            linksOnTraining: null,
            searchValue: null,
            btnSearchTraining: "Search",
            isSearchingTraining: false,

            paginatedTrainings: [],
            links: null,
            dateLinks: null,
            employeeLinks: null,

            expandedTableId: null,

            selectAll: false,
            isSelectAllChanged: false,

            searchEmployeeValue: null,
            searchEmployeeTrainingValue: null,
        };
    },
    methods: {
        async getTrainings(url) {
            if (!url.startsWith("http")) {
                url = baseUrl + url;
            }
            const options = {
                method: "GET",
                url: url,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + token,
                },
                params: {
                    searchValue: this.searchValue,
                },
            };
            const response = await axios.request(options);
            this.links = response.data.links;
            this.trainings = response.data.data;
        },
        async getDates(url) {
            if (!url.startsWith("http")) {
                url = baseUrl + url + this.trainingId;
            }
            const options = {
                method: "GET",
                url: url,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + token,
                },
            };
            const response = await axios.request(options);
            this.dates = response.data.data;
            this.dateLinks = response.data.links;
        },
        async getEmployees(url) {
            this.checkboxEmployee = {};
            if (!url.startsWith("http")) {
                url = baseUrl + url + this.trainingId;
            }
            const options = {
                method: "GET",
                url: url,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + token,
                },
                params: {
                    date_from: this.date.date_from,
                    date_to: this.date.date_to,
                    number_of_hours: this.date.number_of_hours,
                    searchValue: this.searchEmployeeValue,
                },
            };
            const response = await axios.request(options);
            let employees = response.data.data;
            this.employees = employees;
            if (this.searchEmployeeValue || this.searchEmployeeValue == "") {
                this.selectedEmployees.concat(
                    employees
                        .filter((val) => val.isTick == true)
                        .map((val) => val.id)
                );
            } else {
                this.selectedEmployees = employees
                    .filter((val) => val.isTick == true)
                    .map((val) => val.id);
            }

            this.filteredEmployees = employees;
            this.employeeLinks = response.data.links;

            if (
                this.filteredEmployees.every((val) =>
                    this.selectedEmployees.includes(val.id)
                )
            ) {
                this.selectAll = true;
            }
        },
        async getEmployeeTrainings() {
            this.employeeTrainings = [];
            const options = {
                method: "GET",
                url: baseUrl + "/api/training/date/search/" + this.trainingId,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + token,
                },
                params: {
                    date_from: this.date.date_from,
                    date_to: this.date.date_to,
                    number_of_hours: this.date.number_of_hours,
                    searchValue: this.searchEmployeeTrainingValue,
                },
            };
            const response = await axios.request(options);
            this.employeeTrainings = response.data.employeesAssigned;
            this.filteredEmployeeTrainings = response.data.employeesAssigned;
        },
        async addTraining() {
            const options = {
                method: "POST",
                url: baseUrl + "/api/training/create",
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + token,
                },
                data: this.training,
            };
            await axios
                .request(options)
                .then(() => {
                    this.fireSnackbar = true;
                    this.messageSnackbar = "Training submitted!";
                })
                .catch((error) => {
                    console.log(error);
                    this.fireSnackbar = true;
                    this.messageSnackbar =
                        "There is an issue submitting the request. Please try again!";
                });
            this.isAddTraining = false;
            this.resetTraining();
            this.getTrainings(`/api/training/search`);
        },
        async addDate() {
            const options = {
                method: "POST",
                url: baseUrl + "/api/training/date/create/" + this.trainingId,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + token,
                },
                data: this.date,
            };
            await axios
                .request(options)
                .then(() => {
                    this.fireSnackbar = true;
                    this.messageSnackbar = "Training date submitted!";
                })
                .catch((error) => {
                    console.log(error);
                    this.fireSnackbar = true;
                    this.messageSnackbar =
                        "There is an issue submitting the request. Please try again!";
                });
            this.isAddDate = false;
            this.getTrainings(`/api/training/search`);
        },
        async editTraining() {
            const options = {
                method: "PUT",
                url: baseUrl + "/api/training/update/" + this.trainingId,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + token,
                },
                data: this.training,
            };
            await axios
                .request(options)
                .then(() => {
                    this.fireSnackbar = true;
                    this.messageSnackbar = "Training updated!";
                })
                .catch((error) => {
                    console.log(error);
                    this.fireSnackbar = true;
                    this.messageSnackbar =
                        "There is an issue submitting the request. Please try again!";
                });
            this.isEditTraining = false;
            this.resetTraining();
            this.getTrainings(`/api/training/search`);
        },
        async deleteTraining() {
            const options = {
                method: "DELETE",
                url: baseUrl + "/api/training/delete/" + this.trainingId,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + token,
                },
            };
            await axios
                .request(options)
                .then(() => {
                    this.fireSnackbar = true;
                    this.messageSnackbar = "Training deleted!";
                })
                .catch((error) => {
                    console.log(error);
                    this.fireSnackbar = true;
                    this.messageSnackbar =
                        "There is an issue submitting the request. Please try again!";
                });
            this.isDeleteTraining = false;
            this.getTrainings(`/api/training/search`);
        },
        async restoreTraining() {
            const options = {
                method: "POST",
                url: baseUrl + "/api/training/restore/" + this.trainingId,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + token,
                },
            };
            await axios
                .request(options)
                .then(() => {
                    this.fireSnackbar = true;
                    this.messageSnackbar = "Training restored!";
                })
                .catch((error) => {
                    console.log(error);
                    this.fireSnackbar = true;
                    this.messageSnackbar =
                        "There is an issue submitting the request. Please try again!";
                });
            this.isRestoreTraining = false;
            this.getTrainings(`/api/training/search`);
        },
        async getParameters() {
            const options = {
                method: "GET",
                url: baseUrl + "/api/training/parameter",
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + token,
                },
            };
            const response = await axios.request(options);
        },
        async editDate() {
            const options = {
                method: "PUT",
                url: baseUrl + "/api/training/date/update/" + this.trainingId,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + token,
                },
                data: {
                    date_from: this.date.date_from,
                    date_to: this.date.date_to,
                    number_of_hours: this.date.number_of_hours,
                    updated_date_from: this.updatedDate.updated_date_from,
                    updated_date_to: this.updatedDate.updated_date_to,
                    updated_number_of_hours:
                        this.updatedDate.updated_number_of_hours,
                },
            };
            await axios
                .request(options)
                .then(() => {
                    this.fireSnackbar = true;
                    this.messageSnackbar = "Date updated!";
                })
                .catch((error) => {
                    console.log(error);
                    this.fireSnackbar = true;
                    this.messageSnackbar =
                        "There is an issue submitting the request. Please try again!";
                });
            this.isEditDate = false;
            this.getDates(`/api/training/date/search/`);
        },
        async deleteDate() {
            const options = {
                method: "DELETE",
                url: baseUrl + "/api/training/date/delete/" + this.trainingId,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + token,
                },
                data: {
                    date_from: this.date.date_from,
                    date_to: this.date.date_to,
                    number_of_hours: this.date.number_of_hours,
                },
            };
            await axios
                .request(options)
                .then(() => {
                    this.fireSnackbar = true;
                    this.messageSnackbar = "Date deleted!";
                })
                .catch((error) => {
                    console.log(error);
                    this.fireSnackbar = true;
                    this.messageSnackbar =
                        "There is an issue submitting the request. Please try again!";
                });
            this.isDeleteDate = false;
            this.getDates(`/api/training/date/search/`);
        },
        async assignEmployee() {
            const options = {
                method: "POST",
                url: baseUrl + "/api/training/date/assign/" + this.trainingId,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + token,
                },
                data: {
                    employee_ids: this.selectedEmployees,
                    date_from: this.date.date_from,
                    date_to: this.date.date_to,
                    number_of_hours: this.date.number_of_hours,
                },
            };
            await axios
                .request(options)
                .then(() => {
                    this.fireSnackbar = true;
                    this.messageSnackbar = "Employee assigned!";
                })
                .catch((error) => {
                    console.log(error);
                    this.fireSnackbar = true;
                    this.messageSnackbar =
                        "There is an issue submitting the request. Please try again!";
                });
            this.isEmployeeAssignment = false;
            this.getDates(`/api/training/date/search/`);
        },
        viewImage(url) {
            if (url.startsWith("http://localhost")) {
                window.open(url.replace("http://localhost", baseUrl));
            } else {
                window.open(url);
            }
        },
        attachProof(id) {
            const data = new FormData();
            data.append("post_training_report", this.postTrainingReport);
            data.append(
                "certificate_of_appearance",
                this.certificateOfAppearance
            );
            const options = {
                method: "POST",
                url:
                    baseUrl +
                    "/api/training/portal/attach/" +
                    this.employeeTrainingId,
                params: {
                    // Add params
                },
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + token,
                    "Content-Type": "multipart/form-data",
                },
                data: data,
            };
            axios
                .request(options)
                .then((res) => {
                    console.log(res);
                    this.fireSnackbar = true;
                    this.messageSnackbar = "Attachment proof updated!";
                })
                .catch((err) => {
                    this.fireSnackbar = true;
                    this.messageSnackbar =
                        "An error occured. Please try again.";
                });
            this.isUpdateAttachment = false;
        },
        resetTraining() {
            this.training = {
                program: null,
                date_from: null,
                date_to: null,
                number_of_hours: null,
                type_of_ld: null,
                sponsored_by: null,
                conducted_by: null,
                location: null,
                description: null,
            };
        },
        resetDate() {
            this.date = {
                date_from: null,
                date_to: null,
                number_of_hours: null,
            };
        },
        expandTable() {
            this.dates = [];
            if (this.expandedTableId == this.trainingId) {
                this.expandedTableId = null;
            } else {
                this.getDates(`/api/training/date/search/`);
                this.expandedTableId = this.trainingId;
            }
        },
        openEditDate(val) {
            this.isEditDate = true;
            this.date = val;
            this.updatedDate = {
                updated_date_from: val.date_from,
                updated_date_to: val.date_to,
                updated_number_of_hours: val.number_of_hours,
            };
        },
        searchEmployeeTrainings() {
            let str = this.searchEmployeeTrainingValue;
            let items = this.employeeTrainings;
            if (str.length > 0) {
                this.filteredEmployeeTrainings = items.filter(
                    (item) =>
                        item.name.toLowerCase().includes(str.toLowerCase()) ||
                        item.employee_number
                            .toLowerCase()
                            .includes(str.toLowerCase())
                );
            } else {
                this.filteredEmployeeTrainings = items;
            }
        },
        selectAllEmployees(e) {
            if (e) {
                // select all employees
                this.selectedEmployees = this.filteredEmployees.map(
                    (val) => val.id
                );
            } else {
                // deselect all employees
                this.filteredEmployees.map((val) => {
                    if (this.selectedEmployees.includes(val.id)) {
                        this.selectedEmployees = this.selectedEmployees.filter(
                            (x) => x != val.id
                        );
                    }
                });
            }
        },
    },
    mounted() {
        this.getTrainings(`/api/training/search`);
    },
    watch: {
        filteredEmployees(arr) {
            // select all state
            if (arr.every((val) => this.selectedEmployees.includes(val.id))) {
                this.selectAll = true;
            } else {
                this.selectAll = false;
            }
        },
        selectedEmployees(arr) {
            if (this.filteredEmployees.every((val) => arr.includes(val.id))) {
                this.selectAll = true;
            } else {
                this.selectAll = false;
            }
        },
    },
};
</script>
<style>
@import url("https://fonts.googleapis.com/css?family=Material+Icons");
.md-card-header {
    background-color: #042278 !important;
}
.dob {
    margin-top: -20px;
}
.dCardBody {
    min-width: 640px !important;
}
.addChild {
    background-color: #495057;
    border-color: #495057;
    color: white !important;
}
.md-table-sortable-icon {
    display: none !important;
}
.md-table-cell:last-child .md-table-cell-container {
    text-align: left !important;
}

.tbody-scroll tbody {
    height: 300px;
    overflow: scroll;
    display: block;
}
</style>
