<template>
    <div class="columns is-centered">
        <form class="box column is-6 px-6 py-5" @submit.prevent="submit">

            <h3 class="title is-3 has-text-centered">Register</h3>

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
                    <input class="input" type="email" placeholder="Email address" v-model="form.email" required
                        autocomplete="email" id="email">
                </div>
            </div>

            <div class="field">
                <label class="label">Password</label>
                <div class="control">
                    <input class="input" type="password" placeholder="Password" v-model="form.password" required
                        autocomplete="new-password" id="password">
                </div>
            </div>

            <div class="field">
                <label class="label">Confirm Password</label>
                <div class="control">
                    <input class="input" type="password" placeholder="Password" v-model="form.password_confirmation"
                        required autocomplete="new-password" id="password_confirmation">
                </div>
            </div>

            <div id="file-js" class="field file has-name">
                <label class="file-label">
                    <input @change="changeFileText" @input="form.icon = $event.target.files[0]" class="file-input"
                        type="file" />
                    <span class="file-cta">
                        <span class="file-label"> Choose icon file… </span>
                    </span>
                    <span class="file-name"> No file uploaded </span>
                </label>
            </div>

            <div class="field">
                <inertia-link :href="route('login')">
                    Already registered?
                </inertia-link>
            </div>

            <div class="control mt-5">
                <button class="button is-primary" :disabled="form.processing">Register</button>
            </div>
        </form>
    </div>
</template>

<script>
import BreezeGuestLayout from "@/Layouts/Guest"
import BreezeValidationErrors from '@/Components/ValidationErrors'

export default {
    layout: BreezeGuestLayout,

    components: {
        BreezeValidationErrors,
    },

    data() {
        return {
            form: this.$inertia.form({
                name: '',
                email: '',
                password: '',
                password_confirmation: '',
                icon: null,
                terms: false,
            })
        }
    },

    methods: {
        submit() {
            this.form.post(this.route('register'), {
                onFinish: () => this.form.reset('password', 'password_confirmation'),
            })
        },
        changeFileText() {
            const fileInput = document.querySelector("#file-js input[type=file]");

            if (fileInput.files.length > 0) {
                const fileName = document.querySelector("#file-js .file-name");
                fileName.textContent = fileInput.files[0].name;
            }
        }
    }
}
</script>
