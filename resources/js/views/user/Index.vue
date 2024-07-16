<template>
    <div class="w-96 mx-auto">
        <div
            v-if="users"
            v-for="user in users"
            class="border-b border-gray-600 mb-3 pb-3"
        >
            <router-link :to="{ name: 'user.posts', params: { id: user.id } }">
                <div>{{ user.id }}</div>
                <div>{{ user.name }}</div>
                <div>{{ user.email }}</div>
            </router-link>
        </div>
    </div>
</template>
<script>
export default {
    name: "Index",
    data() {
        return {
            users: [],
        };
    },
    mounted() {
        this.getUsers();
    },
    methods: {
        getUsers() {
            axios.get("/api/users").then((res) => {
                this.users = res.data.data;
                console.log(res);
            });
        },
    },
};
</script>
<style scoped></style>
