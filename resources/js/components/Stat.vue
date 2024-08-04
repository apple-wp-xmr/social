<template>
    <div class="flex justify-around mb-4 text-center">
        <div>
            Subscribers
            <div>{{ stats.subscribers_count }}</div>
        </div>
        <div>
            Likes
            <div>{{ stats.followers_count }}</div>
        </div>
        <div>
            Posts
            <div>{{ stats.likes_count }}</div>
        </div>
        <div>
            Followers
            <div>{{ stats.posts_count }}</div>
        </div>
    </div>
</template>
<script>
export default {
    name: "Stat",
    props: ["stats"],
};
</script>
<style scoped></style>
