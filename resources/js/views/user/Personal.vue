<template>
    <div class="w-96 mx-auto">
        <div>
            <div>
                <input
                    v-model="title"
                    class="w-96 border rounded-3xl border-1 border-stlate-400 p-2 mb-3"
                    type="text"
                    placeholder="title"
                />
            </div>
            <div>
                <textarea
                    v-model="contnet"
                    class="w-96 border rounded-3xl border-1 border-stlate-400 p-2 mb-3"
                    placeholder="content"
                ></textarea>
            </div>
            <div>
                <a
                    class="block p-2 w-32 bg-green-600 text-white text-center rounded-3xl border hover:bg-white hover:text-green-600 hover:border"
                    href="#"
                    >publish</a
                >
            </div>
        </div>
    </div>
</template>
<script>
import axios from "axios";

export default {
    name: "Personal",
    data() {
        return {
            title: "",
            content: "",
        };
    },
    mounted() {},
    methods: {},
};
</script>
<style scoped></style>
