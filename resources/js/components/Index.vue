<template>
    <app-layout>
        <router-link v-if="token" :to="{ name: 'get.index' }">Get</router-link>

        <router-link v-if="!token" :to="{ name: 'user.login' }"
            >Login</router-link
        >
        <router-link v-if="!token" :to="{ name: 'user.registration' }"
            >Registration</router-link
        >
        <router-link v-if="token" :to="{ name: 'user.personal' }"
            >Personal</router-link
        >
        <a v-if="token" href="" @click.prevent="logout">Logout</a>

        <router-view></router-view>
    </app-layout>
</template>
<script>
import AppLayout from "../layouts/AppLayout.vue";
export default {
    layout: AppLayout,
    name: "Index",
    data() {
        return {
            token: null,
        };
    },
    components: {
        AppLayout,
    },
    methods: {
        getToken() {
            this.token = localStorage.getItem("x_xsrf_token");
        },
        logout() {
            axios
                .post("/logout")
                .then((res) => {
                    localStorage.removeItem("x_xsrf_token");
                    this.$router.push({ name: "user.login" });
                })
                .catch((error) => {
                    console.error("Logout failed:", error);
                });
        },
    },
    mounted() {
        this.getToken();
    },
    watch: {
        $route(to, from) {
            this.getToken();
        },
    },
};
</script>
<style scoped>
a + a {
    padding-left: 5px;
}
</style>
