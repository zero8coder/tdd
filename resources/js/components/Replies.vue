<template>
    <div v-for="reply in replies">
        <reply :reply="reply"></reply>
    </div>
</template>

<script>
import Reply from './Reply';

export default {
    props: ['replies'],

    components: {Reply},

}
</script>

<style scoped>

</style>
