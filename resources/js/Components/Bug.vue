<template>
    <div class="card mb-3" :bug="bug.id" :stage="stage.id">
        <div class="card-content p-3">
            <div class="content">
                <div class="is-flex is-justify-content-space-between is-align-items-flex-start">
                    <inertia-link :href="route('projects.stages.bugs.show', { project: project, stage: stage, bug: bug })"
                        class="has-text-weight-semibold has-text-link mb-3">{{ bug.name }}</inertia-link>
                    <inertia-link :onBefore="deleteConfirm" class="delete has-background-danger ml-2" aria-label="close"
                        :href="route('projects.stages.bugs.destroy', { project: project, stage: stage, bug: bug })"
                        method="delete">
                    </inertia-link>
                </div>
                <p>{{ bug.short_description }}</p>

                <div class="mb-2 is-flex is-justify-content-flex-start is-align-items-flex-center is-size-7-5">
                    <span class="has-text-weight-medium">Assignee:</span>
                    <img v-if="bug.assignee" :title="bug.assignee.name" class="avatar is-28x28 ml-2"
                        :src="bug.assignee.icon">
                    <span class="is-inline-block ml-2" v-else>N/A</span>
                </div>

                <div class="is-flex is-justify-content-space-between is-align-items-flex-center mb-1">
                    <span class="has-text-weight-medium is-size-7-5">Priority: <strong
                            :class="priorities[bug.priority.name]">{{ bug.priority.name }}</strong></span>
                    <a @click="$emit('showEditBugForm')">Edit</a>
                </div>

            </div>
        </div>
    </div>
</template>

<script>

import { priorities } from '../Other/Priorities';

export default {
    props: ['project', 'stage', 'bug'],
    data() {
        return {
            priorities: priorities,
        }
    },
    methods: {
        updateBugStage(val) {
            this.$inertia.patch(this.route('projects.stages.bug-stage.update', {
                project: this.project, stage: this.stage, bug_stage: this.bug
            }), {
                operator: val,
            }
            )
        },
        deleteConfirm() {
            return confirm('Are you sure you want to delete the bug?');
        },
    },
}
</script>

<style scoped></style>