import {createApp} from 'vue';
import {route} from 'ziggy-js';

createApp({
    name: "DeleteAccountForm",
    data() {
        return {
            modal: null,
            confirmUserDeletion: false,
            password: null,
            errors: [],
            loading: false,
        }
    },
    mounted() {
        this.modal = new bootstrap.Modal('#confirm-user-deletion');
    },
    methods: {
        openConfirmUserDeletion() {
            this.confirmUserDeletion = true;
            this.modal.show();
        },
        closeConfirmUserDeletion() {
            this.password = null;
            this.errors = [];
            this.confirmUserDeletion = false;
            this.modal.hide();
            document.activeElement.blur();
        },
        async submitForm() {
            this.loading = true;

            let data = {
                _method: document.getElementsByName("_method")[0].value,
                password: this.password
            };

            await axios.post(route('profile.destroy'), data).then(response => {
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
