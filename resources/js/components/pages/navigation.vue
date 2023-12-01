<template>
    <div class="flex overflow-hidden w-screen relative items-center justify-start flex-col h-screen">
        <div id="description-container" class="w-11/12 sm:w-10/12 2xl:w-8/12 h-[300px] flex overflow-hidden">

        </div>
        <ul id="boxes" class="w-[300px] h-[300px] absolute bottom-[-600px] flex justify-center items-center">
        </ul>
        <ul id="icons" class="w-[300px] h-[300px] absolute bottom-[-500px] flex justify-center items-center">
        </ul>
    </div>
</template>

<script setup>
import {reactive, onMounted} from "vue";
import anime from "animejs";
import Hammer from 'hammerjs'

const props = defineProps([]);

const data = reactive({});

const init = () => {
    let data = [
        {
            description:
                "Box 1 Lorem amet, consectetur adipiscing elit. Suo genere perveniant ad extremum; Nosti, credo, illud: Nemo pius est, qui pietatem-; Quem si tenueris, non modo meum Ciceronem, sed etiam me ipsum abducas licebit. Duo Reges: constructio interrete. Huius, Lyco, oratione locuples, rebus ipsis ielunior. Quis tibi ergo istud dabit praeter Pyrrhonem, Aristonem eorumve similes, quos tu non probas? Quod quidem iam fit etiam in Academia. Quod quidem iam fit etiam in Academia. Eam tum adesse, cum dolor omnis absit; Certe, nisi voluptatem tanti aestimaretis. ",
            box: "box1",
            icon: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8 lucide lucide-album"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><polyline points="11 3 11 11 14 8 17 11 17 3"/></svg>'
        },
        {
            description:
                "Box 2 Lorem amet, consectetur adipiscing elit. Suo genere perveniant ad extremum; Nosti, credo, illud: Nemo pius est, qui pietatem-; Quem si tenueris, non modo meum Ciceronem, sed etiam me ipsum abducas licebit. Duo Reges: constructio interrete. Huius, Lyco, oratione locuples, rebus ipsis ielunior. Quis tibi ergo istud dabit praeter Pyrrhonem, Aristonem eorumve similes, quos tu non probas? Quod quidem iam fit etiam in Academia. Quod quidem iam fit etiam in Academia. Eam tum adesse, cum dolor omnis absit; Certe, nisi voluptatem tanti aestimaretis. ",
            box: "box2",
            icon: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8 lucide lucide-align-center-horizontal"><path d="M2 12h20"/><path d="M10 16v4a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-4"/><path d="M10 8V4a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v4"/><path d="M20 16v1a2 2 0 0 1-2 2h-2a2 2 0 0 1-2-2v-1"/><path d="M14 8V7c0-1.1.9-2 2-2h2a2 2 0 0 1 2 2v1"/></svg>'
        },
        {
            description:
                "Box 3 Lorem amet, consectetur adipiscing elit. Suo genere perveniant ad extremum; Nosti, credo, illud: Nemo pius est, qui pietatem-; Quem si tenueris, non modo meum Ciceronem, sed etiam me ipsum abducas licebit. Duo Reges: constructio interrete. Huius, Lyco, oratione locuples, rebus ipsis ielunior. Quis tibi ergo istud dabit praeter Pyrrhonem, Aristonem eorumve similes, quos tu non probas? Quod quidem iam fit etiam in Academia. Quod quidem iam fit etiam in Academia. Eam tum adesse, cum dolor omnis absit; Certe, nisi voluptatem tanti aestimaretis. ",
            box: "box3",
            icon: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8 lucide lucide-ampersand"><path d="M17.5 12c0 4.4-3.6 8-8 8A4.5 4.5 0 0 1 5 15.5c0-6 8-4 8-8.5a3 3 0 1 0-6 0c0 3 2.5 8.5 12 13"/><path d="M16 12h3"/></svg>'
        },
        {
            description:
                "Box 4 Lorem amet, consectetur adipiscing elit. Suo genere perveniant ad extremum; Nosti, credo, illud: Nemo pius est, qui pietatem-; Quem si tenueris, non modo meum Ciceronem, sed etiam me ipsum abducas licebit. Duo Reges: constructio interrete. Huius, Lyco, oratione locuples, rebus ipsis ielunior. Quis tibi ergo istud dabit praeter Pyrrhonem, Aristonem eorumve similes, quos tu non probas? Quod quidem iam fit etiam in Academia. Quod quidem iam fit etiam in Academia. Eam tum adesse, cum dolor omnis absit; Certe, nisi voluptatem tanti aestimaretis. ",
            box: "box4",
            icon: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8 lucide lucide-axe"><path d="m14 12-8.5 8.5a2.12 2.12 0 1 1-3-3L11 9"/><path d="M15 13 9 7l4-4 6 6h3a8 8 0 0 1-7 7z"/></svg>'
        },
        {
            description:
                "Box 5 Lorem amet, consectetur adipiscing elit. Suo genere perveniant ad extremum; Nosti, credo, illud: Nemo pius est, qui pietatem-; Quem si tenueris, non modo meum Ciceronem, sed etiam me ipsum abducas licebit. Duo Reges: constructio interrete. Huius, Lyco, oratione locuples, rebus ipsis ielunior. Quis tibi ergo istud dabit praeter Pyrrhonem, Aristonem eorumve similes, quos tu non probas? Quod quidem iam fit etiam in Academia. Quod quidem iam fit etiam in Academia. Eam tum adesse, cum dolor omnis absit; Certe, nisi voluptatem tanti aestimaretis. ",
            box: "box5",
            icon: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8 lucide lucide-box"><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/></svg>'
        },
        {
            description:
                "Box 6 Lorem amet, consectetur adipiscing elit. Suo genere perveniant ad extremum; Nosti, credo, illud: Nemo pius est, qui pietatem-; Quem si tenueris, non modo meum Ciceronem, sed etiam me ipsum abducas licebit. Duo Reges: constructio interrete. Huius, Lyco, oratione locuples, rebus ipsis ielunior. Quis tibi ergo istud dabit praeter Pyrrhonem, Aristonem eorumve similes, quos tu non probas? Quod quidem iam fit etiam in Academia. Quod quidem iam fit etiam in Academia. Eam tum adesse, cum dolor omnis absit; Certe, nisi voluptatem tanti aestimaretis. ",
            box: "box6",
            icon: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-rabbit"><path d="M20 8.54V4a2 2 0 1 0-4 0v3"/><path d="M18 21h-8a4 4 0 0 1-4-4 7 7 0 0 1 7-7h.2L9.6 6.4a1.93 1.93 0 1 1 2.8-2.8L15.8 7h.2c3.3 0 6 2.7 6 6v1a2 2 0 0 1-2 2h-1c-1.7 0-3 1.3-3 3"/><path d="M7.61 12.53a3 3 0 1 0-1.6 4.3"/><path d="M13 16a3 3 0 0 1 2.24 5"/><path d="M18 12h.01"/></svg>'
        },
        {
            description:
                "Box 7 Lorem amet, consectetur adipiscing elit. Suo genere perveniant ad extremum; Nosti, credo, illud: Nemo pius est, qui pietatem-; Quem si tenueris, non modo meum Ciceronem, sed etiam me ipsum abducas licebit. Duo Reges: constructio interrete. Huius, Lyco, oratione locuples, rebus ipsis ielunior. Quis tibi ergo istud dabit praeter Pyrrhonem, Aristonem eorumve similes, quos tu non probas? Quod quidem iam fit etiam in Academia. Quod quidem iam fit etiam in Academia. Eam tum adesse, cum dolor omnis absit; Certe, nisi voluptatem tanti aestimaretis. ",
            box: "box7",
            icon: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-gitlab"><path d="m22 13.29-3.33-10a.42.42 0 0 0-.14-.18.38.38 0 0 0-.22-.11.39.39 0 0 0-.23.07.42.42 0 0 0-.14.18l-2.26 6.67H8.32L6.1 3.26a.42.42 0 0 0-.1-.18.38.38 0 0 0-.26-.08.39.39 0 0 0-.23.07.42.42 0 0 0-.14.18L2 13.29a.74.74 0 0 0 .27.83L12 21l9.69-6.88a.71.71 0 0 0 .31-.83Z"/></svg>'
        },
        {
            description:
                "Box 8 Lorem amet, consectetur adipiscing elit. Suo genere perveniant ad extremum; Nosti, credo, illud: Nemo pius est, qui pietatem-; Quem si tenueris, non modo meum Ciceronem, sed etiam me ipsum abducas licebit. Duo Reges: constructio interrete. Huius, Lyco, oratione locuples, rebus ipsis ielunior. Quis tibi ergo istud dabit praeter Pyrrhonem, Aristonem eorumve similes, quos tu non probas? Quod quidem iam fit etiam in Academia. Quod quidem iam fit etiam in Academia. Eam tum adesse, cum dolor omnis absit; Certe, nisi voluptatem tanti aestimaretis. ",
            box: "box8",
            icon: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8 lucide lucide-bus-front"><path d="M4 6 2 7"/><path d="M10 6h4"/><path d="m22 7-2-1"/><rect width="16" height="16" x="4" y="3" rx="2"/><path d="M4 11h16"/><path d="M8 15h.01"/><path d="M16 15h.01"/><path d="M6 19v2"/><path d="M18 21v-2"/></svg>'
        },
        {
            description:
                "Box 9 Lorem amet, consectetur adipiscing elit. Suo genere perveniant ad extremum; Nosti, credo, illud: Nemo pius est, qui pietatem-; Quem si tenueris, non modo meum Ciceronem, sed etiam me ipsum abducas licebit. Duo Reges: constructio interrete. Huius, Lyco, oratione locuples, rebus ipsis ielunior. Quis tibi ergo istud dabit praeter Pyrrhonem, Aristonem eorumve similes, quos tu non probas? Quod quidem iam fit etiam in Academia. Quod quidem iam fit etiam in Academia. Eam tum adesse, cum dolor omnis absit; Certe, nisi voluptatem tanti aestimaretis. ",
            box: "box9",
            icon: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-ghost w-8 h-8"><path d="M9 10h.01"/><path d="M15 10h.01"/><path d="M12 2a8 8 0 0 0-8 8v12l3-3 2.5 2.5L12 19l2.5 2.5L17 19l3 3V10a8 8 0 0 0-8-8z"/></svg>'
        }
    ];

    let descriptionContainer = document.getElementById("description-container");

    let ul = document.getElementById("boxes");

    let iconContainer = document.getElementById('icons');

// build boxes
    let boxes = [];
    let icons = [];
    let descriptions = [];
    let boxHeight = window.innerHeight * 0.35;

    data.forEach((d) => {
        let description = document.createElement("div");
        description.className = "description grow-0 p-10 w-full flex items-center justify-center shrink-0";
        description.innerText = d.description;
        descriptionContainer.appendChild(description);
        descriptions.push(description);

        let box = document.createElement("li");
        box.className = "box list-none absolute cursor-pointer border-gray-400 border  p-6 flex justify-center";
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

// let boxes = document.querySelectorAll("li");
    let rotates = [];
    let currentRotation = 0;
    let deg = 360 / (boxes.length + 1);
    boxes.forEach((box, i) => {
        let rotate = i * deg;
        rotates.push({
            index: i,
            deg: rotate,
            box: box.innerText
        });
        box.style.transform = `rotate(${rotate}deg) translateY(-${window.innerHeight * 0.8}px)`;
        icons[i].style.transform = `rotate(${rotate}deg) translateY(-${window.innerHeight * 0.4}px)`;

        box.addEventListener('click', () => {
            descriptionContainer.scrollTo({
                left:
                    i *
                    descriptions[i].getBoundingClientRect().width,
                behavior: "smooth"
            });
            anime({
                targets: ul,
                rotateZ: -rotate,
                duration: 400,
                easing: "easeOutQuad",
            });
            anime({
                targets: iconContainer,
                rotateZ: -rotate,
                duration: 400,
                easing: "easeOutQuad",
            });
            currentRotation = rotate
        })
    });


    let currentBox = null;
    let timeout = null;
    let update = function (angle) {
        if (timeout) clearTimeout(timeout);
        currentRotation += angle;
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
                easing: "easeOutQuad"
            });
            anime({
                targets: iconContainer,
                rotateZ: -currentBox.deg,
                duration: 400,
                easing: "easeOutQuad",
            });
            descriptionContainer.scrollTo({
                left:
                    currentBox.index *
                    descriptions[currentBox.index].getBoundingClientRect().width,
                behavior: "smooth"
            });
            currentRotation = currentBox.deg;
        }, 400);
        anime({
            targets: ul,
            rotateZ: -currentRotation,
            duration: 50,
            easing: "linear",
            delay: 10
        });
        anime({
            targets: iconContainer,
            rotateZ: -currentRotation,
            duration: 50,
            easing: "linear",
            delay: 10
        });
    };
    document.addEventListener("wheel", function (e) {
        update(e.deltaY * 0.1);
    });

    ul.querySelectorAll("li").forEach((li) => {
        const hammertime = new Hammer(li);
        hammertime.on("panleft", (e) => {
            update(e.deltaX * 0.1);
        });
        hammertime.on("panright", (e) => {
            update(e.deltaX * 0.1);
        });
    });

}

onMounted(() => {
    console.log('nav')
    init()
})
</script>

<style scoped>

</style>
