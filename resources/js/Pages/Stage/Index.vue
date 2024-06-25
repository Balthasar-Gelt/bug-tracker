<template>
    <div>
        <h1 class="title">{{ project.name }}</h1>

        <div v-if="0" id="overlay"></div>

        <bug-add-form :priorities="priorities" :project="project" :stage="stages[0]"
            @close-add-bug-form="closeForm('bug', 'add')" :class="{ 'is-active': modals.bug.add }"
            v-if="modals.bug.add" />

        <bug-edit-form :bug="editBug" :project="project" :priorities="priorities"
            @close-edit-bug-form="closeForm('bug', 'edit')" :class="{ 'is-active': modals.bug.edit }"
            v-if="modals.bug.edit" />

        <stage-add-form :project="project" @close-add-stage-form="closeForm('stage', 'add')"
            :class="{ 'is-active': modals.stage.add }" v-if="modals.stage.add" />

        <stage-edit-form :stage="editStage" @close-edit-stage-form="closeForm('stage', 'edit')"
            :class="{ 'is-active': modals.stage.edit }" v-if="modals.stage.edit" />

        <h1 v-if="stages.length <= 0" class="has-text-danger is-size-3 mt-6 has-text-weight-medium">No Stages in this
            project!</h1>

        <ul class="columns stages pb-5 has-margin-bottom-navbar">
            <li class="column is-one-quarter" v-for="stage in stages" v-bind:key="stage.id">
                <stage :index="stage.id" @show-edit-bug-form="(bug) => { openForm('bug', 'edit'); editBug = bug; }"
                    @show-edit-stage-form="(stage) => { openForm('stage', 'edit'); editStage = stage }" :stage="stage"
                    :user="auth.user">
                </stage>
            </li>
        </ul>

        <div class="navbar is-fixed-bottom container">
            <div class="section pl-2-5 pt-2 pb-2">
                <a class="mr-5 button is-primary" @click="openForm('bug', 'add')"
                    v-if="auth.user.id == project.created_by.id && stages.length > 0">
                    New Bug
                </a>

                <inertia-link class="button mr-5 is-info"
                    :href="route('projects.project-user.index', { project: project })">
                    Members
                </inertia-link>

                <a class="button is-link" @click="openForm('stage', 'add')"
                    v-if="auth.user.id == project.created_by.id">
                    Add Stage
                </a>
            </div>
        </div>
    </div>
</template>

<script>

import Layout from '../../Layouts/Authenticated.vue';
import Stage from '../../Components/Stage.vue';
import BugAddForm from '@/Components/Bug/AddForm.vue';
import BugEditForm from '@/Components/Bug/EditForm.vue';
import StageAddForm from '@/Components/Stage/AddForm.vue';
import StageEditForm from '@/Components/Stage/EditForm.vue';
import breezeValidationErrors from '@/Components/ValidationErrors.vue';
import dragula from 'dragula';
import axios from 'axios';

export default {
    layout: Layout,
    props: ['stages', 'project', 'auth', 'priorities'],
    mounted() {
        document.addEventListener('DOMContentLoaded', (e) => {
            let drakeBugs = dragula({
                isContainer: function (el) {
                    return el.classList.contains('is-bug-wrapper');
                }
            });

            drakeBugs.on('drop', (el, target, source, sibling) => {
                axios.patch(this.route('updatePosition', { project: this.project, stage: el.getAttribute('stage'), bug: el.getAttribute('bug') }), {
                    sibling_id: sibling?.getAttribute('bug') || null,
                    target_id: target.getAttribute('stage'),
                });
            });
        })
    },
    data() {
        return {
            modals: {
                bug: { add: false, edit: false },
                stage: { add: false, edit: false }
            },
            showNewBugModal: false,
            showEditBugModal: false,
            editBug: null,
        }
    },
    components: {
        stage: Stage,
        breezeValidationErrors,
        BugAddForm,
        BugEditForm,
        StageAddForm,
        StageEditForm,
    },
    methods: {
        openForm(type, value) {
            if (!this.modals[type][value]) {
                this.modals[type][value] = true;
            }
        },
        closeForm(type, value) {
            if (this.modals[type][value]) {
                this.modals[type][value] = false;
            }
        },
    },
}

</script>

<style lang="css" scoped>
.stages {
    overflow-x: scroll;
}

::-webkit-scrollbar {
    height: 12px;
    background-color: #ffffff;
    cursor: pointer;
}

::-webkit-scrollbar-thumb {
    background-color: rgb(228, 228, 228);
    border-radius: 3px;
}

::-webkit-scrollbar-thumb:hover {
    background-color: rgb(216, 216, 216);
}

::-webkit-scrollbar-button:end:increment,
::-webkit-scrollbar-button:start:decrement {
    width: .75rem;
}

.navbar.is-fixed-bottom {
    z-index: 28 !important;
}

#overlay {
    background: rgba(0, 0, 0, 0.685);
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    z-index: 29;
}

.has-margin-bottom-navbar {
    padding-bottom: 3.25rem !important
}
</style>
