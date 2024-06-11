import {createApp} from 'vue';
import {route} from 'ziggy-js';

createApp({
    name: "RegisterForm",
    data() {
        return {
            name: '',
            email: '',
            password: '',
            password_confirmation: '',
            show_password: false,
            show_password_confirmation: false,
            errors: [],
            loading: false,
        }
    },
    computed: {
        passwordType() {
            return this.show_password ? 'text' : 'password';
        },
        passwordClass() {
            return {
                'fa': true,
                'fa-eye-slash': !this.show_password,
                'fa-eye': this.show_password,
            }
        },
        passwordConfirmationType() {
            return this.show_password_confirmation ? 'text' : 'password';
        },
        passwordConfirmationClass() {
            return {
                'fa': true,
                'fa-eye-slash': !this.show_password_confirmation,
                'fa-eye': this.show_password_confirmation,
            }
        },
    },
    methods: {
        togglePassword: function () {
            this.show_password = !this.show_password;
        },
        togglePasswordConfirmation: function () {
            this.show_password_confirmation = !this.show_password_confirmation;
        },
        submitForm: async function () {
            this.loading = true;

            let data = new FormData();
            data.append('name', this.name);
            data.append('email', this.email);
            data.append('password', this.password);
            data.append('password_confirmation', this.password_confirmation);

            await axios.post(route('register'), data).then(response => {
                this.errors = []; // Clear errors
                this.loading = false; // Stop loading

                if (response.data.redirect) {
                    this.loading = true;
                    window.location.href = response.data.redirect;
                }
            }).catch((error) => {
                if (error.response.status === 422) {
                    this.errors = error.response.data.errors;
                }
                this.loading = false; // Stop loading
            });
        },
    }
}).mount('#app');