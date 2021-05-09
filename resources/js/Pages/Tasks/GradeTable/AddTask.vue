<template>
    <div class="add-task">
        <v-btn
            fab
            x-small
            color="primary"
            class="ml-1"
            @click="isOpen = true"
        >
            <v-icon dark>
                mdi-plus
            </v-icon>
        </v-btn>
        <v-fade-transition>
            <v-card
                class="add-task__form"
                v-if="isOpen"
                v-click-outside="close"
            >
                <v-icon
                    class="add-task__close-btn"
                    @click="close"
                >
                    mdi-close
                </v-icon>
                <v-card-text>
                    <v-form>
                        <v-text-field
                            label="Номер"
                            type="number"
                        >
                        </v-text-field>
                        <v-text-field
                            label="Макс. знач."
                            type="number"
                        >
                        </v-text-field>
                        <v-text-field
                            label="Мин. знач"
                            type="number"
                        >
                        </v-text-field>
                        <v-btn
                            small
                            class="primary"
                        >
                            Создать
                        </v-btn>
                    </v-form>
                </v-card-text>
            </v-card>
        </v-fade-transition>
    </div>
</template>

<script>
export default {
    data () {
        return {
            isOpen: false
        }
    },
    methods: {
        close () {
            this.isOpen = false
        }
    }
}
</script>

<style scoped>
    .add-task {
        position: relative;
    }
    .add-task__form {
        position: absolute;
        top: 0;
        min-width: 240px;
        max-width: 240px;
    }
    .add-task__close-btn {
        position: absolute;
        right: 5px;
        top: 5px
    }
</style>
