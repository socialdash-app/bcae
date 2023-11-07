<template>
    <div class="flex overflow-hidden w-screen relative items-center justify-start flex-col h-screen">
        <div id="description-container" class="w-11/12 sm:w-10/12 2xl:w-8/12 h-[300px] flex overflow-hidden">

        </div>
        <ul class="w-[300px] h-[300px] absolute bottom-[-600px] flex justify-center items-center">
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
            icon: "box1"
        },
        {
            description:
                "Box 2 Lorem amet, consectetur adipiscing elit. Suo genere perveniant ad extremum; Nosti, credo, illud: Nemo pius est, qui pietatem-; Quem si tenueris, non modo meum Ciceronem, sed etiam me ipsum abducas licebit. Duo Reges: constructio interrete. Huius, Lyco, oratione locuples, rebus ipsis ielunior. Quis tibi ergo istud dabit praeter Pyrrhonem, Aristonem eorumve similes, quos tu non probas? Quod quidem iam fit etiam in Academia. Quod quidem iam fit etiam in Academia. Eam tum adesse, cum dolor omnis absit; Certe, nisi voluptatem tanti aestimaretis. ",
            icon: "box2"
        },
        {
            description:
                "Box 3 Lorem amet, consectetur adipiscing elit. Suo genere perveniant ad extremum; Nosti, credo, illud: Nemo pius est, qui pietatem-; Quem si tenueris, non modo meum Ciceronem, sed etiam me ipsum abducas licebit. Duo Reges: constructio interrete. Huius, Lyco, oratione locuples, rebus ipsis ielunior. Quis tibi ergo istud dabit praeter Pyrrhonem, Aristonem eorumve similes, quos tu non probas? Quod quidem iam fit etiam in Academia. Quod quidem iam fit etiam in Academia. Eam tum adesse, cum dolor omnis absit; Certe, nisi voluptatem tanti aestimaretis. ",
            icon: "box3"
        },
        {
            description:
                "Box 4 Lorem amet, consectetur adipiscing elit. Suo genere perveniant ad extremum; Nosti, credo, illud: Nemo pius est, qui pietatem-; Quem si tenueris, non modo meum Ciceronem, sed etiam me ipsum abducas licebit. Duo Reges: constructio interrete. Huius, Lyco, oratione locuples, rebus ipsis ielunior. Quis tibi ergo istud dabit praeter Pyrrhonem, Aristonem eorumve similes, quos tu non probas? Quod quidem iam fit etiam in Academia. Quod quidem iam fit etiam in Academia. Eam tum adesse, cum dolor omnis absit; Certe, nisi voluptatem tanti aestimaretis. ",
            icon: "box4"
        },
        {
            description:
                "Box 5 Lorem amet, consectetur adipiscing elit. Suo genere perveniant ad extremum; Nosti, credo, illud: Nemo pius est, qui pietatem-; Quem si tenueris, non modo meum Ciceronem, sed etiam me ipsum abducas licebit. Duo Reges: constructio interrete. Huius, Lyco, oratione locuples, rebus ipsis ielunior. Quis tibi ergo istud dabit praeter Pyrrhonem, Aristonem eorumve similes, quos tu non probas? Quod quidem iam fit etiam in Academia. Quod quidem iam fit etiam in Academia. Eam tum adesse, cum dolor omnis absit; Certe, nisi voluptatem tanti aestimaretis. ",
            icon: "box5"
        },
        {
            description:
                "Box 6 Lorem amet, consectetur adipiscing elit. Suo genere perveniant ad extremum; Nosti, credo, illud: Nemo pius est, qui pietatem-; Quem si tenueris, non modo meum Ciceronem, sed etiam me ipsum abducas licebit. Duo Reges: constructio interrete. Huius, Lyco, oratione locuples, rebus ipsis ielunior. Quis tibi ergo istud dabit praeter Pyrrhonem, Aristonem eorumve similes, quos tu non probas? Quod quidem iam fit etiam in Academia. Quod quidem iam fit etiam in Academia. Eam tum adesse, cum dolor omnis absit; Certe, nisi voluptatem tanti aestimaretis. ",
            icon: "box6"
        },
        {
            description:
                "Box 7 Lorem amet, consectetur adipiscing elit. Suo genere perveniant ad extremum; Nosti, credo, illud: Nemo pius est, qui pietatem-; Quem si tenueris, non modo meum Ciceronem, sed etiam me ipsum abducas licebit. Duo Reges: constructio interrete. Huius, Lyco, oratione locuples, rebus ipsis ielunior. Quis tibi ergo istud dabit praeter Pyrrhonem, Aristonem eorumve similes, quos tu non probas? Quod quidem iam fit etiam in Academia. Quod quidem iam fit etiam in Academia. Eam tum adesse, cum dolor omnis absit; Certe, nisi voluptatem tanti aestimaretis. ",
            icon: "box7"
        },
        {
            description:
                "Box 8 Lorem amet, consectetur adipiscing elit. Suo genere perveniant ad extremum; Nosti, credo, illud: Nemo pius est, qui pietatem-; Quem si tenueris, non modo meum Ciceronem, sed etiam me ipsum abducas licebit. Duo Reges: constructio interrete. Huius, Lyco, oratione locuples, rebus ipsis ielunior. Quis tibi ergo istud dabit praeter Pyrrhonem, Aristonem eorumve similes, quos tu non probas? Quod quidem iam fit etiam in Academia. Quod quidem iam fit etiam in Academia. Eam tum adesse, cum dolor omnis absit; Certe, nisi voluptatem tanti aestimaretis. ",
            icon: "box8"
        },
        {
            description:
                "Box 9 Lorem amet, consectetur adipiscing elit. Suo genere perveniant ad extremum; Nosti, credo, illud: Nemo pius est, qui pietatem-; Quem si tenueris, non modo meum Ciceronem, sed etiam me ipsum abducas licebit. Duo Reges: constructio interrete. Huius, Lyco, oratione locuples, rebus ipsis ielunior. Quis tibi ergo istud dabit praeter Pyrrhonem, Aristonem eorumve similes, quos tu non probas? Quod quidem iam fit etiam in Academia. Quod quidem iam fit etiam in Academia. Eam tum adesse, cum dolor omnis absit; Certe, nisi voluptatem tanti aestimaretis. ",
            icon: "box9"
        }
    ];

    let descriptionContainer = document.getElementById("description-container");

    let ul = document.querySelector("ul");

// build boxes
    let boxes = [];
    let descriptions = [];
    let boxHeight = window.innerHeight * 0.4;

    console.log(boxHeight)
    data.forEach((d) => {
        let description = document.createElement("div");
        description.className = "description grow-0 p-10 w-full flex items-center justify-center shrink-0";
        description.innerText = d.description;
        descriptionContainer.appendChild(description);
        descriptions.push(description);

        let box = document.createElement("li");
        box.className = "box list-none absolute cursor-pointer border-gray-400  border-2 p-6 flex justify-center rounded";
        box.style.height = boxHeight + 'px';
        box.style.width = boxHeight + 'px';
        box.innerHTML = d.icon;
        ul.appendChild(box);
        boxes.push(box);
    });

// let boxes = document.querySelectorAll("li");
    let rotates = [];
    let deg = 360 / (boxes.length + 1);
    boxes.forEach((box, i) => {
        let rotate = i * deg;
        rotates.push({
            index: i,
            deg: rotate,
            box: box.innerText
        });
        let translateX = window.innerHeight;
        box.style.transform = `rotate(${rotate}deg) translateY(-${translateX}px)`;
    });

    let currentRotation = 0;
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
