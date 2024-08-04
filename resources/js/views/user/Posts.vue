<template>
    <div class="w-96 mx-auto">
        <Stat :stats="stats"></Stat>
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
    name: "Posts",
    data() {
        return {
            posts: [],
            id: this.$route.params.id,
        };
    },
    mounted() {
        this.getPosts();
        this.getStats();
    },
    methods: {
        getPosts() {
            axios.get(`/api/users/${this.id}/posts`).then((res) => {
                console.log(res);
                this.posts = res.data.data;
            });
        },
        getStats() {
            axios.post("/api/users/stats", { id: this.id }).then((res) => {
                console.log(res.data.data);
                this.stats = res.data.data;
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
