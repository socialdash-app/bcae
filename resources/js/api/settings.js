import {reactive} from "vue";

export default {
    data: reactive({
        locale: 'en',
    }),
    animationDuration: 2000,
    changeLocale: function (locale) {
        this.data.locale = locale;
    }
}
