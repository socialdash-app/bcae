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
    name: 'Chronicles',
    primaryColor: '#FFFDE0',
    secondaryColor: '#fff21f',
    icon: chronicle,
}, {
    name: 'The Election',
    primaryColor: '#FFDCF1',
    secondaryColor: '#F788BF',
    icon: theElection,
},
    {
        name: 'Prominent Events',
        primaryColor: '#E1FFDE',
        icon: prominentEvents,
        secondaryColor: '#44BB33',
    }, {
        name: 'Party Reactions',
        primaryColor: '#f8CCFF',
        icon: partyActions,
        secondaryColor: '#BD33DB',
    }, {
        name: 'The Military',
        primaryColor: '#FDE0C2',
        icon: theMilitary,
        secondaryColor: '#FF7F00',
    }, {
        name: 'Correlated Events',
        primaryColor: '#FFE4DE',
        icon: correlatedActions,
        secondaryColor: '#A65628',
    }, {
        name: 'Beginning Of The End',
        primaryColor: '#111827',
        icon: beginningOfTheEnd,
        secondaryColor: '#f31515',
    }
];

export default {
    data: reactive({
        component: "home",
    }),
    changeTo: function (name) {
        this.data.component = name;
    },
    scrollTo: function (section) {
    },
    changeSectionHeader: function (index) {
        let translateYOffsets = [];
        for (let i = 0; i < headers.length; i++) {
            translateYOffsets.push(i * 100 - index * 100);
        }
        if (window && window.innerWidth < 768) {
            anime({
                targets: ".header",
                background: headers[index].primaryColor,
                duration: 600,
                easing: "easeOutQuart",
            });
        }

        anime({
            targets: ".header-title",
            translateY: (el, index) => translateYOffsets[index],
            easing: "easeOutQuart",
            duration: 600,
        });
        anime({
            targets: ".header-icon",
            translateY: (el, index) => translateYOffsets[index],
            easing: "easeOutQuart",
            duration: 600,
        });
    },
};

