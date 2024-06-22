<template>
    <div>Get</div>
</template>
<script>
import axios from "axios";

export default {
    name: "Get",
    mounted() {
        this.getData();
    },
    methods: {
        getData() {
            axios.get("/api/get").then((response) => {
                console.log(response);
            });
        },
    },
};
</script>
<style scoped></style>
