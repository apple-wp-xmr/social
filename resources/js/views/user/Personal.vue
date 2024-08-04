<template>
    <div class="w-96 mx-auto">
        <Stat :stats="stats"></Stat>
        <div>
            <div>
                <input
                    v-model="title"
                    class="w-96 border rounded-3xl border-1 border-stlate-400 p-2 mb-3"
                    type="text"
                    placeholder="title"
                />
                <p
                    class="text-sm text-red-500 mb-2"
                    v-for="error in errors.title"
                >
                    {{ error }}
                </p>
            </div>
            <div>
                <textarea
                    v-model="content"
                    class="w-96 border rounded-3xl border-1 border-stlate-400 p-2 mb-3"
                    placeholder="content"
                ></textarea>
                <p
                    class="text-sm text-red-500 mb-2"
                    v-for="error in errors.content"
                >
                    {{ error }}
                </p>
            </div>
            <div class="flex mb-3 items-center">
                <div>
                    <input
                        @change="storeImage"
                        ref="file"
                        type="file"
                        class="hidden"
                    />
                    <a
                        @click.prevent="selectImage"
                        href="#"
                        class="block p-2 w-16 bg-sky-500 text-white text-center rounded-3xl border text-sm"
                        >Image</a
                    >
                </div>
                <div class="ml-3" v-if="image">
                    <a @click.prevent="image = null">Cancel</a>
                </div>
            </div>
            <div v-if="image" class="mb-2">
                <img :src="image.url" alt="preview" />
            </div>
            <div>
                <a
                    @click.prevent="storePost"
                    class="block p-2 w-32 bg-green-600 text-white text-center rounded-3xl border hover:bg-white hover:text-green-600 hover:border ml-auto"
                    href="#"
                    >publish</a
                >
            </div>
        </div>
        <Post
            v-if="posts"
            v-for="post in posts"
            :post="post"
            :key="post.id"
        ></Post>
        <p v-else>Loading...</p>
    </div>
</template>
<script>
import axios from "axios";
import Post from "../../components/Post.vue";
import Stat from "../../components/Stat.vue";
export default {
    name: "Personal",
    data() {
        return {
            title: "",
            content: "",
            image: null,
            posts: [],
            errors: [],
            stats: [],
        };
    },
    mounted() {
        this.getPosts();
        this.getStats();
    },
    methods: {
        getStats() {
            axios.post("/api/users/stats", { id: null }).then((res) => {
                this.stats = res.data.data;
            });
        },
        selectImage() {
            let imageInupt = this.$refs.file;
            imageInupt.click();
        },
        storeImage(e) {
            let file = e.target.files[0];
            let form = new FormData();
            form.append("image", file);

            axios.post("/api/post_image", form).then((r) => {
                this.image = r.data.data;
            });
        },
        storePost() {
            const id = this.image ? this.image.id : null;
            axios
                .post("/api/post", {
                    title: this.title,
                    content: this.content,
                    image_id: id,
                })
                .then((r) => {
                    (this.title = ""), (this.content = ""), (this.image = null);
                    this.posts.unshift(r.data.data);
                })
                .catch((e) => {
                    this.errors = e.response.data.errors;
                });
        },
        getPosts() {
            axios.get("/api/posts").then((res) => {
                this.posts = res.data.data;
            });
        },
    },
    components: {
        Post,
        Stat,
    },
};
</script>
<style scoped></style>
