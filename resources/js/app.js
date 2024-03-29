import './bootstrap';
import 'vue-common-components/dist/style.css';
import 'v-calendar/style.css';


import {createApp, h, defineAsyncComponent, defineComponent} from 'vue'
import {createInertiaApp} from '@inertiajs/vue3';
import {Toaster} from 'js-utils';
import {DatePicker} from "v-calendar";
import Home from "./components/pages/home.vue";
import Explore from "./components/pages/explore.vue";
import Story from "./components/pages/story.vue";


createInertiaApp({
    resolve: name => {
        const pages = import.meta.glob('./components/**/*.vue', {eager: true})
        return pages[`./components/${name}.vue`];
    },
    async setup({el, App, props, plugin}) {
        const toasterEle = document.createElement('div');
        toasterEle.style.top = 'auto';
        toasterEle.style.bottom = '2vh';
        document.body.appendChild(toasterEle);
        let toaster = new Toaster(toasterEle);
        toaster.setConfigOfType('error', {bgColor: '#D65A56'})

        const app = createApp({render: () => h(App, props)})

        // const components = import.meta.glob('./components/**/*.vue');
        //
        // for (let component of Object.keys(components)) {
        //     let componentName = [...component.matchAll(/([^\/]*).vue/g)][0][1];
        //     // let componentPath = component.replace('./components/', '').replace('.vue', '');
        //     app.component(componentName, defineAsyncComponent(() => components[component]()))
        // }

        app.component('home', Home);
        app.component('explore', Explore);
        app.component('story', Story);

        app.component('DatePicker', DatePicker)

        const directives = import.meta.glob('./directives/*.js');
        for (let directive of Object.keys(directives)) {
            let directiveName = [...directive.matchAll(/([^\/]*).js/g)][0][1]
            app.directive(directiveName, (await directives[directive]()).default)
        }
        app.use(plugin)
            .mount(el)
    },
})
