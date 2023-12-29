import {reactive, shallowRef} from "vue";

export default {
    data: reactive({
        component: 'home',
    }),
    changeTo: function (name) {
        this.data.component = name;
    }
}
