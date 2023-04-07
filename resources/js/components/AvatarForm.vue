<template>
    <div class="space-y-4 p-2">
        <h1 v-text="user.name"></h1>
        <div v-if="canUpdate" class="max-w-md mx-auto bg-white rounded-xl shadow-md overflow-hidden md:max-w-2xl p-8">
            <form method="POST"  enctype="multipart/form-data">
                <image-upload name="avatar"  @loaded="onLoad"></image-upload>
            </form>
        </div>
        <div class="flex max-w-md mx-auto bg-white rounded-xl shadow-md overflow-hidden md:max-w-2xl p-8">
            <img :src="avatar"  width="200" height="200">
        </div>

    </div>
</template>

<script>
import ImageUpload from './ImageUpload.vue';

export default {
    name: "AvatarForm",
    props: ['user'],
    components: { ImageUpload },

    data() {
        return {
            avatar: '/'+this.user.user_avatar
        }
    },
    computed: {
        canUpdate() {
            return window.App.signIn && this.user.id === window.App.user.id;
        }
    },
    methods: {
        onLoad(avatar){
            this.avatar = avatar.src;
            this.persist(avatar.file);
        },

        persist(avatar) {
            let data = new FormData();
            data.append('avatar', avatar);
            axios.post(`/api/users/${this.user.name}/avatar`, data)
            .then(() => function () {
                console.log('成功')
                // todo 提示flash
            });
        }
    }
}
</script>

<style scoped>

</style>
