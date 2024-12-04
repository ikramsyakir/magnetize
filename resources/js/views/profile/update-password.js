import {createApp} from 'vue';
import {route} from 'ziggy-js';

createApp({
    name: "UpdatePasswordForm",
    data() {
        return {
            current_password: null,
            password: null,
            password_confirmation: null,
            errors: [],
            loading: false,
        }
    },
    methods: {
        async submitForm() {
            this.loading = true;

            let data = {
                _method: document.getElementsByName("_method")[0].value,
                current_password: this.current_password
            };

            await axios.post(route('password.update'), data).then(response => {
                this.errors = []; // Clear errors
                this.loading = false; // Stop loading

                if (response.data.redirect) {
                    this.loading = true;
                    window.location.href = response.data.redirect;
                }
            }).catch((error) => {
                console.log(error.response);
                if (error.response.status === 422) {
                    this.errors = error.response.data.errors;
                }
                this.loading = false; // Stop loading
            });
        }
    }
}).mount('#app');
