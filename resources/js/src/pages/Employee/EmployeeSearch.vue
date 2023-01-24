<template>
    <div>
        <dialog open>
            <section>Employee Search Dialog Here</section>
            <section>
                <button class="closeDialog" @click="clicked">Close</button>
            </section>
        </dialog>
    </div>
</template>

<script>
export default {
    emits: ["close"],
    name: "EmployeeSearch",
    data() {
        return {
            title: "Title Here",
        };
    },
    methods: {
        clicked() {
            this.$emit("close-dialog");
        },
    },
};
</script>

<style scoped>
div {
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

.closeDialog {
    float: left;
    padding: 0.2rem 0.2rem;
    font-family: inherit;
    background-color: #e74949;
    border: 1px solid#e74949;
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
}
</style>
