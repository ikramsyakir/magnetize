import {createApp} from 'vue';
import {route} from 'ziggy-js';
import tooltip from '../../directives/tooltip.js';

createApp({
    name: "CreateUserForm",
    directives: {
        tooltip: tooltip,
    },
    data() {
        return {
            form: {
                name: '',
                email: '',
                verified: '',
                roles: [],
                password: '',
                password_confirmation: '',
                avatar: '',
                avatar_type: window.avatarTypes.initial,
            },
            roles: window.roles,
            avatarTypes: {
                initial: window.avatarTypes.initial,
                uploaded: window.avatarTypes.uploaded,
            },
            avatarPreview: window.avatarPreview,
            defaultAvatar: window.avatarPreview,
            show_password: false,
            show_password_confirmation: false,
            verifyTypes: window.verifyTypes,
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
        async submitForm() {
            this.loading = true;

            let data = new FormData();
            data.append('name', this.form.name);
            data.append('email', this.form.email);
            data.append('verified', this.form.verified);
            data.append('roles', this.form.roles);
            data.append('password', this.form.password);
            data.append('password_confirmation', this.form.password_confirmation);
            data.append('avatar', this.form.avatar);
            data.append('avatar_type', this.form.avatar_type);

            await axios.post(route('users.store'), data).then(response => {
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
        handleAvatarChange() {
            const selectedFile = this.$refs.avatarFile.files[0];

            if (selectedFile) {
                // Set file and generate preview
                this.form.avatar = selectedFile;
                this.form.avatarPreview = URL.createObjectURL(selectedFile);
                this.avatar_type = this.avatarTypes.uploaded;
            }
        },
        deleteAvatar() {
            this.$refs.avatarFile.value = null;
            this.form.avatar_type = this.avatarTypes.initial;
            this.form.avatar = '';
            this.avatarPreview = this.base64ToUrl(this.defaultAvatar);
        },
        base64ToUrl(base64) {
            const [header, base64Data] = base64.split(',');
            const mimeType = header.match(/:(.*?);/)[1]; // Extracts mime type
            const binaryString = atob(base64Data);
            const byteArray = new Uint8Array(binaryString.length);

            for (let i = 0; i < binaryString.length; i++) {
                byteArray[i] = binaryString.charCodeAt(i);
            }

            const blob = new Blob([byteArray], {type: mimeType});
            return URL.createObjectURL(blob);
        },
        togglePassword: function () {
            this.show_password = !this.show_password;
        },
        togglePasswordConfirmation: function () {
            this.show_password_confirmation = !this.show_password_confirmation;
        },
    }
}).mount('#app');
