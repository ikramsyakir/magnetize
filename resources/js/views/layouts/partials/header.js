import {createApp} from 'vue';
import {route} from 'ziggy-js';

createApp({
    name: "ThemeMode",
    data() {
        return {
            theme: window.theme,
            themeType: window.themeType,
            trans: window.messages,
        };
    },
    methods: {
        toggleTheme: async function () {
            if (this.theme === this.themeType.light) {
                this.theme = this.themeType.dark;
            } else {
                this.theme = this.themeType.light;
            }

            document.body.setAttribute('data-bs-theme', this.theme);

            let data = {
              theme: this.theme,
            };

            await axios.post(route('update-theme'), data);
        }
    },
}).mount('#header');
