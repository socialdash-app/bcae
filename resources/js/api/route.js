import {reactive, shallowRef} from "vue";

export default {
    data: reactive({
        component: 'navigation',
    }),
    changeTo: function (name) {
        this.data.component = name;
    }
}
