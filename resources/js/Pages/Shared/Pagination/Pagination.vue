<template>
    <v-pagination
        v-model="meta.current_page"
        :length="meta.last_page"
        :total-visible="5"
        class="mt-5"
        @input="changePage"
    ></v-pagination>
</template>

<script>
export default {
    props: {
        meta: Object,
        link: String
    },
    data () {
        return {

        }
    },
    methods: {
        changePage (pagination) {
            this.$inertia.get(route(this.link), {
                page: pagination
            })
        }
    }
}
</script>

<style scoped>

</style>
