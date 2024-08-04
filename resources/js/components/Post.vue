<template>
    <div class="mb-7">
        <div class="text-xl font-bold text-gray-800">{{ post.title }}</div>
        <router-link
            :to="{ name: 'user.posts', params: { id: post.user.id } }"
            >{{ post.user.name }}</router-link
        >
        <div class="text-gray-700">{{ post.content }}</div>
        <img
            v-if="post.image_url"
            :src="post.image_url"
            :alt="post.title"
            class="mt-4 rounded-lg shadow-md max-w-full h-auto"
        />
        <div
            v-if="post.repost"
            class="mt-4 p-4 border border-gray-300 rounded-lg bg-gray-50 shadow-sm"
        >
            <router-link
                :to="{
                    name: 'user.posts',
                    params: { id: post.repost.user.id },
                }"
                >{{ post.user.name }}</router-link
            >
            <div class="text-md font-semibold">{{ post.repost.title }}</div>
            <div class="text-gray-600">{{ post.repost.content }}</div>
            <img
                v-if="post.repost.image_url"
                :src="post.repost.image_url"
                :alt="post.repost.title"
                class="mt-2 max-w-full h-auto rounded-lg shadow-sm"
            />
        </div>
        <div
            class="flex justify-between items-center p-4 bg-gray-100 rounded-lg shadow-md my-4"
        >
            <div class="flex items-center space-x-4">
                <div class="flex items-center space-x-2">
                    <svg
                        @click.prevent="toggleLike(post)"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        :class="[
                            'mr-2 cursor-pointer hover:fill-sky-600 transition-colors duration-200 w-6 h-6',
                            post.is_liked
                                ? 'text-sky-600 fill-sky-600'
                                : 'text-gray-500 fill-white',
                        ]"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"
                        />
                    </svg>
                    <p class="text-gray-700 font-semibold">
                        {{ post.likes_count }}
                    </p>
                </div>
                <div class="flex items-center space-x-2">
                    <svg
                        @click.prevent="openRepost(post)"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="w-6 h-6 text-gray-500 fill-white mx-2 cursor-pointer hover:fill-sky-600 transition-colors duration-200"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M7.217 10.907a2.25 2.25 0 100 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186l9.566-5.314m-9.566 7.5l9.566 5.314m0 0a2.25 2.25 0 103.935 2.186 2.25 2.25 0 00-3.935-2.186zm0-12.814a2.25 2.25 0 103.933-2.185 2.25 2.25 0 00-3.933 2.185z"
                        />
                    </svg>
                    <p class="text-gray-700 font-semibold">
                        {{ post.reposted_by_posts_count }}
                    </p>
                </div>
                <div>
                    <svg
                        @click.prevent="deletePost(post)"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="w-6 h-6 text-gray-500 fill-white hover:fill-sky-600 transition-colors duration-200"
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

        <div
            data-repost
            v-if="is_repost"
            class="my-3 space-y-3 p-4 bg-gray-100 rounded-lg shadow-md"
        >
            <div>
                <input
                    v-model="title"
                    class="w-full border rounded-3xl border-gray-400 p-2 mb-3 focus:border-blue-500 focus:outline-none focus:ring"
                    type="text"
                    placeholder="Title"
                />
            </div>
            <div>
                <textarea
                    v-model="content"
                    class="w-full border rounded-3xl border-gray-400 p-2 mb-3 focus:border-blue-500 focus:outline-none focus:ring"
                    placeholder="Content"
                ></textarea>
            </div>
            <a
                @click.prevent="repost(post)"
                href="#"
                class="block w-full p-2 bg-blue-500 text-white text-center rounded-3xl border text-sm hover:bg-blue-600 transition-colors duration-200"
            >
                Repost
            </a>
        </div>

        <div
            data-comments
            class="space-y-4 p-4 bg-gray-100 rounded-lg shadow-md"
        >
            <button
                v-if="post.comments_count && !isShowed"
                @click.prevent="getComments(post)"
                class="px-3 py-1 text-xs bg-blue-500 text-white rounded-full hover:bg-blue-600 focus:outline-none"
            >
                Show {{ post.comments_count }} comments
            </button>
            <button
                v-if="post.comments_count && isShowed"
                @click.prevent="isShowed = false"
                class="px-3 py-1 text-xs bg-blue-500 text-white rounded-full hover:bg-blue-600 focus:outline-none"
            >
                Hide comments
            </button>
            <div v-if="comments && isShowed" class="space-y-4 mt-4">
                <div
                    v-for="comment in comments"
                    :key="comment.id"
                    class="bg-white p-4 rounded-lg shadow-sm"
                >
                    <p class="text-gray-700">
                        <span class="text-sky-400">
                            {{
                                comment.answerd_for_user
                                    ? comment.answerd_for_user + " ,"
                                    : ""
                            }}
                        </span>
                        {{ comment.body }}
                    </p>
                    <div class="flex justify-between">
                        <div class="flex">
                            <a
                                href="#"
                                @click.prevent="setCommentReply(comment)"
                                class="text-sm text-sky-400"
                                >Reply to</a
                            >
                            <p class="text-sm text-gray-500 ml-3">
                                Author: {{ comment.user.name }}
                            </p>
                        </div>

                        <p class="text-sm text-gray-500">
                            {{ comment.date }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="space-y-4">
                <div>
                    <div v-if="commentReply" class="flex justify-between">
                        <p class="ml-2">
                            Replied to {{ commentReply.user.name }}
                        </p>
                        <p
                            @click="commentReply = null"
                            class="cursor-pointer text-sm mr-2 text-sky-500"
                        >
                            Cancel
                        </p>
                    </div>
                    <input
                        v-model="body"
                        class="w-full border rounded-3xl border-gray-400 p-2 focus:border-green-500 focus:outline-none focus:ring"
                        type="text"
                        placeholder="Your comment here"
                    />
                </div>
                <a
                    @click.prevent="comment(post)"
                    href="#"
                    class="block w-full p-2 bg-green-500 text-white text-center rounded-3xl border text-sm hover:bg-green-600 transition-colors duration-200"
                >
                    Comment the post
                </a>
            </div>
        </div>
    </div>
</template>

<script>
import { comment } from "postcss";

export default {
    name: "Post",
    props: ["post"],
    data() {
        return {
            title: "",
            content: "",
            body: "",
            is_repost: false,
            comments: [],
            isShowed: false,
            commentReply: null,
        };
    },
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
        openRepost() {
            if (this.$route.name == "user.personal") return;
            this.is_repost = !this.is_repost;
        },
        repost(post) {
            if (this.$route.name == "user.personal") return;
            axios
                .post(`/api/posts/${post.id}/repost`, {
                    title: this.title,
                    content: this.content,
                })
                .then((res) => {
                    this.title = null;
                    this.content = null;
                    this.is_repost = false;
                    post.reposted_by_posts_count++;
                });
        },
        getComments(post) {
            axios.get(`/api/posts/${post.id}/comments`).then((res) => {
                this.comments = res.data.data;
                this.isShowed = true;
            });
        },
        comment(post) {
            axios
                .post(`/api/posts/${post.id}/add_comment`, {
                    body: this.body,
                    parent_id: this.commentReply ? this.commentReply.id : null,
                })
                .then((res) => {
                    this.isShowed = true;
                    this.body = "";
                    this.comments.unshift(res.data.data);
                    this.parentId = null;
                    post.comments_count++;
                });
        },
        setCommentReply(comment) {
            this.commentReply = comment;
        },
    },
};
</script>

<style scoped></style>
