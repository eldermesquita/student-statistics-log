<template>
    <div>
        <input
            v-if="edit"
            :value="value"
            @input="$emit('input', $event.target.value)"
            @keyup.enter="save($event.target.value)"
            :class="inputClass"
            autofocus
        />
        <span :class="textClass" v-else @click="edit = true">
            {{ value }}
        </span>
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

</style>
