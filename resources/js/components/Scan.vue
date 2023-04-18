<template>
    <div class="md:container md:mx-auto">
        <div class="space-y-4 p-2">
        <ais-instant-search :search-client="searchClient" index-name="threads">
            <ais-search-box />
            <ais-hits>
                <template v-slot:item="{ item }">
                    <p>
                        <a :href="item.path">
                            {{ item.title }}
                        </a>
                    </p>
                </template>
            </ais-hits>
        </ais-instant-search>
        </div>
    </div>
</template>

<script>
import algoliasearch from 'algoliasearch/lite';

export default {
    props: ["appid", "appkey"],
    data() {
        return {
            searchClient: algoliasearch(
                this.appid,
                this.appkey
            ),
        };
    },
};
</script>

<style scoped>

</style>
