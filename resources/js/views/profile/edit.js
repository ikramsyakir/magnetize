import {createApp} from 'vue';
import {route} from 'ziggy-js';

createApp({
    name: "UpdateProfileForm",
    data() {
        return {
            name: window.user.name,
            email: window.user.email,
            avatar: null,
            avatarPreview: window.avatarPreview,
            avatarType: window.user.avatar_type,
            avatarTypes: window.avatarTypes,
            defaultAvatar: window.defaultAvatar,
            errors: [],
            loading: false,
        }
    },
    methods: {
        handleAvatarChange(event) {
            const selectedFile = event.target.files[0];

            if (selectedFile) {
                // Set file and generate preview
                this.avatar = selectedFile;
                this.avatarPreview = URL.createObjectURL(selectedFile);
                this.avatarType = this.avatarTypes.uploaded;
            }
        },
        deleteAvatar() {
            this.avatarType = this.avatarTypes.initial;
            this.avatar = null;
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
