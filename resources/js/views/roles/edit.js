import {createApp} from 'vue';
import {route} from 'ziggy-js';
import tooltip from '../../directives/tooltip.js';

createApp({
    name: "EditRoleForm",
    directives: {
        tooltip: tooltip,
    },
    data() {
        return {
            form: {
                name: window.model.name,
                display_name: window.model.display_name,
                description: window.model.description,
                permissions: window.rolePermissions,
            },
            model: window.model,
            permissions: window.permissions,
            errors: [],
            loading: false,
        }
    },
    methods: {
        async submitForm() {
            this.loading = true;

            let data = {
                _method: document.getElementsByName("_method")[0].value,
                display_name: this.form.display_name,
                description: this.form.description,
                permissions: this.form.permissions,
            };

            await axios.post(route('roles.update', {id: this.model.id}), data).then(response => {
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
