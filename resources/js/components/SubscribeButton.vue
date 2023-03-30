<template>
    <button class="block rounded-md bg-indigo-600 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
    @click="subscribe">
        订阅
    </button>
</template>

<script>
export default {
    name: "SubscribeButton",
    props: ["isSubscribe"],
    data() {
        // return {
        //     isSubscribe:false
        // }
    },
    methods:{
        subscribe(){
            axios[(this.isSubscribe? 'delete':'post'), (location.pathname + '/subscriptions')]
            this.isSubscribe = !this.isSubscribe
        }
    }

}
</script>

