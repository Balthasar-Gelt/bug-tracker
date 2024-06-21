<template>
    <form @submit.prevent="submit">

        <h3 class="title is-3">User settings</h3>

        <div class="field">
            <breeze-validation-errors class="has-text-danger" />
        </div>

        <div class="field">
            <label class="label">Name</label>
            <div class="control">
                <input class="input" type="text" placeholder="Name" v-model="form.name" required autofocus
                    autocomplete="name" id="name">
            </div>
        </div>

        <div class="field">
            <label class="label">Email</label>
            <div class="control">
                <input title="To change email please contact our website service" class="input" type="email"
                    placeholder="Email address" v-model="form.email" required autocomplete="email" id="email">
            </div>
        </div>

        <div class="field mt-4">
            <label class="label">Profile picture</label>
            <div class="control">
                <a @click.prevent="resetProfilePicture" class="delete"></a>

                <figure class="image is-128x128 avatar">
                    <img id="preview" class="is-rounded" :src="$page.props.auth.user.icon" />
                </figure>
            </div>
        </div>

        <div id="file-js" class="field file has-name">
            <label class="file-label">
                <input @change="updateProfilePictureData" @input="form.icon = $event.target.files[0]" class="file-input"
                    type="file" />
                <span class="file-cta">
                    <span class="file-label"> Choose new icon file… </span>
                </span>
                <span class="file-name"> {{ fileText }} </span>
            </label>
        </div>

        <div class="control mt-5">
            <button class="button is-primary mr-4" :disabled="form.processing">Save</button>

            <inertia-link :href="route('password.reset')" method="get" class="button is-info">Reset
                Password</inertia-link>
        </div>
    </form>
</template>

<script>
import Layout from '@/Layouts/Authenticated.vue';

import BreezeValidationErrors from '@/Components/ValidationErrors'

export default {
    layout: Layout,
    props: {
        message: String,
    },

    components: {
        BreezeValidationErrors,
    },

    mounted() {
        this.preview = document.getElementById('preview');
        this.fileInput = document.querySelector("#file-js input[type=file]");
        this.fileName = document.querySelector("#file-js .file-name");
    },

    data() {
        return {
            form: this.$inertia.form({
                _method: 'patch',
                name: this.$page.props.auth.user.name,
                email: this.$page.props.auth.user.email,
                icon: null,
            }),
            originalProfilePicture: this.$page.props.auth.user.icon,
            preview: null,
            fileInput: null,
            fileName: null,
            defaultFileText: 'No file uploaded',
            fileText: 'No file uploaded',
        }
    },

    methods: {
        submit() {
            this.form.post(this.route('user.update'));
        },
        updateProfilePictureData() {
            const reader = new FileReader();

            reader.addEventListener('load', (event) => {
                this.preview.src = event.target.result;
            });

            if (this.fileInput.files.length > 0) {
                reader.readAsDataURL(this.fileInput.files[0]);
                this.fileText = this.fileInput.files[0].name;
            }
        },
        resetProfilePicture() {
            this.fileInput.value = "";
            this.fileText = this.defaultFileText;
            this.preview.src = this.originalProfilePicture;
            this.form.icon = null;
        }
    }
}
</script>
