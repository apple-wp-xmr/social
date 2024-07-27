<template>
    <div class="w-96 mx-auto">
        <Post
            v-if="posts"
            v-for="post in posts"
            :post="post"
            :key="post.id"
        ></Post>
    </div>
</template>
<script>
import Post from "../../components/Post.vue";
export default {
    name: "Feed",
    data() {
        return {
            posts: [],
        };
    },
    methods: {
        getPosts() {
            axios.get("/api/users/feed").then((res) => {
                this.posts = res.data.data;
            });
        },
    },
    mounted() {
        this.getPosts();
    },
    components: {
        Post,
    },
};
</script>
<style scoped></style>
