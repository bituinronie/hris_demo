<template>
    <div>
        <div v-if="diagShow" class="overlay" @click="closeSidebar"></div>
        <md-dialog
            class="dialog"
            :md-active.sync="diagShow"
            :md-click-outside-to-close="false"
            :md-close-on-esc="false"
            :md-backdrop="false"
        >
            <md-dialog-title>
                <div style="display: flex">
                    <div style="width: 90%">
                        <slot name="header"></slot>
                    </div>
                    <div class="menu-icon" @click="openSidebar">
                        <md-icon>menu</md-icon>
                    </div>
                </div>
            </md-dialog-title>
            <md-dialog-content>
                <slot name="body"></slot>
            </md-dialog-content>
            <!-- <md-dialog-actions>
                <md-button class="closeDialog md-dense" @click="clicked">Close</md-button>
            </md-dialog-actions> -->
            <div
                v-if="$sidebar.showSidebar"
                class="overlay-on-dialog"
                @click="closeSidebar"
            ></div>
        </md-dialog>
    </div>
</template>

<script>
/* eslint-disable */
export default {
    name: "DialogCard",
    data() {
        return {
            diagShow: true,
            title: "Title Here",
        };
    },
    methods: {
        clicked() {
            this.$emit("close-dialog");
        },
        closeSidebar() {
          if (
              this.$sidebar &&
              this.$sidebar.showSidebar === true
          ) {
              this.$sidebar.displaySidebar(false);
          }
        },
        openSidebar() {
          console.log('open side bar')
          if (
              this.$sidebar &&
              this.$sidebar.showSidebar === false
          ) {
              this.$sidebar.displaySidebar(true);
          }
        }
    },
};
</script>

<style scoped>
  .overlay {
    background-color: rgba(0,0,0,0.4);
    height: 200%;
    width: 200%;
    position: fixed;
    z-index: 6;
    right: 0;
    top: 0;
  }
  .overlay-on-dialog {
    background-color: rgba(0,0,0,0.4);
    height: 100%;
    width: 100%;
    position: absolute;
    z-index: 6;
    display: none;
  }
  .dialog {
    z-index: 7;
  }
  .menu-icon {
    width: 10%;
    float: right;
    display: none;
  }
/* button{
    padding: 0.2rem 0.2rem;
    font-family: inherit;
    background-color: #c53737;
    border: 1px solid#c53737 ;
    border-radius: 3px;color: white;
    cursor: pointer;
} */
/* div {
  position: fixed;
  top: 0;
  left: 0;
  height: 100vh;
  width: 100%;
  background-color: rgba(0, 0, 0, 0.75);
  z-index: 10;
}

dialog {
  position: fixed;
  top: 20vh;
  left: 10%;
  width: 80%;
  z-index: 100;
  border-radius: 3px;
  border: none;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.26);
  padding: 0;
  margin: 0;
  overflow: hidden;
}

header {
  background-color: #3a0061;
  color: white;
  width: 100%;
  padding: 1rem;
}

header h2 {
  margin: 0;
}

section {
  padding: 1rem;
}

button {

}

.closeDialog{
  float: left;
  padding: 0.2rem 0.2rem;
  font-family: inherit;
  background-color: #e74949 ;
  border: 1px solid#e74949 ;
  border-radius: 3px;
  color: white;
  cursor: pointer;
  margin-bottom: 1rem;
}

@media (min-width: 768px) {
  dialog {
    left: calc(50% - 20rem);
    width: 40rem;
  }
} */

@media (max-width: 990px) {
  .menu-icon {
    display: block;
  }
  .overlay-on-dialog {
    display: block;
  }
} 

</style>
