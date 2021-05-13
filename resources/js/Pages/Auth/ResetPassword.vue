<template>
    <div class="columns is-centered">
        <form class="box column is-6 px-6 py-5" @submit.prevent="submit">

            <h3 class="title is-3 has-text-centered">Reset Password</h3>

            <div class="field">
                <breeze-validation-errors class="has-text-danger" />
            </div>

            <div class="field">
                <label class="label">Email</label>
                <div class="control">
                    <input class="input" type="email" placeholder="Email address" v-model="form.email" required autofocus autocomplete="email" id="email">
                </div>
            </div>

            <div class="field">
                <label class="label">Password</label>
                <div class="control">
                    <input class="input" type="password" placeholder="Password" v-model="form.password" required autocomplete="new-password" id="password">
                </div>
            </div>

            <div class="field">
                <label class="label">Confirm Password</label>
                <div class="control">
                    <input class="input" type="password" placeholder="Password" v-model="form.password_confirmation" required autocomplete="new-password" id="password_confirmation">
                </div>
            </div>

            <div class="control mt-5">
                <button class="button is-primary" :disabled="form.processing">Reset Password</button>
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

        props: {
            email: String,
            token: String,
        },

        data() {
            return {
                form: this.$inertia.form({
                    token: this.token,
                    email: this.email,
                    password: '',
                    password_confirmation: '',
                })
            }
        },

        methods: {
            submit() {
                this.form.post(this.route('password.update'), {
                    onFinish: () => this.form.reset('password', 'password_confirmation'),
                })
            }
        }
    }
</script>
