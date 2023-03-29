<template>
    <div class="md:container md:mx-auto">
        <div class="space-y-4 p-2">
            <div class="max-w-md mx-auto bg-white rounded-xl shadow-md overflow-hidden md:max-w-2xl p-8">
                <article>
                    <div class="mt-1 block relative">
                        <span class="left-0"> <a
                            class="text-lg leading-tight font-medium text-black hover:underline"
                            :href="'/profiles/'+thread.creator.name"
                            v-text="thread.creator.name"></a>发表了{{ thread.title }}
                        </span>
                        <span class="absolute right-0" @click="dxestroy">
                             <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                  stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                  <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                             </svg>
                        </span>
                    </div>
                    <p class="mt-2 text-gray-500">{{ thread.body }}</p>
                </article>
            </div>
        </div>

        <Replies :replies="replies"></Replies>

        <div class="space-y-4 p-2" v-if="signIn">
            <div class="max-w-md mx-auto bg-white rounded-xl shadow-md overflow-hidden md:max-w-2xl p-8">
                <form method="post" :action="'/threads/'+ thread.channel.name + '/' + thread.id + '/replies'">
                    <div class="grid grid-cols-1 gap-y-6 gap-x-8 sm:grid-cols-2">
                        <div class="sm:col-span-2">
                            <label for="body" class="block text-sm font-semibold leading-6 text-gray-900">回复</label>
                            <div class="mt-2.5">
                                <textarea name="body" id="body" rows="4"
                                          class="block w-full rounded-md border-0 py-2 px-3.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"/>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="_token" :value="csrfToken">

                    <div class="mt-10">
                        <button type="submit"
                                class="block w-full rounded-md bg-indigo-600 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                            提交
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div v-else>
            <p class="text-center">请先<a href="/login">登录</a>，然后再发表回复 </p>
        </div>
    </div>
</template>

<script>
import Replies from '../components/Replies';

export default {
    name: "Thread",
    components: {Replies},
    props: ["thread", "replies"],
    data() {
        return {
            can_deleting: true,
        }
    },
    computed: {
        signIn() {
            return window.App.signIn;
        },
        csrfToken() {
            return window.App.csrfToken;
        }
    },

    methods: {
        destroy() {
            axios.delete('/threads/' + this.thread.channel.name + '/' + this.thread.id);
        }
    }
}
</script>

<style scoped>

</style>
