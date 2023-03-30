<template>
    <div class="md:container md:mx-auto">
        <div v-for="(reply , index) in items" :key="reply.id">
            <reply :reply="reply" @deleted="remove(index)"></reply>
        </div>
    </div>
    <paginator :dataSet="dataSet" @changed="fetch"></paginator>
    <new-reply  @created="add"></new-reply>
</template>

<script>
import Reply from './Reply';
import collection from '../mixins/Collection';

export default {
    props: ['replies'],
    components: {Reply},
    mixins: [collection],

    data() {
        return {
            dataSet:false,
        }
    },
    created() {
        this.fetch();
    },
    methods: {
        fetch(page) {
          axios.get(this.url(page))
          .then(this.refresh)
        },
        url(page) {
            if (!page) {
                let query = location.search.match(/page=(\d+)/);
                page = query ? query[1] : 1;
            }
           return `${location.pathname}/replies?page=${page}`;
        },
        refresh({data}) {
            this.dataSet = data;
            this.items = data.data;
        },
    }

}
</script>

<style scoped>

</style>
