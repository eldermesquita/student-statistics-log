<template>
    <div>
        <input
            v-if="edit"
            :value="value"
            @input="$emit('input', $event.target.value)"
            @keyup.enter="save($event.target.value)"
            class="grade-input"
            autofocus
            v-click-outside="edit = false"
        />
        <span v-else @click="edit = true" class="grade-text">
            {{ value }}
        </span>
        <v-text-field></v-text-field>
    </div>
</template>

<script>
export default {
    props: [
        'value',
        'input-class',
        'text-class'
    ],
    data () {
        return {
            edit: false,
        }
    },
    methods: {
        save (value) {
            this.$emit('input', value)
            this.edit = false
        }
    }
}
</script>

<style scoped>
    .grade-text {
        display: block;
        width: 100%;
        height: 100%;
        padding: 10px;
    }
    .grade-input {
        width: 100%;
        outline: none;
        border-top: 1px;
        border-bottom: 1px;
    }
</style>
