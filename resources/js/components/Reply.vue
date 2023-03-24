<template>
    <div class="space-y-4 p-2 " id="'reply-{{ id }}">
        <div class="max-w-md mx-auto bg-white rounded-xl shadow-md overflow-hidden md:max-w-2xl p-8">
            <article>
                <div class="mt-1 block relative">
                                    <span class="left-0"> <a
                                        class="text-lg leading-tight font-medium text-black hover:underline"
                                        :href="'/profiles/'+reply.owner.name"
                                        v-text="reply.owner.name">
                </a>回复于 {{ reply.created_at_see }}
                                    </span>
                </div>
                <p class="mt-2 text-gray-500">{{ body }}</p>
            </article>
        </div>
    </div>
</template>

<script>
import Favorite from './Favorite.vue';

export default {
    props: ['reply'],
    components: {Favorite},
    data() {
        return {
            editing: false,
            id: this.reply.id,
            body: this.reply.body
        };
    },

    methods: {
        update() {
            axios.patch('/replies/' + this.attributes.id, {
                body: this.body
            });

            this.editing = false;

            flash('Updated!');
        },

        destroy() {
            axios.delete('/replies/' + this.attributes.id);

            $(this.$el).fadeOut(300, () => {
                flash('Your reply has been deleted!');
            });
        }
    }

}
</script>

<style scoped>

</style>
