import {reactive, shallowRef} from "vue";
import anime from "animejs";
import {
    beginningOfTheEnd,
    chronicle,
    correlatedActions,
    partyActions,
    prominentEvents,
    theElection,
    theMilitary
} from "../assets/icons.js";

export const headers = [{
    name: 'Chronicle',
    primaryColor: '#FFF21F',
    secondaryColor: '#FF7F00',
    icon: chronicle,
}, {
    name: 'The Election',
    primaryColor: '#F9E2F0',
    secondaryColor: '#ff1c8a',
    icon: theElection,
},
    {
        name: 'Prominent Events',
        primaryColor: '#F1FFF0',
        icon: prominentEvents,
        secondaryColor: '#44BB33',
    }, {
        name: 'Party Actions',
        primaryColor: '#EBFFE0',
        icon: partyActions,
        secondaryColor: '#E9A498',
    }, {
        name: 'The Military',
        primaryColor: '#FEF5EC',
        icon: theMilitary,
        secondaryColor: '#ffb976',
    }, {
        name: 'Correlated Actions',
        primaryColor: '#FDF4E9',
        icon: correlatedActions,
        secondaryColor: '#A65628',
    }, {
        name: 'Beginning Of The End',
        primaryColor: '#111827',
        icon: beginningOfTheEnd,
        secondaryColor: '#FF7F00',
    }
];

export default {
    data: reactive({
        component: 'story',
    }),
    changeTo: function (name) {
        this.data.component = name;
    },
    scrollTo: function (section) {

    },
    changeSectionHeader: function (index) {
        let translateYOffsets = [];
        for (let i = 0; i < headers.length; i++) {
            translateYOffsets.push((i * 100) - (index * 100));
        }
        if (window && window.innerWidth < 768) {
            anime({
                targets: '.header',
                background: headers[index].primaryColor,
                duration: 600,
                easing: 'easeOutQuart',
            })
        }

        anime({
            targets: '.header-title',
            translateY: (el, index) => translateYOffsets[index],
            easing: 'easeOutQuart',
            duration: 600,
        })
        anime({
            targets: '.header-icon',
            translateY: (el, index) => translateYOffsets[index],
            easing: 'easeOutQuart',
            duration: 600,
        })
    }
}

