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
                    v-model="content"
                    class="w-96 border rounded-3xl border-1 border-stlate-400 p-2 mb-3"
                    placeholder="content"
                ></textarea>
            </div>
            <div class="flex mb-3 items-center">
                <div>
                    <input ref="file" type="file" class="hidden" />
                    <a
                        href="#"
                        class="block p-2 w-16 bg-sky-500 text-white text-center rounded-3xl border text-sm"
                        >Image</a
                    >
                </div>
                <div class="ml-3">
                    <a @click.prevent="image = null">Cancel</a>
                </div>
            </div>
            <div v-if="image" class="mb-2">
                <img src="" alt="preview" />
            </div>
            <div>
                <a
                    class="block p-2 w-32 bg-green-600 text-white text-center rounded-3xl border hover:bg-white hover:text-green-600 hover:border ml-auto"
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
};
</script>
<style scoped></style>
