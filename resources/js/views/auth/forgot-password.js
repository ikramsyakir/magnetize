import {createApp} from 'vue';
import {route} from 'ziggy-js';

createApp({
    name: "ForgotPasswordForm",
    data() {
        return {
            email: '',
            reset_link_sent: '',
            errors: [],
            loading: false,
        }
    },
    methods: {
        submitForm: async function () {
            this.loading = true;

            let data = new FormData();
            data.append('email', this.email);

            await axios.post(route('password.email'), data).then(response => {
                this.errors = []; // Clear errors
                this.loading = false; // Stop loading

                if (response.data.status) {
                    this.reset_link_sent = response.data.status;
                    this.email = '';
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
