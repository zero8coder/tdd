<template>
    <div class="md:container md:mx-auto" v-if="shouldPaginate">
        <div class="space-y-4">
            <div class="max-w-md mx-auto md:max-w-2xl p-8">
                <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
                    <a v-show="prevUrl" @click.prevent="page--" href="#"
                       class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                        <span class="sr-only">Previous</span>
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                  d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z"
                                  clip-rule="evenodd"/>
                        </svg>
                    </a>

                    <a v-show="nextUrl" @click.prevent="page++" href="#"
                       class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                        <span class="sr-only">Next</span>
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                  d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z"
                                  clip-rule="evenodd"/>
                        </svg>
                    </a>
                </nav>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['dataSet'],
    emits: ['changed'],
    data() {
        return {
            page: 1,
            prevUrl: '',
            nextUrl: ''
        }
    },

    watch: {
        dataSet() {
            this.page = this.dataSet.current_page;
            this.prevUrl = this.dataSet.prev_page_url;
            this.nextUrl = this.dataSet.next_page_url;
        },

        page() {
            this.broadcast();
            this.updateUrl()
        }
    },

    computed: {
        shouldPaginate() {
            return !!this.prevUrl || !!this.nextUrl;
        }
    },

    methods: {
        broadcast() {
            return this.$emit('changed', this.page);
        },

        updateUrl() {
            history.pushState(null, null, '?page=' + this.page);
        }
    }
}
</script>
