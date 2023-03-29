<template>
    <div v-for="(reply , index) in items">
        <reply :reply="reply" @deleted="remove(index)"></reply>
    </div>
</template>

<script>
import Reply from './Reply';

export default {
    props: ['replies'],
    components: {Reply},
    data() {
        return {
            items: this.replies
        }
    },
    methods: {
        remove(index) {
            this.items.splice(index,1);

        }
    }

}
</script>

<style scoped>

</style>
