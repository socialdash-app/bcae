<template>
    <div id="navigation"
         :style="{height: height + 'px'}"
         class="flex shrink-0 w-screen overflow-y-auto overflow-x-hidden bg-[#BC6B60] items-center justify-start flex-col">
        <div id="navigation-container"
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
        <div class="shrink-0 absolute -z-10 w-full" id="navigation-trigger"
             :style="{ height: data.length * height + 'px' }">

        </div>
        <div class="shrink-0" :style="{ height: data.length * height + 'px' }">
        </div>
    </div>
</template>

<script setup>
import {reactive, onMounted} from "vue";
import anime from "animejs";
import {DragGesture} from "@use-gesture/vanilla";
import AnimeScrollTrigger from 'anime-scrolltrigger'

const props = defineProps([]);

const height = window.innerHeight;

const boxHeight = height / 2;
// console.log(paddingBottom, window.screen.height, window.innerHeight)

let data = [
    {
        description:
            "Going back to Home",
        box: "box1",
        icon: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8 lucide lucide-album"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><polyline points="11 3 11 11 14 8 17 11 17 3"/></svg>'
    },
    {
        description:
            "Explore the stricken history of military overthrowing people’s power in Myanmar",
        box: "box2",
        icon: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8 lucide lucide-align-center-horizontal"><path d="M2 12h20"/><path d="M10 16v4a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-4"/><path d="M10 8V4a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v4"/><path d="M20 16v1a2 2 0 0 1-2 2h-2a2 2 0 0 1-2-2v-1"/><path d="M14 8V7c0-1.1.9-2 2-2h2a2 2 0 0 1 2 2v1"/></svg>'
    },
    {
        description:
            "Explore the insights and results of 2020 election",
        box: "box3",
        icon: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8 lucide lucide-ampersand"><path d="M17.5 12c0 4.4-3.6 8-8 8A4.5 4.5 0 0 1 5 15.5c0-6 8-4 8-8.5a3 3 0 1 0-6 0c0 3 2.5 8.5 12 13"/><path d="M16 12h3"/></svg>'
    },
    {
        description:
            "Explore incidents during election and back-and-forth letters among different entities",
        box: "box4",
        icon: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8 lucide lucide-axe"><path d="m14 12-8.5 8.5a2.12 2.12 0 1 1-3-3L11 9"/><path d="M15 13 9 7l4-4 6 6h3a8 8 0 0 1-7 7z"/></svg>'
    },
    {
        description:
            "Explore how political parties respond to the dispute",
        box: "box5",
        icon: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8 lucide lucide-box"><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/></svg>'
    },
    {
        description:
            "Explore how Military intervened the dispute",
        box: "box6",
        icon: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-rabbit"><path d="M20 8.54V4a2 2 0 1 0-4 0v3"/><path d="M18 21h-8a4 4 0 0 1-4-4 7 7 0 0 1 7-7h.2L9.6 6.4a1.93 1.93 0 1 1 2.8-2.8L15.8 7h.2c3.3 0 6 2.7 6 6v1a2 2 0 0 1-2 2h-1c-1.7 0-3 1.3-3 3"/><path d="M7.61 12.53a3 3 0 1 0-1.6 4.3"/><path d="M13 16a3 3 0 0 1 2.24 5"/><path d="M18 12h.01"/></svg>'
    },
    {
        description:
            "Explore the protests and the disinformation outspread",
        box: "box7",
        icon: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-gitlab"><path d="m22 13.29-3.33-10a.42.42 0 0 0-.14-.18.38.38 0 0 0-.22-.11.39.39 0 0 0-.23.07.42.42 0 0 0-.14.18l-2.26 6.67H8.32L6.1 3.26a.42.42 0 0 0-.1-.18.38.38 0 0 0-.26-.08.39.39 0 0 0-.23.07.42.42 0 0 0-.14.18L2 13.29a.74.74 0 0 0 .27.83L12 21l9.69-6.88a.71.71 0 0 0 .31-.83Z"/></svg>'
    },
    {
        description:
            "Explore the beginning of the end of people’s power and summary of BCAE",
        box: "box8",
        icon: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8 lucide lucide-bus-front"><path d="M4 6 2 7"/><path d="M10 6h4"/><path d="m22 7-2-1"/><rect width="16" height="16" x="4" y="3" rx="2"/><path d="M4 11h16"/><path d="M8 15h.01"/><path d="M16 15h.01"/><path d="M6 19v2"/><path d="M18 21v-2"/></svg>'
    },
];
const init = () => {
    let descriptionContainer = document.getElementById("description-container");

    let ul = document.getElementById("boxes");

    let iconContainer = document.getElementById('icons');

    let navigation = document.getElementById('navigation');

    let height = (data.length * window.innerHeight) - window.innerHeight;

    // build boxes
    let boxes = [];
    let icons = [];
    let descriptions = [];
    let boxHeight = window.innerHeight * 0.35;

    data.forEach((d) => {
        let description = document.createElement("div");
        description.className = "description text-2xl sm:text-4xl font-bevietnampro font-bold text-center items-center justify-center  py-4   flex sm:items-center grow-0 sm:p-10 w-full shrink-0";
        description.innerText = d.description;
        descriptionContainer.appendChild(description);
        descriptions.push(description);

        let box = document.createElement("li");
        box.className = "box list-none bg-gray-300 absolute cursor-pointer border-gray-400 border  p-6 flex justify-center";
        box.style.touchAction = 'none'
        box.style.height = boxHeight + 'px';
        box.style.width = boxHeight + 'px';
        box.innerHTML = d.box;
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
            // console.log(currentBox);
            anime({
                targets: ul,
                rotateZ: -currentBox.deg,
                duration: 400,
                easing: "easeOutQuart"
            });
            anime({
                targets: iconContainer,
                rotateZ: -currentBox.deg,
                duration: 400,
                easing: "easeOutQuart",
            });
            descriptionContainer.scrollTo({
                left:
                    currentBox.index *
                    descriptions[currentBox.index].getBoundingClientRect().width,
                behavior: "smooth"
            });
            currentRotation = currentBox.deg;
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

    // let boxes = document.querySelectorAll("li");

    boxes.forEach((box, i) => {
        let rotate = i * deg;
        rotates.push({
            index: i,
            deg: rotate,
            box: box.innerText
        });
        // console.log(i * (boxHeight / 2) / Math.tan(deg), (window.innerHeight) * 0.85)
        box.style.transform = `rotate(${rotate}deg) translateY(-${(window.innerHeight) * 0.95}px)`;
        icons[i].style.transform = `rotate(${rotate}deg) translateY(-${(window.innerHeight) * 0.7}px)`;
        // box.style.transform = `rotate(${rotate}deg) translateY(${(boxHeight / 2) / Math.tan(deg)}px)`;
        // icons[i].style.transform = `rotate(${rotate}deg) translateY(-${(window.innerHeight) * 0.63}px)`;
        let progress = i / boxes.length;

        box.addEventListener('click', (e) => {
            if (isDragging) {
                isDragging = false;
                return;
            }
            console.log(progress)
            anime({
                targets: navigation,
                scrollTop: progress * height,
                easing: 'easeOutQuart',
                duration: 600,
            })
        })
    }, false);


    new AnimeScrollTrigger(document.getElementById('navigation'), [{
        scrollTrigger: {
            trigger: '#navigation-trigger',
            start: 'top top',
            end: 'bottom bottom',
            lerp: true,
            onUpdate: (_, progress) => {
                console.log(progress)
                update(progress * deg * data.length)
            }
        }
    }])
    //
    ul.style.touchAction = 'none'
    new DragGesture(ul, (state) => {
        console.log('drag')
        isDragging = true;
        update(currentRotation - (state.direction[0] < 0 ? -1 : 1) * 3)
    }, {
        threshold: 0.05,
        axis: 'x'
    })
}

onMounted(() => {
    setTimeout(() => {
        init()
    }, 1000)
})
</script>

<style scoped>
#navigation {
    -ms-overflow-style: none; /* Internet Explorer 10+ */
    scrollbar-width: none; /* Firefox */
}

#navigation::-webkit-scrollbar {
    display: none; /* Safari and Chrome */
}
</style>
