import {createApp} from "vue";
import { QuillEditor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css';

createApp({
    name: "CreatePostForm",
    components: {
        QuillEditor
    },
    data() {
        return {
            text: '# hello',
        }
    },
}).mount("#app");
