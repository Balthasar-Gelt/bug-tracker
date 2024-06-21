<template>
    <div class="modal">
        <div class="modal-background" @click="$emit('closeAddBugForm')"></div>
        <div class="modal-card">
            <header class="modal-card-head">
                <p class="modal-card-title">Create new bug</p>
                <a @click="$emit('closeAddBugForm')" class="delete" aria-label="close"></a>
            </header>
            <section class="modal-card-body">
                <form @submit.prevent="submit">

                    <div class="field mb-0">
                        <breeze-validation-errors class="has-text-danger" />
                    </div>

                    <div class="field">
                        <label class="label">Name</label>
                        <div class="control">
                            <input v-model="form.name" class="input" type="text" placeholder="Name" required autofocus
                                id="name">
                        </div>
                    </div>

                    <div class="field">
                        <label class="label">Short Description</label>
                        <div class="control">
                            <input v-model="form.short_description" class="input" type="text"
                                placeholder="Short Description" required autofocus id="short_description">
                        </div>
                        <p class="help">Max 100 characters!</p>
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
                                <option v-for="priority in priorities" :key="priority.id" :value="priority.id">
                                    {{ priority.name }}
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="control mt-5">
                        <button class="button is-primary" :disabled="form.processing">Submit</button>
                    </div>
                </form>
            </section>
        </div>
    </div>
</template>

<script>
import breezeValidationErrors from '@/Components/ValidationErrors.vue';
import Editor from '@tinymce/tinymce-vue';

export default {
    props: ['priorities', 'project', 'stage'],
    components: {
        breezeValidationErrors,
        Editor,
    },
    data() {
        return {
            form: this.$inertia.form({
                name: null,
                short_description: null,
                description: null,
                assignee: null,
                priority_id: null,
                project_id: this.project.id,
                stage_id: this.stage.id,
            }),
        }
    },
    mounted() {
        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                this.$emit('closeAddBugForm');
            }
        });
    },
    methods: {
        submit() {
            this.form.post(this.route('projects.stages.bugs.store', { project: this.project, stage: this.stage }), {
                onSuccess: () => { this.$emit('closeAddBugForm') }
            })
        },
    },
}
</script>
