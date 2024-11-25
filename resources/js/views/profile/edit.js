import {createApp} from 'vue';
import {route} from 'ziggy-js';

createApp({
    name: "UpdateProfileForm",
    data() {
        return {
            name: window.user.name,
            email: window.user.email,
            avatar: '',
            avatar_type: window.user.avatar_type,
            avatarPreview: window.avatarPreview,
            avatarTypes: window.avatarTypes,
            defaultAvatar: window.defaultAvatar,
            errors: [],
            loading: false,
        }
    },
    methods: {
        async submitForm() {
            this.loading = true;

            let data = new FormData();
            data.append('_method', document.getElementsByName("_method")[0].value);
            data.append('name', this.name);
            data.append('email', this.email);
            data.append('avatar', this.avatar);
            data.append('avatar_type', this.avatar_type);

            await axios.post(route('profile.update'), data).then(response => {
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
                this.avatar = selectedFile;
                this.avatarPreview = URL.createObjectURL(selectedFile);
                this.avatar_type = this.avatarTypes.uploaded;
            }
        },
        deleteAvatar() {
            this.$refs.avatarFile.value = null;
            this.avatar_type = this.avatarTypes.initial;
            this.avatar = '';
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
    }
}).mount('#app');
