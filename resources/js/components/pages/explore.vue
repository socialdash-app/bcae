<template>
    <div id="explore"
         :style="{height: height + 'px'}"
         class="flex w-screen relative select-none text-white overflow-y-auto overscroll-none overflow-x-hidden bg-[#660000] items-center justify-start flex-col">
        <div
            class="w-full md:!bg-transparent header py-4 flex justify-between  z-[100] px-4 md:!px-20 fixed top-0 left-0">
            <div class="flex w-full gap-x-2 items-center">
                <img class="w-8 brand-icon h-8 md:!w-12 md:!h-12" src="assets/logo_white.svg" alt="logo"/>
                <h1 class="font-bevietnampro brand-title text-white font-bold text-lg md:text-2xl">Social Dash</h1>
            </div>
        </div>
        <div id="explore-container"
             :style="{height: height + 'px'}"
             class="w-screen sticky top-0 overflow-hidden flex flex-col items-center shrink-0">
            <div id="description-container" class="w-11/12 sm:w-10/12 2xl:w-8/12 h-[50vh] flex overflow-hidden">
            </div>
            <ul id="boxes"
                class="w-[300px] h-[70vh] absolute bottom-[-100%] flex justify-center items-center">
            </ul>
            <ul id="icons"
                class="w-[300px] h-[70vh] absolute bottom-[-100%] flex justify-center items-center">
            </ul>
        </div>
        <div class="shrink-0 absolute -z-10 w-full" id="explore-trigger"
             :style="{ height: data.length * height + 'px' }">
        </div>
        <div class="shrink-0" :style="{ height: (data.length - 1) * height + 'px' }">
        </div>
    </div>
</template>

<script setup>
import {reactive, onMounted, onActivated, onDeactivated} from "vue";
import anime from "animejs";
import {DragGesture} from "@use-gesture/vanilla";
import AnimeScrollTrigger from 'anime-scrolltrigger'
import route from "../../api/route.js";
import settings from "../../api/settings.js";
import {
    beginningOfTheEnd,
    chronicle,
    correlatedActions,
    partyActions,
    prominentEvents,
    theElection,
    theMilitary
} from "../../assets/icons.js";

const props = defineProps([]);

const height = window.innerHeight;

let data = [
    {
        description:
            "Going back to Home",
        card: "assets/cards/home.svg",
        icon: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8 lucide lucide-album"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><polyline points="11 3 11 11 14 8 17 11 17 3"/></svg>',
        onClick: () => {
            route.changeTo('home')
        }
    },
    {
        description:
            "Explore the stricken history of military overthrowing people’s power in Myanmar",
        card: "assets/cards/chronicles.svg",
        onClick: () => {
            route.changeTo('story', 'chronicles-trigger')
        },
        icon: chronicle,
    },
    {
        description:
            "Explore the insights and results of 2020 election",
        card: "assets/cards/the_election.svg",
        onClick: () => {
            route.changeTo('story', 'the-election')
        },
        icon: theElection,
    },
    {
        description:
            "Explore incidents during election and back-and-forth letters among different entities",
        card: "assets/cards/prominent_events.svg",
        onClick: () => {
            route.changeTo('story', 'prominent-events')
        },
        icon: prominentEvents,
    },
    {
        description:
            "Explore how political parties respond to the dispute",
        card: "assets/cards/party_reactions.svg",
        onClick: () => {
            route.changeTo('story', 'party-reactions')

        },
        icon: partyActions,
    },
    {
        description:
            "Explore how Military intervened the dispute",
        card: "assets/cards/the_military.svg",
        icon: theMilitary,
        onClick: () => {
            route.changeTo('story', 'the-military')

        },
    },
    {
        description:
            "Explore the protests and the disinformation outspread",
        card: "assets/cards/correlated_events.svg",
        onClick: () => {
            route.changeTo('story', 'correlated-events')
        },
        icon: correlatedActions,
    },
    {
        description:
            "Explore the beginning of the end of people’s power and summary of BCAE",
        card: "assets/cards/beginning_of_the_end.svg",
        onClick: () => {
            route.changeTo('story', 'beginning-of-the-end')
        },
        icon: beginningOfTheEnd,
    },
];
const init = () => {
    let descriptionContainer = document.getElementById("description-container");

    let ul = document.getElementById("boxes");

    let iconContainer = document.getElementById('icons');

    let explore = document.getElementById('explore');

    let height = (data.length * window.innerHeight) - window.innerHeight;

    // build boxes
    let boxes = [];
    let icons = [];
    let descriptions = [];
    let boxHeight = window.innerHeight * 0.4;
    let ratio = 9 / 16;
    let boxWidth = boxHeight * ratio;
    data.forEach((d) => {
        let description = document.createElement("div");
        description.className = "description text-xl sm:text-4xl font-bevietnampro font-bold text-center items-center justify-center  py-4   flex sm:items-center grow-0 sm:p-10 w-full shrink-0";
        description.innerText = d.description;
        descriptionContainer.appendChild(description);
        descriptions.push(description);

        let box = document.createElement("li");
        box.className = "box list-none bg-gray-300 absolute cursor-pointer flex justify-center";
        box.style.touchAction = 'none'
        box.style.height = boxHeight + 'px';
        box.style.width = boxWidth + 'px';
        box.innerHTML = `<img src="${d.card}" alt="${d.card}" class="w-full object-cover h-full">`;
        ul.appendChild(box);
        boxes.push(box);

        let icon = document.createElement('li');
        icon.className = "icon list-none absolute cursor-pointer p-6 flex justify-center rounded-[50%]";
        icon.innerHTML = d.icon;
        iconContainer.appendChild(icon);
        icons.push(icon)
    });


    let currentBox = null;
    let timeout = null;
    let rotates = [];
    let currentRotation = 0;
    let deg = 360 / (boxes.length + 1);
    let isDragging = false;
    let shouldTriggerScroll = true;
    let width = descriptionContainer.getBoundingClientRect().width * boxes.length;

    let update = function (angle) {
        if (timeout) clearTimeout(timeout);
        // currentRotation += angle;
        currentRotation = angle;
        if (currentRotation > rotates[rotates.length - 1].deg) {
            currentRotation = rotates[rotates.length - 1].deg;
        } else if (currentRotation < 0) {
            currentRotation = 0;
        }

        timeout = setTimeout(() => {
            currentBox = rotates
                .map((rotate) => {
                    rotate.distance = Math.abs(rotate.deg - currentRotation);
                    return rotate;
                })
                .sort((a, b) => a.distance >= b.distance ? 1 : -1)[0];
            let index = currentBox.deg / deg;
            let progress = index / boxes.length;
            shouldTriggerScroll = false;
            currentRotation = currentBox.deg;
            anime({
                targets: explore,
                scrollTop: progress * height,
                easing: 'easeOutQuart',
                duration: 400,
                complete: () => shouldTriggerScroll = true,
            })
            anime({
                targets: descriptionContainer,
                scrollLeft: (currentRotation / (360 - deg)) * width,
                duration: 400,
                easing: "easeOutQuart"
            })
            anime({
                targets: ul,
                rotateZ: -currentRotation,
                duration: 400,
                easing: "easeOutQuart",
                // delay: 10
            });
            anime({
                targets: iconContainer,
                rotateZ: -currentRotation,
                duration: 400,
                easing: "easeOutQuart",
                // delay: 10
            });
            container.style.cursor = 'grab'
        }, 800);
        anime({
            targets: descriptionContainer,
            scrollLeft: (currentRotation / (360 - deg)) * width,
            duration: 400,
            easing: "easeOutQuart"
        })
        anime({
            targets: ul,
            rotateZ: -currentRotation,
            duration: 400,
            easing: "easeOutQuart",
            // delay: 10
        });
        anime({
            targets: iconContainer,
            rotateZ: -currentRotation,
            duration: 400,
            easing: "easeOutQuart",
            // delay: 10
        });
    };

    boxes.forEach((box, i) => {
        let rotate = i * deg;
        rotates.push({
            index: i,
            deg: rotate,
            box: box.innerText
        });
        box.style.transform = `rotateZ(${rotate}deg) translateY(-${(window.innerHeight) * 0.95}px)`;
        icons[i].style.transform = `rotateZ(${rotate}deg) translateY(-${(window.innerHeight) * 0.7}px)`;
        box.addEventListener('click', (e) => {
            e.stopPropagation();
            if (currentRotation === rotate) {
                data[i].onClick();
                return;
            }
            let index = rotate / deg;
            let progress = index / boxes.length;
            anime({
                targets: explore,
                scrollTop: progress * height,
                easing: 'easeOutQuart',
                duration: 400,
            })
        })
    }, false);

    setTimeout(() => {
        new AnimeScrollTrigger(document.getElementById('explore'), [{
            scrollTrigger: {
                trigger: '#explore-trigger',
                start: 'top top',
                end: 'bottom bottom',
                lerp: true,
                onUpdate: (_, progress) => {
                    console.log(shouldTriggerScroll)
                    if (shouldTriggerScroll) {
                        update(progress * deg * data.length)
                    }
                }
            }
        }])
    }, 100)


    const mobileAndTabletCheck = function () {
        let check = false;
        (function (a) {
            if (/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino|android|ipad|playbook|silk/i.test(a) || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0, 4))) check = true;
        })(navigator.userAgent || navigator.vendor || window.opera);
        return check;
    };
    let multiplier = mobileAndTabletCheck() ? 3 : 0.3;
    let container = document.getElementById('explore-container')
    new DragGesture(container, (state) => {
        container.style.cursor = 'grabbing'
        isDragging = true;
        update(currentRotation - (state.direction[0] <= 0 ? -1 : 1) * multiplier)
    }, {
        threshold: 0.2,
        axis: 'x',
        pointer: {
            touch: true,
        }
    })
}

onMounted(() => {
    // set timeout to wait animation to finish
    setTimeout(() => {
        init()
    }, settings.animationDuration)
})
</script>

<style scoped>
#explore {
    -ms-overflow-style: none; /* Internet Explorer 10+ */
    scrollbar-width: none; /* Firefox */
}

#explore::-webkit-scrollbar {
    display: none; /* Safari and Chrome */
}
</style>
