<template>
    <div class="flex items-center justify-center min-h-screen">
        <form
            class="bg-white p-6 rounded shadow-md w-full max-w-sm"
            @submit.prevent="register"
        >
            <h2 class="text-2xl font-bold mb-4 text-center">Register</h2>
            <div class="mb-4">
                <label
                    for="name"
                    class="block text-sm font-medium text-gray-700"
                    >Name</label
                >
                <input
                    v-model="name"
                    type="text"
                    id="name"
                    placeholder="name"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                />
            </div>
            <div class="mb-4">
                <label
                    for="email"
                    class="block text-sm font-medium text-gray-700"
                    >Email</label
                >
                <input
                    v-model="email"
                    type="email"
                    id="login"
                    placeholder="email"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                />
            </div>
            <div class="mb-4">
                <label
                    for="password"
                    class="block text-sm font-medium text-gray-700"
                    >Password</label
                >
                <input
                    v-model="password"
                    type="password"
                    id="password"
                    placeholder="password"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                />
            </div>
            <div class="mb-4">
                <label
                    for="password"
                    class="block text-sm font-medium text-gray-700"
                    >Password Conformation</label
                >
                <input
                    v-model="password_confirmation"
                    type="password"
                    id="password_conformation"
                    placeholder="password conformation"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                />
            </div>
            <div>
                <button
                    type="submit"
                    class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    Login
                </button>
            </div>
        </form>
    </div>
</template>
<script>
export default {
    name: "Registration",
    data() {
        return {
            name: "",
            email: "",
            password: "",
            password_confirmation: "",
        };
    },
    methods: {
        register() {
            axios.get("/sanctun/csrf-cookie").then((response) => {
                axios
                    .post(
                        "/register",
                        {
                            name: this.name,
                            email: this.email,
                            password: this.password,
                            password_confirmation: this.password_confirmation,
                        },
                        {
                            headers: {
                                "X-XSRF-TOKEN": this.getCookie("XSRF-TOKEN"),
                            },
                        }
                    )
                    .then((r) => {
                        localStorage.setItem(
                            "x_xsrf_token",
                            r.config.headers["X-XSRF-TOKEN"]
                        );
                        this.$router.push({ name: "user.personal" });
                    });
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
