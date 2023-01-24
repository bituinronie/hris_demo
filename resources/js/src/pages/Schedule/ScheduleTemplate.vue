<template>
    <div>
        <DialogCard v-if="!isAuthenticated">
            <section slot="body">
                Oops. Session expired. Please relogin.
                <md-dialog-actions>
                    <md-button
                        class="md-primary md-dense md-raised"
                        @click="logOut"
                        >Confirm</md-button
                    >
                </md-dialog-actions>
            </section>
        </DialogCard>
        <md-card v-if="$permissions.includes('search schedule')">
            <md-card-header class="md-card-header">
                <h4 class="title">Schedule Templates</h4>
                <!-- <p class="category">Complete the employee's profile</p> -->
            </md-card-header>
            <md-card-content>
                <div class="md-layout">
                    <div class="md-layout-item md-small-size-100 md-size-100">
                        <md-button
                            @click="addSchedule"
                            class="md-dense md-raised"
                            v-if="$permissions.includes('write schedule')"
                        >
                            Add Template</md-button
                        >
                    </div>
                    <!-- <div class="md-layout-item md-size-100">Regular Schedule</div> -->
                    <div class="md-layout-item md-size-100">
                        <md-table
                            v-model="schedule"
                            md-sort="reference_date"
                            md-sort-order="asc"
                        >
                            <md-table-toolbar>
                                <div class="md-toolbar-section-start">
                                    <h1 class="md-title">Regular Schedule</h1>
                                </div>
                                <md-field class="md-toolbar-section-end">
                                    <md-input
                                        placeholder="Search by Code Title..."
                                        v-model="searchValueOnSchedule"
                                    />
                                    <md-button
                                        class="md-primary md-dense"
                                        style="margin-bottom: 10px !important"
                                        @click="searchSchedule()"
                                        :disabled="isSearchingSchedule"
                                    >
                                        {{ btnSearchSchedule }}
                                    </md-button>
                                </md-field>
                            </md-table-toolbar>
                            <md-table-empty-state
                                md-label="No Template found. Please try again"
                            >
                            </md-table-empty-state>
                            <md-table-row
                                slot="md-table-row"
                                slot-scope="{ item }"
                            >
                                <md-table-cell
                                    md-label="Code"
                                    md-sort-by="code"
                                    >{{ item.code }}</md-table-cell
                                >
                                <md-table-cell
                                    md-label="Description"
                                    md-sort-by="description"
                                    >{{ item.description }}</md-table-cell
                                >
                                <md-table-cell md-label="Monday">
                                    <label v-if="item.mon_time_in != null">
                                        {{ item.mon_time_in }}<br />
                                        {{ item.mon_lunch_out }}<br />
                                        {{ item.mon_lunch_in }}<br />
                                        {{ item.mon_time_out }}<br />
                                    </label>
                                    <label v-else>DAY OFF</label>
                                </md-table-cell>
                                <md-table-cell md-label="Tuesday">
                                    <label v-if="item.tue_time_in != null">
                                        {{ item.tue_time_in }}<br />
                                        {{ item.tue_lunch_out }}<br />
                                        {{ item.tue_lunch_in }}<br />
                                        {{ item.tue_time_out }}<br />
                                    </label>
                                    <label v-else>DAY OFF</label>
                                </md-table-cell>
                                <md-table-cell md-label="Wednesday">
                                    <label v-if="item.wed_time_in != null">
                                        {{ item.wed_time_in }}<br />
                                        {{ item.wed_lunch_out }}<br />
                                        {{ item.wed_lunch_in }}<br />
                                        {{ item.wed_time_out }}<br />
                                    </label>
                                    <label v-else>DAY OFF</label>
                                </md-table-cell>
                                <md-table-cell md-label="Thursday">
                                    <label v-if="item.thu_time_in != null">
                                        {{ item.thu_time_in }}<br />
                                        {{ item.thu_lunch_out }}<br />
                                        {{ item.thu_lunch_in }}<br />
                                        {{ item.thu_time_out }}<br />
                                    </label>
                                    <label v-else>DAY OFF</label>
                                </md-table-cell>
                                <md-table-cell md-label="Friday">
                                    <label v-if="item.fri_time_in != null">
                                        {{ item.fri_time_in }}<br />
                                        {{ item.fri_lunch_out }}<br />
                                        {{ item.fri_lunch_in }}<br />
                                        {{ item.fri_time_out }}<br />
                                    </label>
                                    <label v-else>DAY OFF</label>
                                </md-table-cell>
                                <md-table-cell md-label="Saturday">
                                    <label v-if="item.sat_time_in != null">
                                        {{ item.sat_time_in }}<br />
                                        {{ item.sat_lunch_out }}<br />
                                        {{ item.sat_lunch_in }}<br />
                                        {{ item.sat_time_out }}<br />
                                    </label>
                                    <label v-else>DAY OFF</label>
                                </md-table-cell>
                                <md-table-cell md-label="Sunday">
                                    <label v-if="item.sun_time_in != null">
                                        {{ item.sun_time_in }}<br />
                                        {{ item.sun_lunch_out }}<br />
                                        {{ item.sun_lunch_in }}<br />
                                        {{ item.sun_time_out }}<br />
                                    </label>
                                    <label v-else>DAY OFF</label>
                                </md-table-cell>
                                <md-table-cell md-label="Flexi Schedule">
                                    {{ item.flexi_from }}<br />
                                    {{ item.flexi_to }}<br />
                                </md-table-cell>

                                <md-table-cell
                                    md-label="Actions"
                                    md-sort-by="actions"
                                >
                                    <md-button
                                        class="md-raised md-dense md-primary"
                                        @click="editTemplate(item.id)"
                                        :disabled="item.isDeleted"
                                        v-if="
                                            $permissions.includes(
                                                'write schedule'
                                            )
                                        "
                                    >
                                        ✎
                                        <md-tooltip md-direction="top"
                                            >Edit this record.</md-tooltip
                                        >
                                    </md-button>
                                    <md-button
                                        class="md-raised md-dense md-danger"
                                        @click="deleteTemplate(item.id)"
                                        :disabled="item.isDeleted"
                                        v-if="
                                            $permissions.includes(
                                                'delete schedule'
                                            )
                                        "
                                    >
                                        ⌫
                                        <md-tooltip md-direction="top"
                                            >Delete this record.</md-tooltip
                                        >
                                    </md-button>
                                    <md-button
                                        class="md-dense md-warning"
                                        :disabled="!item.isDeleted"
                                        @click="restoreTemplate(item.id)"
                                        v-if="
                                            $permissions.includes(
                                                'restore schedule'
                                            )
                                        "
                                    >
                                        <label style="color: black !important"
                                            >⟳</label
                                        >
                                        <!-- Restore -->
                                        <md-tooltip md-direction="top"
                                            >Restore this record</md-tooltip
                                        >
                                    </md-button>
                                </md-table-cell>
                            </md-table-row>
                        </md-table>
                    </div>
                    <div class="md-layout-item md-size-100 text-right">
                        <label v-for="l in linksOnSchedule" :key="l.label">
                            <md-button
                                class="button-paginate md-warning"
                                @click="getScheduleUsingLink(l.url)"
                                :disabled="l.active || l.url === null"
                            >
                                <label
                                    style="color: black !important"
                                    v-html="l.label"
                                ></label>
                            </md-button>
                        </label>
                    </div>

                    <div
                        class="md-layout-item md-size-100"
                        style="margin-top: 5%"
                    >
                        <!-- Special Schedule -->
                    </div>
                    <div class="md-layout-item md-size-100">
                        <md-table
                            v-model="special_schedule"
                            md-sort="reference_date"
                            md-sort-order="asc"
                        >
                            <md-table-toolbar>
                                <div class="md-toolbar-section-start">
                                    <h1 class="md-title">Special Schedule</h1>
                                </div>

                                <md-field class="md-toolbar-section-end">
                                    <md-input
                                        placeholder="Search by Code Title..."
                                        v-model="searchValue"
                                    />
                                    <md-button
                                        class="md-primary md-dense"
                                        style="margin-bottom: 10px !important"
                                        @click="searchSpecialSchedule()"
                                        :disabled="isSearching"
                                    >
                                        {{ btnSearch }}
                                    </md-button>
                                </md-field>
                            </md-table-toolbar>
                            <md-table-empty-state
                                md-label="No Template found. Please try again"
                            >
                            </md-table-empty-state>

                            <md-table-row
                                slot="md-table-row"
                                slot-scope="{ item }"
                            >
                                <md-table-cell
                                    md-label="Code"
                                    md-sort-by="code"
                                    >{{ item.code }}</md-table-cell
                                >
                                <md-table-cell
                                    md-label="Description"
                                    md-sort-by="description"
                                    >{{ item.description }}</md-table-cell
                                >

                                <md-table-cell
                                    md-label="Actions"
                                    md-sort-by="actions"
                                >
                                    <md-button
                                        class="md-raised md-dense md-primary"
                                        @click="
                                            editSpecialTemplate(
                                                item,
                                                item.id,
                                                item.ref_date,
                                                item.code,
                                                item.description
                                            )
                                        "
                                        :disabled="item.isDeleted"
                                        v-if="
                                            $permissions.includes(
                                                'write schedule'
                                            )
                                        "
                                    >
                                        ✎
                                        <md-tooltip md-direction="top"
                                            >View / Edit this
                                            record.</md-tooltip
                                        >
                                    </md-button>
                                    <md-button
                                        class="md-raised md-dense md-danger"
                                        @click="deleteSpecialTemplate(item.id)"
                                        :disabled="item.isDeleted"
                                        v-if="
                                            $permissions.includes(
                                                'delete schedule'
                                            )
                                        "
                                    >
                                        ⌫
                                        <md-tooltip md-direction="top"
                                            >Delete this record.</md-tooltip
                                        >
                                    </md-button>
                                    <md-button
                                        class="md-dense md-warning"
                                        :disabled="!item.isDeleted"
                                        @click="restoreSpecialTemplate(item.id)"
                                        v-if="
                                            $permissions.includes(
                                                'restore schedule'
                                            )
                                        "
                                    >
                                        <label style="color: black !important"
                                            >⟳</label
                                        >
                                        <!-- Restore -->
                                        <md-tooltip md-direction="top"
                                            >Restore this record</md-tooltip
                                        >
                                    </md-button>
                                    <!-- <md-button
                  class="md-raised md-dense md-danger"
                  @click="deleteTemplate(item.id)"
                  :disabled="item.isDeleted"
                >
                  ⌫
                  <md-tooltip md-direction="top"
                    >Delete this record.</md-tooltip
                  >
                </md-button>
                <md-button
                  class="md-dense md-warning"
                  :disabled="!item.isDeleted"
                  @click="restoreTemplate(item.id)"
                >
                  <label style="color: black !important">⟳</label>
                  <md-tooltip md-direction="top"
                    >Restore this record</md-tooltip
                  >
                </md-button> -->
                                </md-table-cell>
                            </md-table-row>
                        </md-table>
                    </div>

                    <div class="md-layout-item md-size-100 text-right">
                        <label v-for="l in links" :key="l.label">
                            <md-button
                                class="button-paginate md-warning"
                                @click="getSpecialScheduleUsingLink(l.url)"
                                :disabled="l.active || l.url === null"
                            >
                                <label
                                    style="color: black !important"
                                    v-html="l.label"
                                ></label>
                            </md-button>
                        </label>
                    </div>
                </div>
            </md-card-content>
            <DialogCard v-if="isAddSchedule">
                <section slot="header">
                    <md-field>
                        <label>Select Type</label>
                        <md-select v-model="schedule_type">
                            <md-option :value="'regular'">Regular</md-option>
                            <md-option :value="'special'">Special</md-option>
                        </md-select>
                    </md-field>
                    <span v-if="schedule_type === 'regular'">
                        Add Template for Regular Schedule <br /><i
                            >Time Format: Military Time (ex. 17:00:00)</i
                        >
                    </span>
                    <span v-else>
                        Add Template for Special Schedule <br /><i
                            >Time Format: Military Time (ex. 17:00:00)</i
                        >
                    </span>
                </section>
                <section slot="body">
                    <form
                        method="post"
                        @submit.prevent="validateAddTemplate"
                        v-if="schedule_type === 'regular'"
                    >
                        <md-field style="margin-top: 20px !important">
                            <label>Code</label>
                            <md-input v-model="code" required></md-input>
                        </md-field>
                        <md-field>
                            <label>Description</label>
                            <md-input v-model="description" required></md-input>
                        </md-field>
                        <md-checkbox v-model="is_flexi"
                            >Flexi Time
                        </md-checkbox>
                        <md-field v-if="is_flexi">
                            <label>Flexi From</label>
                            <md-input
                                v-model="flexi_from"
                                required
                                maxlength="8"
                                minlength="8"
                            ></md-input>
                        </md-field>
                        <md-field v-if="is_flexi">
                            <label>Flexi To</label>
                            <md-input
                                v-model="flexi_to"
                                required
                                maxlength="8"
                                minlength="8"
                            ></md-input>
                        </md-field>

                        <h5>Monday</h5>
                        <div class="md-layout size-100">
                            <div class="md-layout-item size-50">
                                <md-field>
                                    <label>Time in</label>
                                    <md-input
                                        v-model="mon_time_in"
                                        maxlength="8"
                                    ></md-input>
                                </md-field>
                            </div>

                            <div class="md-layout-item md-size-50">
                                <md-field>
                                    <label>Lunch Out</label>
                                    <md-input
                                        v-model="mon_lunch_out"
                                        maxlength="8"
                                    ></md-input>
                                </md-field>
                            </div>

                            <div class="md-layout-item md-size-50">
                                <md-field>
                                    <label>Lunch In</label>
                                    <md-input
                                        v-model="mon_lunch_in"
                                        maxlength="8"
                                    ></md-input>
                                </md-field>
                            </div>
                            <div class="md-layout-item md-size-50">
                                <md-field>
                                    <label>Time Out</label>
                                    <md-input
                                        v-model="mon_time_out"
                                        maxlength="8"
                                    ></md-input>
                                </md-field>
                            </div>
                        </div>

                        <h5>Tuesday</h5>
                        <div class="md-layout size-100">
                            <div class="md-layout-item size-50">
                                <md-field>
                                    <label>Time in</label>
                                    <md-input
                                        v-model="tue_time_in"
                                        maxlength="8"
                                    ></md-input>
                                </md-field>
                            </div>

                            <div class="md-layout-item md-size-50">
                                <md-field>
                                    <label>Lunch Out</label>
                                    <md-input
                                        v-model="tue_lunch_out"
                                        maxlength="8"
                                    ></md-input>
                                </md-field>
                            </div>

                            <div class="md-layout-item md-size-50">
                                <md-field>
                                    <label>Lunch In</label>
                                    <md-input
                                        v-model="tue_lunch_in"
                                        maxlength="8"
                                    ></md-input>
                                </md-field>
                            </div>
                            <div class="md-layout-item md-size-50">
                                <md-field>
                                    <label>Time Out</label>
                                    <md-input
                                        v-model="tue_time_out"
                                        maxlength="8"
                                    ></md-input>
                                </md-field>
                            </div>
                        </div>

                        <h5>Wednesday</h5>
                        <div class="md-layout size-100">
                            <div class="md-layout-item size-50">
                                <md-field>
                                    <label>Time in</label>
                                    <md-input
                                        v-model="wed_time_in"
                                        maxlength="8"
                                    ></md-input>
                                </md-field>
                            </div>

                            <div class="md-layout-item md-size-50">
                                <md-field>
                                    <label>Lunch Out</label>
                                    <md-input
                                        v-model="wed_lunch_out"
                                        maxlength="8"
                                    ></md-input>
                                </md-field>
                            </div>

                            <div class="md-layout-item md-size-50">
                                <md-field>
                                    <label>Lunch In</label>
                                    <md-input
                                        v-model="wed_lunch_in"
                                        maxlength="8"
                                    ></md-input>
                                </md-field>
                            </div>
                            <div class="md-layout-item md-size-50">
                                <md-field>
                                    <label>Time Out</label>
                                    <md-input
                                        v-model="wed_time_out"
                                        maxlength="8"
                                    ></md-input>
                                </md-field>
                            </div>
                        </div>

                        <h5>Thursday</h5>
                        <div class="md-layout size-100">
                            <div class="md-layout-item size-50">
                                <md-field>
                                    <label>Time in</label>
                                    <md-input
                                        v-model="thu_time_in"
                                        maxlength="8"
                                    ></md-input>
                                </md-field>
                            </div>

                            <div class="md-layout-item md-size-50">
                                <md-field>
                                    <label>Lunch Out</label>
                                    <md-input
                                        v-model="thu_lunch_out"
                                        maxlength="8"
                                    ></md-input>
                                </md-field>
                            </div>

                            <div class="md-layout-item md-size-50">
                                <md-field>
                                    <label>Lunch In</label>
                                    <md-input
                                        v-model="thu_lunch_in"
                                        maxlength="8"
                                    ></md-input>
                                </md-field>
                            </div>
                            <div class="md-layout-item md-size-50">
                                <md-field>
                                    <label>Time Out</label>
                                    <md-input
                                        v-model="thu_time_out"
                                        maxlength="8"
                                    ></md-input>
                                </md-field>
                            </div>
                        </div>

                        <h5>Friday</h5>
                        <div class="md-layout size-100">
                            <div class="md-layout-item size-50">
                                <md-field>
                                    <label>Time in</label>
                                    <md-input
                                        v-model="fri_time_in"
                                        maxlength="8"
                                    ></md-input>
                                </md-field>
                            </div>

                            <div class="md-layout-item md-size-50">
                                <md-field>
                                    <label>Lunch Out</label>
                                    <md-input
                                        v-model="fri_lunch_out"
                                        maxlength="8"
                                    ></md-input>
                                </md-field>
                            </div>

                            <div class="md-layout-item md-size-50">
                                <md-field>
                                    <label>Lunch In</label>
                                    <md-input
                                        v-model="fri_lunch_in"
                                        maxlength="8"
                                    ></md-input>
                                </md-field>
                            </div>
                            <div class="md-layout-item md-size-50">
                                <md-field>
                                    <label>Time Out</label>
                                    <md-input
                                        v-model="fri_time_out"
                                        maxlength="8"
                                    ></md-input>
                                </md-field>
                            </div>
                        </div>

                        <h5>Saturday</h5>
                        <div class="md-layout size-100">
                            <div class="md-layout-item size-50">
                                <md-field>
                                    <label>Time in</label>
                                    <md-input
                                        v-model="sat_time_in"
                                        maxlength="8"
                                    ></md-input>
                                </md-field>
                            </div>

                            <div class="md-layout-item md-size-50">
                                <md-field>
                                    <label>Lunch Out</label>
                                    <md-input
                                        v-model="sat_lunch_out"
                                        maxlength="8"
                                    ></md-input>
                                </md-field>
                            </div>

                            <div class="md-layout-item md-size-50">
                                <md-field>
                                    <label>Lunch In</label>
                                    <md-input
                                        v-model="sat_lunch_in"
                                        maxlength="8"
                                    ></md-input>
                                </md-field>
                            </div>
                            <div class="md-layout-item md-size-50">
                                <md-field>
                                    <label>Time Out</label>
                                    <md-input
                                        v-model="sat_time_out"
                                        maxlength="8"
                                    ></md-input>
                                </md-field>
                            </div>
                        </div>

                        <h5>Sunday</h5>
                        <div class="md-layout size-100">
                            <div class="md-layout-item size-50">
                                <md-field>
                                    <label>Time in</label>
                                    <md-input
                                        v-model="sun_time_in"
                                        maxlength="8"
                                    ></md-input>
                                </md-field>
                            </div>

                            <div class="md-layout-item md-size-50">
                                <md-field>
                                    <label>Lunch Out</label>
                                    <md-input
                                        v-model="sun_lunch_out"
                                        maxlength="8"
                                    ></md-input>
                                </md-field>
                            </div>

                            <div class="md-layout-item md-size-50">
                                <md-field>
                                    <label>Lunch In</label>
                                    <md-input
                                        v-model="sun_lunch_in"
                                        maxlength="8"
                                    ></md-input>
                                </md-field>
                            </div>
                            <div class="md-layout-item md-size-50">
                                <md-field>
                                    <label>Time Out</label>
                                    <md-input
                                        v-model="sun_time_out"
                                        maxlength="8"
                                    ></md-input>
                                </md-field>
                            </div>
                        </div>

                        <md-dialog-actions>
                            <md-button
                                v-if="!isEdit"
                                class="md-dense md-primary"
                                type="submit"
                                :disabled="isAdding"
                            >
                                {{ msgButton }}
                            </md-button>

                            <md-button
                                v-else
                                class="md-dense md-primary"
                                @click="updateTemplate"
                                :disabled="isAdding"
                            >
                                {{ msgButton }}
                            </md-button>
                            <md-button
                                class="md-dense md-danger"
                                @click="addSchedule"
                            >
                                <!-- <md-icon>close</md-icon> -->
                                ✕ Close</md-button
                            >
                        </md-dialog-actions>
                    </form>
                    <form
                        method="post"
                        @submit.prevent="validateAddSpecialTemplate"
                        v-else
                    >
                        <md-field style="margin-top: 20px !important">
                            <label>Code</label>
                            <md-input v-model="code" required></md-input>
                        </md-field>
                        <md-field>
                            <label>Description</label>
                            <md-input v-model="description" required></md-input>
                        </md-field>
                        <md-field>
                            <label>Effective Year</label>
                            <md-input
                                v-model="effective_year"
                                maxlength="4"
                            ></md-input>
                        </md-field>
                        <md-field>
                            <label>Effective Month</label>
                            <md-select
                                v-model="effecttive_month"
                                @md-selected="getMonthAndYear"
                            >
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
                        <span
                            v-for="(day, index) in special_schedule_data"
                            :key="index"
                        >
                            <br />
                            <label
                                ><i
                                    ><b>{{ index }}</b></i
                                ></label
                            >
                            <md-field>
                                <label>Time in</label>
                                <md-input v-model="day.time_in"></md-input>
                            </md-field>
                            <md-field>
                                <label>Lunch Out</label>
                                <md-input v-model="day.lunch_out"></md-input>
                            </md-field>
                            <md-field>
                                <label>Lunch In</label>
                                <md-input v-model="day.lunch_in"></md-input>
                            </md-field>
                            <md-field>
                                <label>Time Out</label>
                                <md-input v-model="day.time_out"></md-input>
                            </md-field>
                        </span>
                        <md-dialog-actions>
                            <md-button
                                v-if="!isEdit"
                                class="md-dense md-primary"
                                type="submit"
                                :disabled="isAdding"
                            >
                                {{ msgButton }}
                            </md-button>

                            <md-button
                                v-else
                                class="md-dense md-primary"
                                @click="updateSpecialTemplate"
                                :disabled="isAdding"
                            >
                                {{ msgButton }}
                            </md-button>
                            <md-button
                                class="md-dense md-danger"
                                @click="addSchedule"
                            >
                                <!-- <md-icon>close</md-icon> -->
                                ✕ Close</md-button
                            >
                        </md-dialog-actions>
                    </form>
                </section>
            </DialogCard>
            <!-- Edit Special Schedule Information -->
            <DialogCard v-if="isEditSpecialSchedule">
                <section slot="header">Edit / View Special Schedule</section>
                <section slot="body">
                    <md-field style="margin-top: 20px !important">
                        <label>Code</label>
                        <md-input v-model="code" required></md-input>
                    </md-field>
                    <md-field>
                        <label>Description</label>
                        <md-input v-model="description" required></md-input>
                    </md-field>
                    <span
                        v-for="(day, index) in special_schedule_data"
                        :key="index"
                    >
                        <br />
                        <label
                            ><i
                                ><b>{{ index }}</b></i
                            ></label
                        >
                        <md-field>
                            <label>Time in</label>
                            <md-input v-model="day.time_in"></md-input>
                        </md-field>
                        <md-field>
                            <label>Lunch Out</label>
                            <md-input v-model="day.lunch_out"></md-input>
                        </md-field>
                        <md-field>
                            <label>Lunch In</label>
                            <md-input v-model="day.lunch_in"></md-input>
                        </md-field>
                        <md-field>
                            <label>Time Out</label>
                            <md-input v-model="day.time_out"></md-input>
                        </md-field>
                    </span>
                    <md-dialog-actions>
                        <md-button
                            @click="updateSpecialSchedule"
                            class="md-dense md-primary"
                            type="submit"
                            :disabled="isUpdatingSchedule"
                        >
                            {{ msgButtonUpdateSpecialSchedule }}
                        </md-button>
                        <md-button
                            class="md-dense md-raised md-danger"
                            @click="isEditSpecialSchedule = false"
                        >
                            <!-- <md-icon>close</md-icon> -->
                            ✕ Close</md-button
                        >
                    </md-dialog-actions>
                </section>
            </DialogCard>
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
            <div style="margin-top: 5%"></div>
        </md-card>
        <MassAssignmentSchedule></MassAssignmentSchedule>
        <MassPrintingDTR></MassPrintingDTR>
    </div>
</template>
<script>
// import DialogCard from "../../components/Cards/DialogCard.vue";
const DialogCard = () =>
    import(
        /* webpackChunkName: "DialogCard" */ "../../components/Cards/DialogCard.vue"
    );
const MassAssignmentSchedule = () =>
    import(
        /* webpackChunkName: "MassAssignmentSchedule" */ "../Schedule/MassAssignmentSchedule.vue"
    );
const MassPrintingDTR = () =>
    import(
        /* webpackChunkName: "MassPrintingDTR" */ "../Schedule/MassPrintingDTR.vue"
    );
import axios from "axios";
import userAction from "../../mixins/userAction.js";
import LogOut from "../../mixins/logOut.js";
export default {
    components: {
        DialogCard,
        MassAssignmentSchedule,
        MassPrintingDTR,
    },
    mixins: [LogOut, userAction],
    name: "ScheduleTemplate",
    props: {
        dataBackgroundColor: {
            type: String,
            default: "",
        },
    },
    data: () => ({
        //Snackkbar
        fireSnackbar: false,
        messageSnackbar: null,

        //Actions Specific
        isAuthenticated: true,
        msgButton: "Add Template",
        isAdding: false,
        isEdit: false,
        updateID: null,

        is_flexi: false,
        isAddSchedule: false,
        schedule: [],

        //Data needed
        code: null,
        description: null,
        mon_time_in: "08:00:00",
        mon_lunch_out: "12:00:00",
        mon_lunch_in: "01:00:00",
        mon_time_out: "05:00:00",
        tue_time_in: "08:00:00",
        tue_lunch_out: "12:00:00",
        tue_lunch_in: "01:00:00",
        tue_time_out: "05:00:00",
        wed_time_in: "08:00:00",
        wed_lunch_out: "12:00:00",
        wed_lunch_in: "01:00:00",
        wed_time_out: "05:00:00",
        thu_time_in: "08:00:00",
        thu_lunch_out: "12:00:00",
        thu_lunch_in: "01:00:00",
        thu_time_out: "05:00:00",
        fri_time_in: "08:00:00",
        fri_lunch_out: "12:00:00",
        fri_lunch_in: "01:00:00",
        fri_time_out: "05:00:00",
        sat_time_in: "08:00:00",
        sat_lunch_out: "12:00:00",
        sat_lunch_in: "01:00:00",
        sat_time_out: "05:00:00",
        sun_time_in: "08:00:00",
        sun_lunch_out: "12:00:00",
        sun_lunch_in: "01:00:00",
        sun_time_out: "05:00:00",
        flexi_from: null,
        flexi_to: null,

        //Add Schedule Template
        schedule_type: "regular",

        //Data needed for setting schedule
        schedule_id: null,
        effective_date: "2020-01-01",
        effecttive_month: 1,
        effective_year: 2021,
        no_of_days: null,
        type: "PERMANENT",

        //Special Schedule Data
        special_schedule_data: {},
        temp_date: null,
        is_special_selected: false,
        editScheduleInformation: null,
        isEditSpecialSchedule: false,
        spScheduleID: null,
        isUpdatingSchedule: false,
        msgButtonUpdateSpecialSchedule: "Update",

        special_schedule: [],
        ref_date: null,
        links: null,
        isSearching: false,
        btnSearch: "Search",
        searchValue: null,
        perPage: 10,

        linksOnSchedule: null,
        searchValueOnSchedule: null,
        btnSearchSchedule: "Search",
        isSearchingSchedule: false,
    }),
    methods: {
        //Open or Close Add Modal
        addSchedule() {
            this.resetData();
            this.isEdit = false;
            this.isAdding = false;
            this.msgButton = "Add Template";
            this.isAddSchedule = !this.isAddSchedule;
        },
        //Pad function to convert length of the number
        pad(d) {
            return d < 10 ? "0" + d.toString() : d.toString();
        },
        getMonthAndYear() {
            this.special_schedule_data = {};
            this.effective_date =
                this.effective_year + "-" + this.effecttive_month + "-01";
            console.log(this.effective_date);
            this.no_of_days = this.daysInMonth(
                this.effecttive_month,
                this.effective_year
            );
            console.log(this.no_of_days);
            let counter = 1;
            while (this.no_of_days >= 1) {
                counter = this.pad(counter);
                this.temp_date =
                    this.effective_year +
                    "-" +
                    this.effecttive_month +
                    "-" +
                    counter;
                var key = this.temp_date;
                this.special_schedule_data[key] = {
                    time_in: null,
                    lunch_out: null,
                    lunch_in: null,
                    time_out: null,
                };
                counter++;
                this.no_of_days -= 1;
            }
            this.is_special_selected = true;
            console.log(this.is_special_selected);
            console.log(this.special_schedule_data);
        },
        //Calculate days in a month
        daysInMonth(month, year) {
            return new Date(year, month, 0).getDate();
        },
        //Add Template
        async validateAddTemplate() {
            this.isAdding = true;
            this.msgButton = "Adding...";
            const getToken = localStorage.getItem("token");
            let baseUrl = localStorage.getItem("base_url");
            baseUrl = baseUrl + "/api/schedule/create";

            const options = {
                method: "POST",
                url: baseUrl,
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    Authorization: "Bearer " + getToken,
                },
                data: {
                    code: this.code,
                    description: this.description,
                    mon_time_in: this.mon_time_in,
                    mon_lunch_out: this.mon_lunch_out,
                    mon_lunch_in: this.mon_lunch_in,
                    mon_time_out: this.mon_time_out,
                    tue_time_in: this.tue_time_in,
                    tue_lunch_out: this.tue_lunch_out,
                    tue_lunch_in: this.tue_lunch_in,
                    tue_time_out: this.tue_time_out,
                    wed_time_in: this.wed_time_in,
                    wed_lunch_out: this.wed_lunch_out,
                    wed_lunch_in: this.wed_lunch_in,
                    wed_time_out: this.wed_time_out,
                    thu_time_in: this.thu_time_in,
                    thu_lunch_out: this.thu_lunch_out,
                    thu_lunch_in: this.thu_lunch_in,
                    thu_time_out: this.thu_time_out,
                    fri_time_in: this.fri_time_in,
                    fri_lunch_out: this.fri_lunch_out,
                    fri_lunch_in: this.fri_lunch_in,
                    fri_time_out: this.fri_time_out,
                    sat_time_in: this.sat_time_in,
                    sat_lunch_out: this.sat_lunch_out,
                    sat_lunch_in: this.sat_lunch_in,
                    sat_time_out: this.sat_time_out,
                    sun_time_in: this.sun_time_in,
                    sun_lunch_out: this.sun_lunch_out,
                    sun_lunch_in: this.sun_lunch_in,
                    sun_time_out: this.sun_time_out,
                    flexi_from: this.flexi_from,
                    flexi_to: this.flexi_to,
                },
            };

            await this.getResp(options);
            await this.getSchedule();
            this.addSchedule();
            this.fireSnackbar = true;
            this.messageSnackbar = "Template has been added";
        },

        //Get Template Information
        async editTemplate(id) {
            this.addSchedule();
            this.isEdit = true;
            this.msgButton = "Update Schedule Template";
            this.updateID = id;
            const getToken = localStorage.getItem("token");
            let baseUrl = localStorage.getItem("base_url");
            baseUrl = baseUrl + "/api/schedule/search/" + id;

            const options = {
                method: "GET",
                url: baseUrl,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + getToken,
                },
            };

            let resp = await this.getResp(options);
            (this.code = resp.data.code),
                (this.description = resp.data.description),
                (this.mon_time_in = resp.data.mon_time_in);
            this.mon_lunch_out = resp.data.mon_lunch_out;
            this.mon_lunch_in = resp.data.mon_lunch_in;
            this.mon_time_out = resp.data.mon_time_out;
            this.tue_time_in = resp.data.tue_time_in;
            this.tue_lunch_out = resp.data.tue_lunch_out;
            this.tue_lunch_in = resp.data.tue_lunch_in;
            this.tue_time_out = resp.data.tue_time_out;
            this.wed_time_in = resp.data.wed_time_in;
            this.wed_lunch_out = resp.data.wed_lunch_out;
            this.wed_lunch_in = resp.data.wed_lunch_in;
            this.wed_time_out = resp.data.wed_time_out;
            this.thu_time_in = resp.data.thu_time_in;
            this.thu_lunch_out = resp.data.thu_lunch_out;
            this.thu_lunch_in = resp.data.thu_lunch_in;
            this.thu_time_out = resp.data.thu_time_out;
            this.fri_time_in = resp.data.fri_time_in;
            this.fri_lunch_out = resp.data.fri_lunch_out;
            this.fri_lunch_in = resp.data.fri_lunch_in;
            this.fri_time_out = resp.data.fri_time_out;
            this.sat_time_in = resp.data.sat_time_in;
            this.sat_lunch_out = resp.data.sat_lunch_out;
            this.sat_lunch_in = resp.data.sat_lunch_in;
            this.sat_time_out = resp.data.sat_time_out;
            this.sun_time_in = resp.data.sun_time_in;
            this.sun_lunch_out = resp.data.sun_lunch_out;
            this.sun_lunch_in = resp.data.sun_lunch_in;
            this.sun_time_out = resp.data.sun_time_out;
            this.flexi_from = resp.data.flexi_from;
            this.flexi_to = resp.data.flexi_to;

            if (resp.data.flexi_to != null) {
                this.is_flexi = true;
            } else {
                this.is_flexi = false;
            }
        },

        //Update Template
        async updateTemplate() {
            this.isAdding = true;
            this.msgButton = "Updating...";
            const getToken = localStorage.getItem("token");
            let baseUrl = localStorage.getItem("base_url");
            baseUrl = baseUrl + "/api/schedule/update/" + this.updateID;

            const options = {
                method: "PUT",
                url: baseUrl,
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    Authorization: "Bearer " + getToken,
                },
                data: {
                    code: this.code,
                    description: this.description,
                    mon_time_in: this.mon_time_in,
                    mon_lunch_out: this.mon_lunch_out,
                    mon_lunch_in: this.mon_lunch_in,
                    mon_time_out: this.mon_time_out,
                    tue_time_in: this.tue_time_in,
                    tue_lunch_out: this.tue_lunch_out,
                    tue_lunch_in: this.tue_lunch_in,
                    tue_time_out: this.tue_time_out,
                    wed_time_in: this.wed_time_in,
                    wed_lunch_out: this.wed_lunch_out,
                    wed_lunch_in: this.wed_lunch_in,
                    wed_time_out: this.wed_time_out,
                    thu_time_in: this.thu_time_in,
                    thu_lunch_out: this.thu_lunch_out,
                    thu_lunch_in: this.thu_lunch_in,
                    thu_time_out: this.thu_time_out,
                    fri_time_in: this.fri_time_in,
                    fri_lunch_out: this.fri_lunch_out,
                    fri_lunch_in: this.fri_lunch_in,
                    fri_time_out: this.fri_time_out,
                    sat_time_in: this.sat_time_in,
                    sat_lunch_out: this.sat_lunch_out,
                    sat_lunch_in: this.sat_lunch_in,
                    sat_time_out: this.sat_time_out,
                    sun_time_in: this.sun_time_in,
                    sun_lunch_out: this.sun_lunch_out,
                    sun_lunch_in: this.sun_lunch_in,
                    sun_time_out: this.sun_time_out,
                    flexi_from: this.flexi_from,
                    flexi_to: this.flexi_to,
                },
            };
            await this.getResp(options);
            await this.getSchedule();
            this.addSchedule();
            this.fireSnackbar = true;
            this.messageSnackbar = "Template has been updated";
        },

        //Edit Special Template
        async editSpecialTemplate(info, id, ref_date, code, desc) {
            this.isEditSpecialSchedule = true;
            this.editScheduleInformation = info;
            this.special_schedule_data = this.editScheduleInformation.template;
            this.spScheduleID = id;
            this.code = code;
            this.ref_date = ref_date;
            this.description = desc;
            console.log(this.special_schedule_data);
        },

        //Add Special Schedule Template
        async validateAddSpecialTemplate() {
            const getToken = localStorage.getItem("token");
            let baseUrl = localStorage.getItem("base_url");
            baseUrl = baseUrl + "/api/special-schedule/create";

            const options = {
                method: "POST",
                url: baseUrl,
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    Authorization: "Bearer " + getToken,
                },
                data: {
                    code: this.code,
                    description: this.description,
                    ref_date: this.effective_date,
                    template: this.special_schedule_data,
                },
            };

            await axios
                .request(options)
                .then((response) => {
                    console.log(response.data);
                    this.fireSnackbar = true;
                    this.messageSnackbar = "Template has been created";
                })
                .catch((error) => {
                    console.error(error);
                });
            this.addSchedule();
            await this.getSpecialSchedule();
        },

        async updateSpecialSchedule() {
            console.log(this.special_schedule_data);
            this.isUpdatingSchedule = true;
            this.msgButtonUpdateSpecialSchedule = "Updating...";
            const getToken = localStorage.getItem("token");
            let baseUrl = localStorage.getItem("base_url");
            baseUrl =
                baseUrl + "/api/special-schedule/update/" + this.spScheduleID;

            const options = {
                method: "PUT",
                url: baseUrl,
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    Authorization: "Bearer " + getToken,
                },
                data: {
                    code: this.code,
                    description: this.description,
                    ref_date: this.ref_date,
                    template: this.special_schedule_data,
                },
            };

            await axios
                .request(options)
                .then((response) => {
                    console.log(response.data);
                    this.fireSnackbar = true;
                    this.messageSnackbar =
                        "Special Schedule Updated Successfully!";
                })
                .catch((error) => {
                    console.error(error);
                });
            this.msgButtonUpdateSpecialSchedule = "Update";
            this.isEditSpecialSchedule = false;
            await this.getSpecialSchedule();
            this.isUpdatingSchedule = false;
        },

        //Get Schedule
        async getSchedule() {
            const getToken = localStorage.getItem("token");
            let baseUrl = localStorage.getItem("base_url");
            baseUrl = baseUrl + "/api/schedule/search";
            const options = {
                method: "GET",
                params: { perPage: this.perPage },
                url: baseUrl,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + getToken,
                },
            };

            let resp = await this.getResp(options);
            this.schedule = resp.data.data;
            this.linksOnSchedule = resp.data.links;
        },

        //Get Schedule using Link
        async getScheduleUsingLink(url) {
            const getToken = localStorage.getItem("token");

            const options = {
                method: "GET",
                params: {
                    searchValue: this.searchValueOnSchedule,
                    perPage: this.perPage,
                },
                url: url,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + getToken,
                },
            };

            await axios
                .request(options)
                .then((response) => {
                    console.log(response.data);
                    this.schedule = response.data.data;
                    this.linksOnSchedule = response.data.links;
                })
                .catch((error) => {
                    console.error(error);
                });
        },

        //Search Schedule
        async searchSchedule() {
            this.schedule = [];
            this.isSearchingSchedule = true;
            this.btnSearchSchedule = "Searching...";
            const getToken = localStorage.getItem("token");
            let baseUrl = localStorage.getItem("base_url");
            baseUrl = baseUrl + "/api/schedule/search";

            const options = {
                method: "GET",
                params: {
                    searchValue: this.searchValueOnSchedule,
                    perPage: this.perPage,
                },
                url: baseUrl,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + getToken,
                },
            };

            await axios
                .request(options)
                .then((response) => {
                    console.log(response.data);
                    this.schedule = response.data.data;
                    this.linksOnSchedule = response.data.links;
                })
                .catch((error) => {
                    console.error(error);
                });
            this.isSearchingSchedule = false;
            this.btnSearchSchedule = "Search";
        },

        //Get Special Schedule
        async getSpecialSchedule() {
            const getToken = localStorage.getItem("token");
            let baseUrl = localStorage.getItem("base_url");
            baseUrl = baseUrl + "/api/special-schedule/search";

            const options = {
                method: "GET",
                params: { perPage: this.perPage },
                url: baseUrl,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + getToken,
                },
            };

            await axios
                .request(options)
                .then((response) => {
                    this.links = response.data.links;
                    this.special_schedule = response.data.data;
                })
                .catch((error) => {
                    console.error(error);
                });
        },

        //Get Special Schedule using Link
        async getSpecialScheduleUsingLink(url) {
            const getToken = localStorage.getItem("token");

            const options = {
                method: "GET",
                params: {
                    searchValue: this.searchValue,
                    perPage: this.perPage,
                },
                url: url,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + getToken,
                },
            };

            await axios
                .request(options)
                .then((response) => {
                    this.links = response.data.links;
                    this.special_schedule = [];
                    this.special_schedule = response.data.data;
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        //Get Special Schedule using Search
        async searchSpecialSchedule() {
            this.btnSearch = "Searching...";
            this.isSearching = true;
            const getToken = localStorage.getItem("token");
            let baseUrl = localStorage.getItem("base_url");
            baseUrl = baseUrl + "/api/special-schedule/search";

            const options = {
                method: "GET",
                params: {
                    searchValue: this.searchValue,
                    perPage: this.perPage,
                },
                url: baseUrl,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + getToken,
                },
            };

            await axios
                .request(options)
                .then((response) => {
                    this.links = response.data.links;
                    this.special_schedule = [];
                    this.special_schedule = response.data.data;
                })
                .catch((error) => {
                    console.error(error);
                });
            this.isSearching = false;
            this.btnSearch = "Search";
        },

        async deleteTemplate(id) {
            const getToken = localStorage.getItem("token");
            let baseUrl = localStorage.getItem("base_url");
            baseUrl = baseUrl + "/api/schedule/delete/" + id;

            const options = {
                method: "DELETE",
                url: baseUrl,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + getToken,
                },
            };

            await this.getResp(options);
            await this.getSchedule();
            this.fireSnackbar = true;
            this.messageSnackbar = "Template has been deleted";
        },

        async restoreTemplate(id) {
            const getToken = localStorage.getItem("token");
            let baseUrl = localStorage.getItem("base_url");
            baseUrl = baseUrl + "/api/schedule/restore/" + id;

            const options = {
                method: "POST",
                url: baseUrl,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + getToken,
                },
            };

            await this.getResp(options);
            await this.getSchedule();
            this.fireSnackbar = true;
            this.messageSnackbar = "Template has been restored";
        },

        //Axios Request
        async getResp(options) {
            let resp;
            await axios
                .request(options)
                .then((response) => {
                    console.log(response.data);
                    resp = response;
                })
                .catch((error) => {
                    console.log(error.response);
                    resp = error.response;
                });
            return resp;
        },

        //Delete Special Schedule Template
        async deleteSpecialTemplate(id) {
            const getToken = localStorage.getItem("token");
            let baseUrl = localStorage.getItem("base_url");
            const options = {
                method: "DELETE",
                url: baseUrl + "/api/special-schedule/delete/" + id,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + getToken,
                },
            };

            await axios
                .request(options)
                .then(() => {
                    this.fireSnackbar = true;
                    this.messageSnackbar = "Special Template has been deleted.";
                })
                .catch(() => {
                    this.fireSnackbar = true;
                    this.messageSnackbar =
                        "There is an error deleting the template. Please try again or contact the technical support.";
                });

            await this.getSpecialSchedule();
        },

        //Restore Special Schedule Template
        async restoreSpecialTemplate(id) {
            const getToken = localStorage.getItem("token");
            let baseUrl = localStorage.getItem("base_url");
            const options = {
                method: "POST",
                url: baseUrl + "/api/special-schedule/restore/" + id,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + getToken,
                },
            };

            await axios
                .request(options)
                .then(() => {
                    this.fireSnackbar = true;
                    this.messageSnackbar =
                        "Special Template has been restored.";
                })
                .catch(() => {
                    this.fireSnackbar = true;
                    this.messageSnackbar =
                        "There is an error restoring the template. Please try again or contact the technical support.";
                });
            await this.getSpecialSchedule();
        },

        //Reset Data
        resetData() {
            (this.code = null),
                (this.description = null),
                (this.mon_time_in = "08:00:00");
            this.mon_lunch_out = "12:00:00";
            this.mon_lunch_in = "01:00:00";
            this.mon_time_out = "05:00:00";
            this.tue_time_in = "08:00:00";
            this.tue_lunch_out = "12:00:00";
            this.tue_lunch_in = "01:00:00";
            this.tue_time_out = "05:00:00";
            this.wed_time_in = "08:00:00";
            this.wed_lunch_out = "12:00:00";
            this.wed_lunch_in = "01:00:00";
            this.wed_time_out = "05:00:00";
            this.thu_time_in = "08:00:00";
            this.thu_lunch_out = "12:00:00";
            this.thu_lunch_in = "01:00:00";
            this.thu_time_out = "05:00:00";
            this.fri_time_in = "08:00:00";
            this.fri_lunch_out = "12:00:00";
            this.fri_lunch_in = "01:00:00";
            this.fri_time_out = "05:00:00";
            this.sat_time_in = "08:00:00";
            this.sat_lunch_out = "12:00:00";
            this.sat_lunch_in = "01:00:00";
            this.sat_time_out = "05:00:00";
            this.sun_time_in = "08:00:00";
            this.sun_lunch_out = "12:00:00";
            this.sun_lunch_in = "01:00:00";
            this.sun_time_out = "05:00:00";
            this.flexi_from = null;
            this.flexi_to = null;
            this.is_flexi = false;
        },
    },

    async mounted() {
        await this.getSchedule();
        await this.getSpecialSchedule();
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
.addChild {
    background-color: #495057;
    border-color: #495057;
    color: white !important;
}
.md-table-sortable-icon {
    display: none !important;
}
.button-paginate {
    border: 0px !important;
    margin-left: 2px !important;
    margin-right: 2px !important;
    padding: 5px !important;
    max-width: 90px !important;
    min-width: 90px !important;
}
</style>
