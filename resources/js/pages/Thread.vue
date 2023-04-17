<template>
    <div class="md:container md:mx-auto">
        <div class="space-y-4 p-2">
            <div class="max-w-md mx-auto bg-white rounded-xl shadow-md overflow-hidden md:max-w-2xl p-8">
                <div v-if="editing">
                    <div class="mb-3">
                        <label class="block text-sm font-semibold leading-6 text-gray-900">标题</label>
                        <input v-model="form.title" type="text" class="form-control text-gray-900 shadow-sm" id="title" name="title"
                               required>
                    </div>
                    <div class="mb-3">
                        <label class="block text-sm font-semibold leading-6 text-gray-900">内容</label>
                        <textarea v-model="form.body" id="body" class="form-control text-gray-900 shadow-sm" rows="8"
                                  required></textarea>
                    </div>
                </div>
                <article v-else>
                    <div class="mt-1 block relative">
                        <span class="left-0 flex">
                            <img :src="'/'+thread.creator.user_avatar"  width="25" height="25">
                            <a
                                class="text-lg leading-tight font-medium text-black hover:underline"
                                :href="'/profiles/'+thread.creator.name"
                                v-text="thread.creator.name"></a>发表了{{ title }}
                        </span>


                    </div>
                    <p class="mt-2 text-gray-500">{{ body }}</p>
                </article>
                <hr class="mt-2">
                <span class="flex mt-2 block" v-if="editing">
                      <button @click="update"
                              class="rounded-md mr-1 bg-indigo-600 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                            更新
                     </button>
                     <button @click="resetForm"
                             class="rounded-md mr-1 bg-gray-400 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-sm hover:bg-gray-300 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                            取消
                     </button>

                    <button @click="destroy"
                            class="ml-auto rounded-md mr-1 bg-red-600 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                            删除
                     </button>

                </span>
                <span class="mt-2 block" v-else>
                        <button v-show="isOwn" @click="editing=true"
                            class="rounded-md mr-1 bg-indigo-600 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                            编辑
                        </button>
                        <subscribe-button :isSubscribe="thread.isSubscribedTo"></subscribe-button>
                    <button
                        class="rounded-md  mr-1 bg-indigo-600 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                        v-if="isAdmin" @click="toggleLock" v-text="locked ? '解锁' : '锁定'">
                    </button>
                </span>
            </div>
        </div>
    </div>
    <replies :locked="locked"> </replies>

</template>

<script>
import SubscribeButton from '../components/SubscribeButton';

export default {
    name: "Thread",
    props: ["thread"],
    components: {SubscribeButton},
    data() {
        return {
            editing:false,
            locked: this.thread.locked,
            can_deleting: true,
            title:this.thread.title,
            body:this.thread.body,
            form:{}
        }
    },
    created() {
        this.resetForm();
    },
    computed: {
        signIn() {
            return window.App.signIn;
        },
        csrfToken() {
            return window.App.csrfToken;
        },
        isOwn() {
            return window.App.signIn && window.App.user.name === this.thread.creator.name
        },
        isAdmin() {
            return true;
            // return window.App.signIn && window.App.user.name === '浩忠';
        }
    },

    methods: {
        destroy() {
            axios.delete('/threads/' + this.thread.channel.name + '/' + this.thread.id);
        },
        toggleLock() {
            axios[this.locked ? 'delete' : 'post']('/locked-threads/' + this.thread.slug);
            this.locked = ! this.locked;
        },
        update() {
            let uri = `/threads/${this.thread.channel.slug}/${this.thread.slug}`;
            axios.patch(uri, {
                title:this.form.title,
                body:this.form.body
            }).then(() => {
                this.editing = false;
                this.title = this.form.title;
                this.body = this.form.body;
            });

        },
        resetForm() {
            this.form.title = this.thread.title;
            this.form.body = this.thread.body;
            this.editing = false;
        }

    }
}
</script>

<style scoped>

</style>
