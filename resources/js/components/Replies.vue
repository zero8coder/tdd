<template>
    <div class="md:container md:mx-auto">
        <div v-for="(reply , index) in items">
            <reply :reply="reply" @deleted="remove(index)"></reply>
        </div>
    </div>
    <new-reply :endpoint="endpoint" @created="add"></new-reply>

</template>

<script>
import Reply from './Reply';

export default {
    props: ['replies'],
    components: {Reply},
    data() {
        return {
            items: this.replies,
            endpoint: location.pathname+'/replies'
        }
    },
    methods: {
        remove(index) {
            this.items.splice(index, 1);

        },
        add(reply){
            this.items.push(reply);
        }
    }

}
</script>

<style scoped>

</style>
