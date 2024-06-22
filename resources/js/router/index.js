import { createRouter, createWebHistory } from "vue-router";

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: "/get",
            component: () => import("../components/Get.vue"),
            name: "get.index",
        },
        {
            path: "/user/login",
            component: () => import("../components/Login.vue"),
            name: "user.login",
        },
        {
            path: "/user/registration",
            component: () => import("../components/Registration.vue"),
            name: "user.registration",
        },
        {
            path: "/user/personal",
            component: () => import("../components/Personal.vue"),
            name: "user.personal",
        },
    ],
});

export default router;
