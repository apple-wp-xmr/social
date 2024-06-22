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
            // First, get the CSRF token cookie
            axios
                .get("/sanctum/csrf-cookie")
                .then(() => {
                    // Now, make the API request with the CSRF token in the headers
                    axios
                        .get("/api/get", {
                            headers: {
                                "X-XSRF-TOKEN": this.getCookie("XSRF-TOKEN"),
                            },
                        })
                        .then((response) => {
                            console.log(response);
                        })
                        .catch((error) => {
                            console.error("Error during API call:", error);
                        });
                })
                .catch((error) => {
                    console.error("Error getting CSRF cookie:", error);
                });
        },
        getCookie(name) {
            let value = `; ${document.cookie}`;
            let parts = value.split(`; ${name}=`);
            if (parts.length === 2) return parts.pop().split(";").shift();
        },
    },
};
</script>

<style scoped></style>
