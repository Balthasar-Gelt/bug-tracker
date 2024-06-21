<template>
    <form @submit.prevent="submit">

        <h3 class="title is-3">Edit Project</h3>

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
            <label class="label">Short Description</label>
            <div class="control">
                <input class="input" type="text" placeholder="Short Description" v-model="form.short_description"
                    required id="short_description"></input>
            </div>
            <p class="help">Text will be shown in the main list of all projects. Max 50 characters!</p>
        </div>

        <div class="field">
            <label class="label">Description</label>
                <Editor class="control" v-model="form.description"
                    api-key="slywffvajg634meppknoof0to9n196pid61ffb1kon4h0059" :init="{
                        plugins: 'lists link image table code help wordcount',
                        toolbar: 'undo redo | styles | bold italic | alignleft aligncenter alignright alignjustify | outdent indent numlist bullist'
                    }" />
        </div>

        <div class="control mt-5">
            <button class="button is-primary" :disabled="form.processing">Submit</button>
        </div>
    </form>
</template>

<script>

import Layout from '@/Layouts/Authenticated.vue';
import breezeValidationErrors from '@/Components/ValidationErrors.vue';
import Editor from '@tinymce/tinymce-vue';

export default {
    layout: Layout,
    props: ['project'],
    components: {
        breezeValidationErrors,
        Editor,
    },
    data() {
        return {
            form: this.$inertia.form({
                name: this.project.name,
                short_description: this.project.short_description,
                description: this.project.description,
            })
        }
    },
    methods: {
        submit() {
            this.form.patch(this.route('projects.update', this.project))
        }
    }
}

</script>