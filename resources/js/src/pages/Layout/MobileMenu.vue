<template>
    <ul class="nav nav-mobile-menu">
        <!-- <li>
      <md-field>
        <label>Search</label>
        <md-input v-model="search" type="text"></md-input>
      </md-field>
    </li> -->
        <!-- <li>
      <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <i class="material-icons">dashboard</i>
        <p>Dashboard</p></a
      >
    </li> -->
        <!-- <li>
      <drop-down>
        <a slot="title" class="dropdown-toggle" data-toggle="dropdown">
          <i class="material-icons">notifications</i>
          <span class="notification">5</span>
          <p>Notifications</p>
        </a>
        <ul class="dropdown-menu dropdown-menu-right">
          <li><a href="#">Mike John responded to your email</a></li>
          <li><a href="#">You have 5 new tasks</a></li>
          <li><a href="#">You're now friend with Andrew</a></li>
          <li><a href="#">Another Notification</a></li>
          <li><a href="#">Another One</a></li>
        </ul>
      </drop-down>
    </li>
    -->
        <!-- <li>
      <a href="#" data-toggle="dropdown" class="dropdown-toggle"
        ><i class="material-icons">person</i>
        <p>Profile</p></a
      >
    </li> -->
        <li>
            <a
                @click="logOut"
                href="#"
                data-toggle="dropdown"
                class="dropdown-toggle"
            >
                <!-- <i class="material-icons">logout</i> -->
                <p>Logout</p></a
            >
        </li>
    </ul>
</template>
<script>
import LogOut from "../../mixins/logOut.js";
export default {
    mixins: [LogOut],
};
</script>
<style scoped>
.sidebar {
    background-color: #042278 !important;
}
p {
    color: black !important;
}
</style>
