import {createApp} from 'vue';
import {route} from 'ziggy-js';
import tooltip from '../../directives/tooltip.js';

createApp({
    name: "CreateRoleForm",
    directives: {
        tooltip: tooltip,
    },
    data() {
        return {
            form: {
                name: null,
            },
            permissions: window.permissions,
            errors: [],
            loading: false,
        }
    },
    methods: {
        async submitForm() {
            this.loading = true;

            let data = new FormData();
            data.append('_method', document.getElementsByName("_method")[0].value);
            data.append('name', this.form.name);

            await axios.post(route('roles.store'), data).then(response => {
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
        },
    }
}).mount('#app');
