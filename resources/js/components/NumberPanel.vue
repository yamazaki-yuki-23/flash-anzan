<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <p class="score">Score {{ score }}</p>
                    <p v-if="'show' === mode" class="number" :class="{ '-hidden': hidden }">{{ number }}</p>
                    <form v-else class="input-panel" method="POST" :action="url" @submit="onSubmit($event)">
                        <slot></slot>
                        <input type="hidden" name="score" v-model="score">
                        <div class="form-group">
                            <label for="answer">答えを入力してください（半角数字）</label>
                            <input type="tel" class="form-control" ref="answer" v-model.number="answer">
                            <transition name="switch" mode="out-in">
                                <div v-if="'input' === mode" key="input" class="mt-3">
                                    <button type="submit" class="btn btn-primary btn-block" :disabled="'' === answer">決定</button>
                                </div>
                                <div v-else-if="is_correct" key="correct" class="result mt-3">
                                    <p class="result__text -correct alert alert-success"><span class="result__icon -correct">〇</span>正解！</p>
                                    <button type="submit" class="btn btn-primary btn-block">次の問題へ</button>
                                </div>
                                <div v-else key="incorrect" class="result mt-3">
                                    <div class="alert alert-danger">
                                        <p class="result__text -incorrect mb-0"><span class="result__icon -incorrect">×</span>残念</p>
                                        <p class="result__answer mb-0">正解は、{{ correct_answer }}でした</p>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-block">スコアを送信</button>
                                </div>
                            </transition>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { setTimeout } from 'timers';
export default {
    props: ['url'],
    data() {
        return {
            mode: 'show',
            score: 0,
            number: 0,
            answer: '',
            correct_answer: 0,
            is_correct: false,
            hidden: true,
            index: 0,
            interval: 500,
            numbers: [],
            option: null,
            state: []
        };
    },
    created() {
        const option = document.getElementById('play_option');
        if (option) {
            this.option = JSON.parse(option.innerHTML);
        }
        this.state = this.option.shift();
    },
    mounted() {
        this.start();
    },
    methods: {
        start() {
            if (this.state.times >= 0) {
                if (this.state.times > 0) {
                    this.state.times--;
                }
                else {
                    this.state = this.option.shift();
                }
            }
            const lower = Math.pow(10, this.state.digits - 1);
            const upper = Math.pow(10, this.state.digits);
            const range = upper - lower;
            this.interval = this.state.interval >> 1;
            this.numbers.length = 0;
            for (let i = 0; i < this.state.quantity; i++) {
                let r = Math.floor( Math.random() * range ) + lower;
                this.numbers.push(r);
            }
            this.mode = 'show';
            this.index = 0;
            this.answer = '';
            setTimeout(() => this.showNextNumber(), 1000);
        },
        showNextNumber() {
            this.hidden = false;
            this.number = this.numbers[ this.index++ ];
            setTimeout(() => this.hideNumber(), this.interval);
        },
        hideNumber() {
            this.hidden = true;
            if (this.index < this.numbers.length) {
                setTimeout(() => this.showNextNumber(), this.interval);
            }
            else {
                setTimeout(() => this.toInputMode(), this.interval);
            }
        },
        toInputMode() {
            this.mode = 'input';
            setTimeout(() => this.$refs.answer.focus(), 0);
        },
        onSubmit(event) {
            if ('input' === this.mode) {
                this.is_correct = false;
                if ('number' === typeof this.answer) {
                    this.correct_answer = this.numbers.reduce((acc, cur) => acc + cur);
                    if (this.answer === this.correct_answer) {
                        this.is_correct = true;
                    }
                }
                if (this.is_correct) this.score++;
                this.mode = 'result';
                event.preventDefault();
            }
            else if ('result' === this.mode) {
                if (this.is_correct) {
                    this.start();
                    event.preventDefault();
                }
            }
        }
    }
}
</script>

<style lang="scss" scoped>
.switch-enter-active {
    transition: all 0.5s;
}
.switch-leave-active {
    transition: opacity 0.2s;
}
.switch-enter, .switch-leave-to {
    opacity: 0;
}
.switch-enter {
    transform: translateY(2rem);
}
.score {
    padding: 0.5rem 1rem 0;
    font-size: 1.25rem;
}
.number {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 10rem;
    font-size: 5rem;
    text-align: center;
    &.-hidden {
        visibility: hidden;
    }
}
.input-panel {
    position: relative;
    width: 25rem;
    max-width: 100%;
    margin-left: auto;
    margin-right: auto;
    padding: 1rem;
}
.result__text {
    font-size: 1.5rem;
    line-height: 1.2;
    &.-correct {
        color: var(--success);
    }
}
.result__icon {
    margin-right: 1rem;
    &.-correct {
        font-size: 2.5rem;
        vertical-align: -0.25rem;
    }
    &.-incorrect {
        font-size: 3rem;
        vertical-align: -0.25rem;
    }
}
.result__answer {
    padding-bottom: 0.5rem;
}
</style>
