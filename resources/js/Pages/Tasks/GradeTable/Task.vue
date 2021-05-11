<template>
    <div>
        <div
            @click="taskCardOpen"
            v-click-outside="taskCardClose"
            class="task">
            <div class="d-flex align-center justify-center">
                <span>{{ number }}</span>
                <span v-if="postfix" class="vertical-header">
                ({{postfix }})
            </span>
            </div>
            <div class="score-descr d-flex flex-column text--secondary">
            <span>
                Ми: {{ min_score }}
            </span>
                <span>
                Ма: {{ max_score }}
            </span>
            </div>
        </div>
        <v-fade-transition>
            <v-card
                v-if="isTaskCardOpen"
                class="task-dropdown-card"
                max-width="240"
            >
                <v-card-text class="d-flex align-center flex-column">
                    <ChangeSort @sorted="taskCardClose" :id="id"/>
                    <v-btn
                        small
                        color="error"
                        @click="remove"
                    >
                        Удалить
                    </v-btn>
                </v-card-text>
            </v-card>
        </v-fade-transition>
    </div>
</template>

<script>
import ChangeSort from "./ChangeSort";
export default {
    components: {ChangeSort},
    props: {
        'id': Number,
        'number': Number,
        'postfix': String,
        'min_score': Number,
        'max_score': Number
    },
    data () {
        return {
            isTaskCardOpen: false,
            process: true
        }
    },
    methods: {
        taskCardClose() {
            this.isTaskCardOpen = false
        },
        taskCardOpen() {
            this.isTaskCardOpen = true
        },
        remove() {
            this.process = true;
            this.$inertia.delete(this.route('tasks.destroy', this.id), {
                onFinish: () => {
                    this.process = false
                }
            })
        }
    }
}
</script>

<style scoped>
.task {
    cursor: pointer;
}

.score-descr {
    line-height: 1;
    font-size: .7rem;
}

.task-dropdown-card {
    position: absolute;
    top: 100%;
    right: 50%;
    transform: translateX(50%);
    z-index: 10;
}
</style>
