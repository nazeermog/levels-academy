@extends("student.layouts.dashboard")
@push('css')
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65"
        crossorigin="anonymous"
    />
    <style>
        body {
            background-color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .abacus {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: 100vh;
        }

        #abacus {
            display: flex;
            justify-content: center;
            position: relative;
        }

        #abacus::after {
            content: "";
            width: 15px;
            border-radius: 100px 100px 75px 75px;
            height: 100%;
            background: #878687;
            position: absolute;
            left: -45px;
        }

        #abacus::before {
            content: "";
            width: 15px;
            border-radius: 100px 100px 75px 75px;
            height: 100%;
            background: #878687;
            position: absolute;
            right: -45px;
        }

        .stander {
            width: calc(100% + 90px);
            border-radius: 100px 100px 75px 75px;
            height: 15px;
            background: #878687;
            position: relative;
        }

        .stander:first-child {
            position: absolute;
            top: 0;
            z-index: 111;
        }

        .stander:last-child {
            position: absolute;
            bottom: 0;
            z-index: 111;
        }

        .rods {
            display: flex;
            /*flex-direction: row-reverse;*/
            height: 205px;
            width: 100%;
        }

        .one-rod:not(:last-child) {
            margin-left: 30px;
        }

        .rod-top {
            height: 70px;
            position: relative;
        }

        .rod-top .rod {
            display: flex;
            flex-direction: column;
            background: #878687;
            align-items: center;
            padding: 0 5px;
            width: 10px;
            height: 100%;
        }

        .rod-top .beads {
            display: flex;
            flex-direction: column;
            justify-content: end;
            height: 100%;
            padding: 15px 0;
            padding-bottom: 10px;
        }

        .rod-top .bead-top {
            width: 30px;
            height: 20px;
            background: #489fb7;
            border-radius: 20%;
            transition: margin-bottom 0.5s;
            box-shadow: inset 0 -10px 10px -10px #000000, inset 0px 0px 2px rgba(0, 0, 0, 0.5);
        }

        .rod-top .bead-top.active {
            margin-bottom: 25px;
        }

        .rod-top::before {
            content: "";
            width: 70px;
            height: 10px;
            background-color: #878687;
            position: absolute;
            left: 50%;
            bottom: 0;
            transform: translateX(-50%);
        }

        .rod-bottom {
            height: 135px;
        }

        .rod-bottom .rod {
            display: flex;
            flex-direction: column;
            background: #878687;
            align-items: center;
            padding: 0 5px;
            width: 10px;
            height: 100%;
        }

        .rod-bottom .beads {
            display: flex;
            flex-direction: column;
            justify-content: end;
            height: 100%;
            padding: 15px 0;
            padding-top: 0;
        }

        .rod-bottom .bead-down {
            width: 30px;
            height: 20px;
            background: #489fb7;
            border-radius: 20%;
            box-shadow: inset 0 -10px 10px -10px #000000, inset 0px 0px 2px rgba(0, 0, 0, 0.5);
            transition: margin-bottom 0.5s;
        }

        .rod-bottom .bead-down.active {
            margin-bottom: 40px;
        }

        /*# sourceMappingURL=main.css.map */
    </style>
    <link rel="stylesheet" href="./assets/style/style.css"/>
@endpush
@section("content")

    <div class="container pt-5 input-section">
        <div class="row">
            <div class="col-sm-4 mx-auto text-center">
                <p>Enter the number of columns</p>
                <input type="number" class="form-control" id="rodsNumber"/>
                <button class="btn btn-secondary mt-2" id="start-game">Start</button>
            </div>
        </div>
    </div>
    <div class="abacus d-none">
        <p id="feedback" class="fs-4 text-success fw-bold"></p>
        <div id="abacus">
            <div class="stander"></div>
            <div class="rods"></div>
            <div class="stander"></div>
            <!-- <button class="btn btn-primary">submit</button> -->
        </div>
        <div class="submit mt-4" id="submit">
            <button class="btn btn-primary">Submit</button>
            <button class="btn btn-primary ms-3 d-none" id="nextStep" disabled>
                Next
            </button>
        </div>
    </div>


@endsection

@push('js')
    <script
        src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3"
        crossorigin="anonymous"
    ></script>
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
        integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V"
        crossorigin="anonymous"
    ></script>
<script>

    const data = [
        [0, 0, 0, 0, 0],
        [0, 0, 0, 0, 0],
        [0, 0, 0, 0, 0],
        [0, 0, 0, 0, 0],
        [0, 0, 0, 0, 0],
        [0, 0, 0, 0, 0],

    ];
    const result = [
        [1, 1, 1, 1, 1],
        [0, 1, 1, 1, 1],
        [1, 1, 1, 1, 1],
        [0, 1, 1, 1, 1],
        [1, 1, 1, 1, 1],
        [0, 1, 1, 1, 1],
    ];
    console.log(data.length);
    const abacus = document.querySelector(".abacus");
    const inputSection = document.querySelector(".input-section");
    const feedback = document.querySelector("#feedback");
    const nextStep = document.getElementById("nextStep");
    function createRod(col) {
        const rods = document.querySelector(".rods");
        const html = `<div class="one-rod">
  <div class="rod-top">
    <div class="rod">
      <div class="beads">
        <div class="bead bead-top"></div>
      </div>
    </div>
  </div>
  <div class="rod-bottom">
    <div class="rod">
      <div class="beads">
        <div class="bead bead-down"></div>
        <div class="bead bead-down"></div>
        <div class="bead bead-down"></div>
        <div class="bead bead-down"></div>
      </div>
    </div>
  </div>
</div>`;

        for (let i = 0; i < col; i++) {
            rods.insertAdjacentHTML("afterbegin", html);
        }
    }

    function startGame(rodNumber) {
        abacus.classList.remove("d-none");
        inputSection.classList.add("d-none");
        createRod(rodNumber);
        const rods = document.querySelectorAll(".one-rod");
        rods.forEach((rod, index) => {
            const beadsDown = rod.querySelectorAll(".bead-down");
            const beads = rod.querySelectorAll(".bead");
            beads.forEach((bead) => {
                bead.setAttribute("data-item", "0");
            });
            beadsDown.forEach((bead, item) => {
                bead.addEventListener("click", function () {
                    const currentValue = Number(this.getAttribute("data-item"));
                    const beadsDownIndex = beadsDown.length - 1;

                    beadsDown.forEach((bead) => {
                        bead.setAttribute("data-item", "0");
                        bead.classList.remove("active");
                    });
                    if (item != 0) {
                        bead.classList.add("active");
                        for (let i = item; i >= 0; i--) {
                            beadsDown[i].setAttribute("data-item", "1");
                        }
                    } else {
                        if (currentValue === 0) {
                            this.setAttribute("data-item", "1");
                            this.classList.add("active");
                        } else {
                            this.setAttribute("data-item", "0");
                            this.classList.remove("active");
                        }
                    }
                });
            });

            const beadTop = rod.querySelector(".bead-top");
            beadTop.addEventListener("click", function () {
                const beadTopValue = Number(beadTop.getAttribute("data-item"));
                if (beadTopValue === 0) {
                    this.setAttribute("data-item", "1");
                    this.classList.add("active");
                } else {
                    this.setAttribute("data-item", "0");
                    this.classList.remove("active");
                }
            });
        });
        dataStart(data);

        const submit = document.querySelector("#submit");

        submit.addEventListener("click", function () {
            let arrResult = [];
            for (let i = 0; i < rods.length; i++) {
                const bead = rods[i].querySelectorAll(".bead");
                let subArr = [];

                for (let j = 0; j < bead.length; j++) {
                    const beadValue = bead[j].getAttribute("data-item");
                    subArr.push(beadValue);
                }
                subArr.reverse();
                arrResult.push(subArr);
            }
            console.log(arrResult);
            if (compareResult(result, arrResult)) {
                feedback.textContent = "The answer is correct";
                feedback.classList.add("text-success");
                nextStep.disabled = false;
                nextStep.classList.remove("d-none");
            } else {
                feedback.textContent = "The answer is not correct";
                feedback.classList.add("text-danger");
                nextStep.disabled = false;
                nextStep.classList.remove("d-none");
                dataStart(result);
            }
        });
    }

    function dataStart(dataBead) {
        const rodsContainer = document.querySelector(".rods");
        // Loop through each rod
        const rods = rodsContainer.querySelectorAll(".one-rod");
        rods.forEach((rod, index) => {
            const beads = rod.querySelectorAll(".bead");
            const beadsArr = Array.prototype.slice.call(beads);
            // Loop through each bead and update data-item value
            beadsArr.reverse().forEach((bead, i) => {
                bead.dataset.item = dataBead[index][i];
            });
            const beadDown = rod.querySelectorAll(".bead-down");
            const beadUp = rod.querySelector(".bead-top");
            const beadDownArr = Array.prototype.slice.call(beadDown);
            const test = beadDownArr.reverse().find((ele) => ele.dataset.item == 1);
            if (test) {
                test.classList.add("active");
            }
            if (beadUp.dataset.item == 1) {
                beadUp.classList.add("active");
            }
        });
    }

    function compareResult(arr1, arr2) {
        return JSON.stringify(arr1) === JSON.stringify(arr2);
    }

    if (compareResult(data, result)) {
        console.log("true");
    } else {
        console.log("false");
    }

    const rodsNumber = document.getElementById("rodsNumber");
    const startBtn = document.getElementById("start-game");
    startGame(data.length);
    // startBtn.addEventListener("click", function () {
    //   startGame(rodsNumber.value);
    //   if (data.length > 0) {
    //     setTimeout(() => {
    //       dataStart();
    //     }, 100);
    //   }
    // });

</script>
@endpush
