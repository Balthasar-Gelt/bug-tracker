<template>
    <div class="columns is-centered">
        <form class="box column is-6 px-6 py-5" @submit.prevent="submit">

            <div class="mb-4 text-sm text-gray-600">
                Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.
            </div>

            <div class="mb-4 font-medium text-sm text-green-600" v-if="verificationLinkSent" >
                A new verification link has been sent to the email address you provided during registration.
            </div>

            <div class="control mt-5">
                <button class="button is-primary" :disabled="form.processing">Resend Verification Email</button>
            </div>
            
            <div class="control mt-5">
                <inertia-link :href="route('logout')" class="button is-secondary" method="post" as="button">Log Out</inertia-link>
            </div>
        </form>
    </div>
</template>

<script>
    import BreezeGuestLayout from "@/Layouts/Guest"

    export default {
        layout: BreezeGuestLayout,

        props: {
            status: String
        },

        data() {
            return {
                form: this.$inertia.form()
            }
        },

        methods: {
            submit() {
                this.form.post(this.route('verification.send'))
            },
        },

        computed: {
            verificationLinkSent() {
                return this.status === 'verification-link-sent';
            }
        }
    }
</script>
