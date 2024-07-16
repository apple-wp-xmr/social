<template>
    <div class="w-96 mx-auto">
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
    name: "Posts",
    data() {
        return {
            posts: [],
            id: this.$route.params.id,
        };
    },
    mounted() {
        this.getPosts();
    },
    methods: {
        getPosts() {
            axios.get(`/api/users/${this.id}/posts`).then((res) => {
                console.log(res);
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
