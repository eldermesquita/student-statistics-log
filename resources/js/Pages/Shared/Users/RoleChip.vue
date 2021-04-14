<template>
    <v-chip
        link
        label
        :color="color"
        small
    >{{ label }}</v-chip>
</template>

<script>
export default {
    props: {
        role: String
    },
    data () {
        return {
            obj: {},
            roles: [
                {
                    name: 'guest',
                    label: 'Гость',
                    color: 'gray'
                },
                {
                    name: 'admin',
                    label: 'Администр.',
                    color: 'red'
                },
                {
                    name: 'teacher',
                    label: 'Учитель',
                    color: 'orange'
                },
            ]
        }
    },
    mounted() {
        this.obj = this.roles.find(v => v.name === this.role)
    },
    computed: {
        label () {
            return this.obj.label || this.role
        },
        color () {
            return this.obj.color || 'gray'
        }
    }
}
</script>

<style scoped>

</style>
