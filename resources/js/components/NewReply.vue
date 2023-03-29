<template>
    <div class="md:container md:mx-auto">
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
export default {
    name: "NewReply",
    props: ["thread"],
    data() {

    },
    computed: {
        signIn() {
            return window.App.signIn;
        },
        csrfToken() {
            return window.App.csrfToken;
        }
    }
}
</script>

<style scoped>

</style>
