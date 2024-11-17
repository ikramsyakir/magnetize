import {createApp} from 'vue';
import {route} from 'ziggy-js';

createApp({
    name: "UpdateProfileForm",
    data() {
        return {
            avatar: '',
            name: '',
            email: '',
            errors: [],
            loading: false,
        }
    },
}).mount('#app');
