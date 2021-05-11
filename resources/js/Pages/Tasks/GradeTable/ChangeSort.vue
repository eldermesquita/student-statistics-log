<template>
    <div class="d-flex">
        <v-btn
            small
            icon
            @click="orderUp"
            class="grade-table__arrow grade-table__arrow--left"
        >
            <v-icon>mdi-arrow-left</v-icon>
        </v-btn>
        <v-btn
            small
            icon
            @click="orderDown"
            class="grade-table__arrow grade-table__arrow--right"
        >
            <v-icon>mdi-arrow-right</v-icon>
        </v-btn>
    </div>
</template>

<script>
export default {
    props: {
        id: Number
    },
    methods: {
        orderUp () {
            this.$inertia.put(this.route('tasks.up', this.id));
            this.$emit('sorted');
        },
        orderDown() {
            this.$inertia.put(this.route('tasks.down', this.id));
            this.$emit('sorted');
        }
    }
}
</script>

<style scoped>
    .grade-table__arrow {
        display: block;
    }
</style>
