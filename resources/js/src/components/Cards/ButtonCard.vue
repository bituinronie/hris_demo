<template>
    <md-button class="md-dense md-accent" @click="clicked"
        ><slot></slot
    ></md-button>
</template>

<script>
export default {
    name: "ButtonCard",
    methods: {
        clicked() {
            this.$emit("listen-to-click");
        },
    },
};
</script>

<style scoped>
/* button {
  padding: 0.2rem 0.2rem;
  font-family: inherit;
  background-color: #4caf50 ;
  border: 1px solid#4caf50 ;
  border-radius: 3px;
  color: white;
  cursor: pointer;
} */
/* 
button:hover,
button:active {
  background-color: #270041;
  border-color: #270041;
} */

.flat {
    background-color: transparent;
    color: #3a0061;
    border: none;
}

.flat:hover,
.flat:active {
    background-color: #edd2ff;
}
</style>
