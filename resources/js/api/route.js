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
    primaryColor: '#fff562',
    secondaryColor: '#FF7F00',
    icon: chronicle,
}, {
    name: 'The Election',
    secondaryColor: '#ff1c8a',
    icon: theElection,
},
    {
        name: 'Prominent Events',
        icon: prominentEvents,
        secondaryColor: '#44BB33',
    }, {
        name: 'Party Actions',
        icon: partyActions,
        secondaryColor: '#E9A498',
    }, {
        name: 'The Military',
        icon: theMilitary,
        secondaryColor: '#ffb976',
    }, {
        name: 'Correlated Actions',
        icon: correlatedActions,
        secondaryColor: '#A65628',
    }, {
        name: 'Beginning Of The End',
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
    changeStoryBackgroundColor: function (color) {
        anime({
            targets: 'main',
            background: color,
            duration: 1000,
            easing: 'easeOutQuart'
        })
    },
    changeSectionHeader: function (index) {
        let translateYOffsets = [];
        for (let i = 0; i < headers.length; i++) {
            translateYOffsets.push((i * 100) - (index * 100));
        }
        console.log(index, translateYOffsets)
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

