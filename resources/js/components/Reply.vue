`
<template>
    <div class="space-y-4 p-2 " id="'reply-{{ id }}">
        <div class="max-w-md mx-auto bg-white rounded-xl shadow-md overflow-hidden md:max-w-2xl p-8">
            <article>
                <div class="mt-1 block relative">
                    <span class="left-0"> <a
                        class="text-lg leading-tight font-medium text-black hover:underline"
                        :href="'/profiles/'+reply.owner.name"
                        v-text="reply.owner.name">
                         </a>回复于 {{ reply.created_at_see }}
                     </span>
                    <!-- 点赞 -->
                    <favorite :reply="reply"></favorite>

                </div>

                <div class="mt-2 text-gray-500" v-if="editing">
                    <textarea v-model="body"
                              class="mt-2 text-gray-500  w-full rounded-md border-0 py-2 px-3.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                              rows="4"></textarea>
                    <button @click="update" type="submit"
                            class="w-2/5 m-2 rounded-md bg-indigo-600 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        修改
                    </button>
                    <button @click="cancelReply" type="submit"
                            class="w-2/5 m-2 rounded-md bg-red-600 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        取消
                    </button>
                </div>

                <div class="mt-2 text-gray-500" v-else>
                    <p class="mt-2 text-gray-500" v-html="body"></p>
                </div>
                <div class="mt-3 block relative" v-if="isOwner">
                    <!-- 修改 -->
                    <span class="absolute left-0 text-gray-500 " @click="editReply">
                         <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                              stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/>
                        </svg>
                     </span>

                    <!-- 删除 -->
                    <span class="absolute left-10 text-gray-500" @click="destroy">
                             <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                  stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                  <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                             </svg>
                    </span>
                    <!-- 删除 -->
                    <span v-if="!isBest" class="absolute left-20 text-gray-500" @click="markBestReply">
                             <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                  stroke="currentColor" class="w-6 h-6">
  <path stroke-linecap="round" stroke-linejoin="round"
        d="M6.633 10.5c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 012.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 00.322-1.672V3a.75.75 0 01.75-.75A2.25 2.25 0 0116.5 4.5c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 01-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 00-1.423-.23H5.904M14.25 9h2.25M5.904 18.75c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 01-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 10.203 4.167 9.75 5 9.75h1.053c.472 0 .745.556.5.96a8.958 8.958 0 00-1.302 4.665c0 1.194.232 2.333.654 3.375z"/>
</svg>
                    </span>

                    <span v-else class="absolute left-20 text-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                        <path
                            d="M7.493 18.75c-.425 0-.82-.236-.975-.632A7.48 7.48 0 016 15.375c0-1.75.599-3.358 1.602-4.634.151-.192.373-.309.6-.397.473-.183.89-.514 1.212-.924a9.042 9.042 0 012.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 00.322-1.672V3a.75.75 0 01.75-.75 2.25 2.25 0 012.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 01-2.649 7.521c-.388.482-.987.729-1.605.729H14.23c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 00-1.423-.23h-.777zM2.331 10.977a11.969 11.969 0 00-.831 4.398 12 12 0 00.52 3.507c.26.85 1.084 1.368 1.973 1.368H4.9c.445 0 .72-.498.523-.898a8.963 8.963 0 01-.924-3.977c0-1.708.476-3.305 1.302-4.666.245-.403-.028-.959-.5-.959H4.25c-.832 0-1.612.453-1.918 1.227z"/>
                    </svg>
                    </span>


                </div>
            </article>
        </div>
    </div>
</template>

<script>
import Favorite from './Favorite.vue';

export default {
    props: ['reply'],
    components: {Favorite},
    emits: ['deleted', 'best-reply-selected'],
    data() {
        return {
            editing: false,
            id: this.reply.id,
            body: this.reply.body,
            isFavourite: false,
            isBest: this.reply.isBest
        };
    },
    computed: {
        signIn() {
            return window.App.signIn;
        },
        csrfToken() {
            return window.App.csrfToken;
        },
        user() {
            return window.App.user;
        },
        isOwner() {
            return window.App.signIn && this.reply.user_id == window.App.user.id;
        }

    },
    methods: {
        update() {
            axios.patch('/replies/' + this.id, {
                body: this.body
            }).catch(error => {
                // todo flash
            });
            this.editing = false;
        },

        destroy() {
            axios.delete('/replies/' + this.id);
            this.$emit('deleted');
        },

        favourite() {
            axios.post('/replies/' + this.id + '/favorites', {
                user: window.App.user.id
            });

        },
        editReply() {
            this.old_body_data = this.body;
            this.editing = true;
        },
        cancelReply() {
            this.body = this.old_body_data;
            this.old_body_data = '';
            this.editing = false;
        },
        markBestReply() {
            this.isBest = true;
            axios.post('/replies/' + this.reply.id + '/best');
            this.$emit('best-reply-selected', this.reply.id);
        },

    }

}
</script>

<style scoped>

</style>
`
