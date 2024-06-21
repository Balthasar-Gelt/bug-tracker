<template>
    <form @submit.prevent="submit">

        <h1 class="title is-3">{{ bug.name }}</h1>
        <hr>
        <div class="field">
            <breeze-validation-errors class="has-text-danger" />
        </div>

        <div class="field">
            <label class="label">Name</label>
            <div class="control">
                <input class="input" type="text" placeholder="Name" v-model="form.name" required id="name">
            </div>
        </div>

        <div class="field">
            <label class="label">Short Description</label>
            <div class="control">
                <input class="input" type="text" placeholder="Name" v-model="form.short_description" required
                    id="short_description">
            </div>
        </div>

        <div class="field">
            <label class="label">Description</label>
            <Editor class="control" v-model="form.description"
                api-key="slywffvajg634meppknoof0to9n196pid61ffb1kon4h0059" :init="{
                    plugins: 'lists link image table code help wordcount',
                    toolbar: 'undo redo | styles | bold italic | alignleft aligncenter alignright alignjustify | outdent indent numlist bullist'
                }" />
        </div>

        <div class="field">
            <label class="label">Assignee</label>
            <div class="select">
                <select v-model="form.assignee">
                    <option :value="null">Select Assignee</option>
                    <option v-for="user in project.users" :key="user.id" :value="user.id">
                        {{ user.name }} ({{ user.email }})
                    </option>
                </select>
            </div>
        </div>

        <div class="field">
            <label class="label">Priority</label>
            <div class="select">
                <select v-model="form.priority_id">
                    <option disabled>Select Priority</option>
                    <option v-for="priority in priorities" :key="priority.id" :value="priority.id">{{ priority.name }}
                    </option>
                </select>
            </div>
        </div>

        <div class="control mt-5">
            <button class="button is-primary mr-2" :disabled="form.processing">Submit</button>
            <inertia-link :href="route('projects.stages.index', { project: project, stage: stage })"
                class="button is-info">Back To Project</inertia-link>

        </div>
    </form>
</template>

<script>

import Layout from '@/Layouts/Authenticated.vue';
import breezeValidationErrors from '@/Components/ValidationErrors.vue';
import Editor from '@tinymce/tinymce-vue';

export default {
    props: ['priorities', 'project', 'stage', 'bug'],
    layout: Layout,
    components: {
        breezeValidationErrors,
        Editor,
    },
    mounted() {
        document.addEventListener('click', function (e) {
            if (e.target.type == 'text' || e.target.type == 'textarea') {
                e.target.classList.add('cursor-is-text');
            }
            else if (e.target.tagName == 'SELECT') {
                e.target.classList.add('cursor-is-pointer');
            }
            else {
                document.querySelectorAll('.cursor-is-text').forEach(element => {
                    element.classList.remove('cursor-is-text');
                });

                document.querySelectorAll('.cursor-is-pointer').forEach(element => {
                    element.classList.remove('cursor-is-pointer');
                });
            }
        });
    },
    data() {
        return {
            form: this.$inertia.form({
                name: this.bug.name,
                short_description: this.bug.short_description,
                description: this.bug.description,
                assignee: this.bug.assignee?.id ?? null,
                priority_id: this.bug.priority_id,
            })
        }
    },
    methods: {
        submit() {
            this.form.patch(this.route('projects.stages.bugs.update', { project: this.project, stage: this.stage, bug: this.bug }))
        }
    }
}

</script>

<style scoped>
input:hover,
textarea:hover,
select:hover {
    cursor: default;
}
</style>