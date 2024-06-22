<template>
    <app-layout>
        <router-link :to="{ name: 'get.index' }">Get</router-link>
        <router-link :to="{ name: 'user.login' }">Login</router-link>
        <router-link :to="{ name: 'user.registration' }"
            >Registration</router-link
        >
        <router-link :to="{ name: 'user.personal' }">Personal</router-link>
        <a href="#" @click.prevent="logout">Logout</a>

        <router-view></router-view>
    </app-layout>
</template>
<script>
import AppLayout from "../layouts/AppLayout.vue";
export default {
    layout: AppLayout,
    name: "Index",
    components: {
        AppLayout,
    },
    methods: {
        logout() {
            axios.post("/logout").then((res) => {
                this.$router.push({ name: "user.login" });
            });
        },
    },
};
</script>
<style scoped>
a + a {
    padding-left: 5px;
}
</style>
