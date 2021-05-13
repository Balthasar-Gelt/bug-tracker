<template>
    <form @submit.prevent="submit">

        <h3 class="title is-3">Create Bug</h3>
        
        <div class="field">
            <breeze-validation-errors class="has-text-danger" />
        </div>

        <div class="field">
            <label class="label">Name</label>
            <div class="control">
                <input class="input" type="text" placeholder="Name" v-model="form.name" required autofocus id="name">
            </div>
        </div>

        <div class="field">
            <label class="label">Description</label>
            <div class="control">
                <textarea class="textarea" type="text" placeholder="Description" v-model="form.description" required id="description"></textarea>
            </div>
        </div>

        <div class="field">
            <label class="label">Priority</label>
            <div class="select">
                <select v-model="form.priority_id">
                    <option disabled>Select Priority</option>
                    <option v-for="priority in priorities" :key="priority.id" :value="priority.id">{{priority.name}}</option>
                </select>
            </div>
        </div>

        <div class="control mt-5">
            <button class="button is-primary" :disabled="form.processing">Submit</button>
        </div>
    </form>
</template>

<script>

    import Layout from '@/Layouts/Authenticated.vue';
    import breezeValidationErrors from '@/Components/ValidationErrors.vue';

    export default {
        props:['priorities', 'project', 'stage'],
        layout: Layout,
        components: {
            breezeValidationErrors,
        },
        data() {
            return {
                form: this.$inertia.form({
                    name: '',
                    description: '',
                    priority_id: '',
                })
            }
        },
        methods: {
            submit() {
                this.form.post(this.route('projects.stages.bugs.store', {project: this.project, stage: this.stage}))
            }
        }
    }

</script>
