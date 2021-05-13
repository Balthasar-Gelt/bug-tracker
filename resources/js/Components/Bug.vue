<template>
    <div  class="card mb-3">

        <div class="card-content p-3">
            <div class="content">
                <p class="has-text-weight-semibold">{{bug.name}}</p>
                <p>Priority: <strong :class="priorities[bug.priority.name]">{{bug.priority.name}}</strong></p>
            </div>
        </div>


        <footer class="card-footer">
            <a v-on:click.prevent="updateBugStage('down')" class="card-footer-item">&lt;</a>

            <inertia-link 
                class="card-footer-item" 
                :href="route('projects.stages.bugs.edit', {project: project, stage: stage, bug: bug})">
                Edit
            </inertia-link>

            <inertia-link 
                class="has-text-danger card-footer-item" 
                :href="route('projects.stages.bugs.destroy', {project: project, stage: stage, bug: bug})" 
                method="delete" 
                type="button">
                Delete
            </inertia-link>

            <a v-on:click.prevent="updateBugStage('up')" class="card-footer-item">></a>
        </footer>
    </div>
</template>

<script>

    import {priorities} from '../Other/Priorities';

    export default {
        props: ['project', 'stage', 'bug'],
        data() {
            return {
                priorities: priorities,
            }
        },
        methods: {
            updateBugStage(val){

                this.$inertia.patch(this.route('projects.stages.bug-stage.update', { 
                    project: this.project, stage: this.stage, bug_stage: this.bug 
                    }), {
                        operator: val,
                    }
                )
            }
        },
    }
</script>

<style scoped>

</style>