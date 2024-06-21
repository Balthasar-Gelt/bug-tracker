<template>
    <div class="card">
        <header
            :class="[{ 'has-background-primary-light': stage.is_final }, 'card-header', 'is-flex', 'is-align-items-center']">

            <p :id="stage.id" v-on:blur="updateStage" v-on:keydown.enter="updateStage" class="card-header-title">
                {{ stage.name }}
            </p>

            <figure class="image is-24x24" v-if="stage.is_final">
                <img class="is-rounded is-cursor-pointer" title="This stage is final" src="/images/important.svg" />
            </figure>

            <a class="card-header-icon has-text-link" @click="$emit('showEditStageForm', stage)">
                Edit
            </a>

            <inertia-link :onBefore="deleteConfirm" class="card-header-icon has-text-danger"
                :href="route('projects.stages.destroy', [stage.project, stage])" method="delete" type="button">
                Delete
            </inertia-link>
        </header>

        <div class="card-content bugs-wrapper">
            <div class="content is-bug-wrapper has-default-height" :stage="stage.id">
                <bug v-for="bug in stage.bugs" v-bind:key="bug.id" :bug="bug" :stage="stage" :project="stage.project"
                    @show-edit-bug-form="$emit('showEditBugForm', bug)">
                </bug>
            </div>
        </div>
    </div>
</template>

<script>

import Bug from './Bug.vue';

export default {
    props: ['stage', 'user'],
    components: {
        Bug,
    },
    data() {
        return {
            form: this.$inertia.form({
                name: '',
            }),
            nameElement: '',
        }
    },
    mounted() {
        this.nameElement = document.getElementById(this.stage.id);
    },
    methods: {
        editStage() {
            this.nameElement.setAttribute('contenteditable', true);
            this.nameElement.focus();
        },
        updateStage() {
            this.nameElement.setAttribute('contenteditable', false);

            this.form.name = this.nameElement.innerHTML;
            this.form.patch(this.route('projects.stages.update', [this.stage.project, this.stage]))
        },
        updateStagePosition(operand) {
            this.$inertia.patch(this.route(
                'projects.stages-serial-number.update', {
                project: this.stage.project,
                stages_serial_number: this.stage
            }), {
                operator: operand
            })
        },
        deleteConfirm() {
            return confirm('Are you sure you want to delete the stage?');
        },
    },
}
</script>

<style>
.card-header-title {
    display: inline-block;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
</style>
