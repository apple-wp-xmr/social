<template>
    <div class="w-96 mx-auto">
        <div
            v-if="users"
            v-for="user in users"
            class="border-b border-gray-600 mb-3 pb-3 flex justify-between items-center"
        >
            <router-link :to="{ name: 'user.posts', params: { id: user.id } }">
                <div>{{ user.id }}</div>
                <div>{{ user.name }}</div>
                <div>{{ user.email }}</div>
            </router-link>
            <div>
                <a
                    @click.prevent="toggleFollowing(user)"
                    :class="[
                        'block p-2 w-32 text-center text-sm rounded-3xl',
                        user.is_followed
                            ? 'bg-white text-sky-500 border border-sky-500'
                            : 'bg-sky-500 text-white',
                    ]"
                    href="#"
                >
                    {{ user.is_followed ? "Unfollow" : "Follow" }}</a
                >
            </div>
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
            });
        },
        toggleFollowing(user) {
            axios.get(`/api/users/${user.id}/toggle_following`).then((res) => {
                user.is_followed = res.data.is_followed;
            });
        },
    },
};
</script>
<style scoped></style>
