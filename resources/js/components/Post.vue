<template>
    <div>
        <div>{{ post.title }}</div>
        <div>{{ post.content }}</div>
        <img v-if="post.image_url" :src="post.image_url" :alt="post.title" />
        <div>{{ post.date }}</div>
    </div>
</template>
<script>
export default {
    name: "Post",
    props: ["post"],
};
</script>
<style scoped></style>
