<template>
    <div>
        <div>{{ post.title }}</div>
        <div>{{ post.content }}</div>
        <img v-if="post.image_url" :src="post.image_url" :alt="post.title" />
        <div class="flex justify-between mt-2 items-center">
            <div class="flex">
                <div class="flex">
                    <svg
                        @click.prevent="toggleLike(post)"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        :class="[
                            'mr-2 stroke-sky-500 cursor-pointer hover:fill-sky-500 w-6 h-6',
                            post.is_liked ? 'fill-sky-500' : 'fill-white',
                        ]"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"
                        />
                    </svg>
                    <p>{{ post.likes_count }}</p>
                </div>
                <div class="flex">
                    <svg
                        @click.prevent="openRepost()"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        :class="[
                            'mx-2 stroke-sky-500 cursor-pointer hover:fill-sky-500 w-6 h-6 fill-white',
                        ]"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M7.217 10.907a2.25 2.25 0 100 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186l9.566-5.314m-9.566 7.5l9.566 5.314m0 0a2.25 2.25 0 103.935 2.186 2.25 2.25 0 00-3.935-2.186zm0-12.814a2.25 2.25 0 103.933-2.185 2.25 2.25 0 00-3.933 2.185z"
                        />
                    </svg>
                    <p>{{ post.reposted_by_posts_count }}</p>
                </div>
                <div>
                    <svg
                        @click.prevent="deletePost(post)"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="mr-2 stroke-blue-400 cursor-pointer hover:fill-gray-200 w-6 h-6"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"
                        />
                    </svg>
                </div>
            </div>

            <p class="text-right text-slate-500 text-sm">{{ post.date }}</p>
        </div>
    </div>
</template>
<script>
export default {
    name: "Post",
    props: ["post"],
    methods: {
        toggleLike(post) {
            axios.get(`/api/posts/${post.id}/toggle_like`).then((res) => {
                post.is_liked = res.data.is_liked;
                post.likes_count = res.data.likes_count;
            });
        },
        deletePost(post) {
            axios.delete(`/api/posts/${post.id}`).then((res) => {
                console.log("deleted");
            });
        },
    },
};
</script>
<style scoped></style>
