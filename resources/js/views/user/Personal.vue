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
                <div class="ml-3">
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
export default {
    name: "Personal",
    data() {
        return {
            title: "",
            content: "",
            image: null,
            posts: [],
        };
    },
    mounted() {
        this.getPosts();
    },
    methods: {
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
    },
};
</script>
<style scoped></style>
