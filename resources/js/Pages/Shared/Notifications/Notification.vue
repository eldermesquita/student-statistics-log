<template>
    <div>
        <v-snackbar
            v-for="(flash, index) in currentFlashes"
            :key="index"
            v-model="flash.showing"
            top
            timeout="2000"
            app
            :color="flash.color"
        >
            {{ flash.text }}

            <template v-slot:action="{ attrs }">
                <v-btn
                    text
                    v-bind="attrs"
                    @click="flash.showing = false"
                    small
                >
                    <v-icon dense>mdi-close</v-icon>
                </v-btn>
            </template>
        </v-snackbar>
    </div>
</template>

<script>
export default {
    data () {
        return {
            currentFlashes: []
        }
    },
    watch: {
        '$page.props.flash': {
            handler() {
                this.generateFlashes()
            },
            deep: true,
        },
        currentFlashes: _.debounce((flashes) => {
            flashes[flashes.length - 1].showing = true
        }, 5)
    },
    created() {
        this.generateFlashes()
    },
    methods: {
        generateFlashes () {
            for (let key in this.$page.props.flashes) {
                if (this.$page.props.flashes[key] != null) {
                    this.currentFlashes.push({
                        showing: false,
                        color: key,
                        text: this.$page.props.flashes[key]
                    })
                }
            }
        }
    }
}
</script>

<style scoped>

</style>
