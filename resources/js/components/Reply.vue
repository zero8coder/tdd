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

                <div class="mt-2 text-gray-500"  v-if="editing">
                    <textarea v-model="body" class="mt-2 text-gray-500  w-full rounded-md border-0 py-2 px-3.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"  rows="4"></textarea>
                    <button @click="update" type="submit"
                            class="block w-full rounded-md bg-indigo-600 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        修改
                    </button>
                </div>

                <div class="mt-2 text-gray-500" v-else>
                    <p class="mt-2 text-gray-500">{{ body }}</p>
                </div>
                <div class="mt-3 block relative" v-if="isOwner">
                    <!-- 修改 -->
                     <span class="absolute left-0 text-gray-500 " @click="editing=true">
                         <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                              stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/>
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
    data() {
        return {
            editing: false,
            id: this.reply.id,
            body: this.reply.body,
            isFavourite: false
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
            });
            this.editing = false;
        },

        destroy() {
            axios.delete('/replies/' + this.id);
        },

        favourite() {
            axios.post('/replies/' + this.id + '/favorites', {
                user: window.App.user.id
            });

        }
    }

}
</script>

<style scoped>

</style>
